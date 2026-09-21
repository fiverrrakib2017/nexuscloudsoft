<?php
namespace App\Jobs;
use App\Models\Customer;
use App\Models\Router;
use App\Models\Daily_usages;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use RouterOS\Client;
use RouterOS\Query;
use Carbon\Carbon;

class Customer_usages implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $routerId;
    public int $timeout = 180;
    public int $tries   = 2;

    public function __construct(int $routerId)
    {
        $this->routerId = $routerId;
    }

    public function handle(): void
    {
        $router = Router::where('id', $this->routerId)
            ->where('status', 'active')
            ->first();

        if (!$router) {
            Log::warning("CustomerUsages: Router not found or inactive [ID: {$this->routerId}]");
            return;
        }

        try {
            $client = new Client([
                'host'     => $router->ip_address,
                'user'     => $router->username,
                'pass'     => $router->password,
                'port'     => (int) ($router->port ?? 8728),
                'timeout'  => 5,
                'attempts' => 1,
            ]);

            $rawSessions   = $client->query(new Query('/ppp/active/print'))->read();
            $rawInterfaces = $client->query(new Query('/interface/print'))->read();
            $rawArps       = $client->query(new Query('/ip/arp/print'))->read();

            if (empty($rawSessions)) {
                return;
            }

            $sessions = [];
            foreach ($rawSessions as $sess) {
                if (!empty($sess['name'])) {
                    $sessions[$sess['name']] = $sess;
                }
            }

            $arps = [];
            foreach ($rawArps as $arp) {
                if (!empty($arp['address'])) {
                    $arps[$arp['address']] = $arp['mac-address'] ?? null;
                }
            }

            $interfaces = [];
            foreach ($rawInterfaces as $intf) {
                if (!empty($intf['name'])) {
                    $cleanName = str_replace(['<pppoe-', '>'], '', $intf['name']);
                    $interfaces[$cleanName] = $intf;
                }
            }

            $today = Carbon::today()->toDateString();
            $bulkData = [];

            Customer::query()
                ->where('router_id', $router->id)
                ->where('is_delete', 0)
                ->where('connection_type', 'pppoe')
                ->whereNotIn('status', ['expired', 'disabled', 'discontinue','blocked'])
                ->select('id', 'username', 'router_id')
                ->chunkById(500, function ($customers) use ($sessions, $arps, $interfaces, $today, $router, &$bulkData) {

                    foreach ($customers as $customer) {
                        $username = $customer->username;

                        if (!isset($sessions[$username])) {
                            continue;
                        }

                        $session = $sessions[$username];
                        $sessionId = isset($session['session-id']) ? trim((string)$session['session-id']) : null;

                        if (empty($sessionId)) {
                            continue;
                        }

                        $ipAddress  = $session['address'] ?? null;
                        $macAddress = $session['caller-id'] ?? null;

                        if ($ipAddress && isset($arps[$ipAddress])) {
                            $macAddress = $arps[$ipAddress] ?? $macAddress;
                        }
                        $rxMb = 0;
                        $txMb = 0;
                        if (isset($interfaces[$username])) {
                            $intf = $interfaces[$username];
                            $rxMb = isset($intf['rx-byte']) ? round($intf['rx-byte'] / 1048576, 2) : 0;
                            $txMb = isset($intf['tx-byte']) ? round($intf['tx-byte'] / 1048576, 2) : 0;
                        }

                        /*--------Bulk Insert -----------*/
                        $bulkData[] = [
                            'session_id'  => $sessionId,
                            'customer_id' => $customer->id,
                            'date'        => $today,
                            'router_id'   => $router->id,
                            'ip'          => $ipAddress,
                            'mac'         => $macAddress,
                            'upload'      => $txMb,
                            'download'    => $rxMb,
                            'created_at'  => now(),
                            'updated_at'  => now(),
                        ];
                    }
                });

            if (!empty($bulkData)) {
                foreach (array_chunk($bulkData, 500) as $chunk) {
                    Daily_usages::upsert(
                        $chunk,
                        ['session_id'],
                        ['customer_id', 'date', 'router_id', 'ip', 'mac', 'upload', 'download', 'updated_at']
                    );
                }
            }

        } catch (\Throwable $e) {
            Log::error('CustomerUsage job error', [
                'domain'    => request()->getHost(),
                'router_id' => $this->routerId,
                'error'     => $e->getMessage(),
            ]);
        }
    }
}
