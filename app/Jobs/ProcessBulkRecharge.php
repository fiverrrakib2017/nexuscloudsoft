<?php
namespace App\Jobs;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Customer;
use App\Models\Customer_recharge;
use function App\Helpers\process_customer_single_recharge;
use function App\Helpers\check_pop_balance;
class ProcessBulkRecharge implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 3600;
    protected $customerIds;
    protected $validMonths;
    protected $transactionType;
    protected $note;
    protected $adminId;

    public function __construct(array $customerIds, array $validMonths, string $transactionType, ?string $note, int $adminId)
    {
        $this->customerIds = $customerIds;
        $this->validMonths = $validMonths;
        $this->transactionType = $transactionType;
        $this->note = $note;
        $this->adminId = $adminId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        ini_set('memory_limit', '-1');
        set_time_limit(0);
        Customer::whereIn('id', $this->customerIds)->chunk(500, function ($customers) {
            foreach ($customers as $customer) {
                try {
                    $monthsCount = count($this->validMonths);
                    $totalAmount = $customer->amount * $monthsCount;

                    /*-------POP Balance Check--------*/
                    $pop_balance = check_pop_balance($customer->pop_id);
                    if ($pop_balance < $totalAmount) {
                        Log::warning("Bulk Recharge Skipped for Customer ID {$customer->id}: Insufficient POP balance.");
                        continue;
                    }

                    /*-------Check Alreay Recharge-------*/
                    $alreadyRecharged = Customer_recharge::where('customer_id', $customer->id)
                        ->whereIn('recharge_month', $this->validMonths)
                        ->exists();

                    if ($alreadyRecharged) {
                        continue;
                    }

                    DB::transaction(function () use ($customer, $totalAmount) {
                        process_customer_single_recharge(
                            $customer->id,
                            $this->validMonths,
                            $this->transactionType,
                            $totalAmount,
                            $this->note ?? 'Bulk Recharge',
                            null
                        );
                    });

                } catch (\Exception $e) {
                    Log::error("Error recharging customer ID {$customer->id}: " . $e->getMessage());
                }
            }
        });
    }
}
