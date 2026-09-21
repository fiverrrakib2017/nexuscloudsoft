<?php

namespace App\Console\Commands\Customer;
use App\Models\Auto_message;
use App\Models\Customer;
use Illuminate\Console\Command;

class send_auto_message extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send_auto_message';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $targetDate = now()->addDays(2)->toDateString();

        $get_message_template = Auto_message::where('key', 'bill_due_reminder')
        ->where('is_active', true)
        ->first();

        if(empty($get_message_template)){
            $this->warn('Template bill_due_reminder not found or inactive.');
             return;
        }
        $_all_customer = Customer::whereDate('expire_date', $targetDate)
        ->whereNotNull('phone')
        ->whereRaw("phone REGEXP '^[0-9]{11}$'")
        ->where('is_delete', '0')
        // ->where('username', 'test_name')
        ->whereNotIn('status', ['expired', 'disabled', 'discontinue'])->get();

        foreach($_all_customer as $customer){
           dispatch(new \App\Jobs\SendAutoMessage(
            $customer->id,
            $get_message_template->body
            ))->onQueue('sms_queue');
        }
        $this->info("Total {$_all_customer->count()} customers queued for SMS.");

    }
}
