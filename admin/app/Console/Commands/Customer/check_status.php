<?php

namespace App\Console\Commands\Customer;

use App\Jobs\CheckCustomerStatus;
use RouterOS\Client;
use RouterOS\Query;
use App\Models\Customer;
use App\Models\Router;
use Illuminate\Console\Command;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Services\SessionService;
class check_status extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check_status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run ISP related automated tasks';

    /**
     * Execute the console command.
     */
    public function handle(SessionService $session_service)
    {

        try {

            $this->info('---Tasks Started ---');

            $routers = Router::where('status', 'active')->get();

            foreach($routers as $item){

                dispatch(new CheckCustomerStatus($item->id));
            }

            $this->info('---Tasks Finished ---');

        } catch (\Throwable $e) {

            Log::error('Check Status Failed', [
                'message' => $e->getMessage()
            ]);

        } 
    }
}
