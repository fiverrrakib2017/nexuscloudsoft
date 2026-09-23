<?php

namespace App\Jobs;
use App\Models\Customer_recharge;
use App\Models\Branch_package;
use App\Models\Send_message;
use App\Models\Customer;
use Carbon\Carbon;
use function App\Helpers\send_message;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAutoMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected  $customer_id=null;
    protected  $message_template=null;
    public function __construct($customer_id,$message_template)
    {
        $this->customer_id          =   $customer_id;
        $this->message_template     =   $message_template;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /*--------- Get customer -----------*/
        $customer = Customer::find($this->customer_id);
        if(!$customer) return;
        /*--------- Get customer Due Calculation -----------*/
        $credit_recharges = Customer_recharge::where('customer_id', $customer->id)
        ->where('transaction_type', 'credit')
        ->get(['recharge_month', 'amount']);

        $due_paids = Customer_recharge::where('customer_id', $customer->id)
        ->where('transaction_type', 'due_paid')
        ->get(['recharge_month', 'amount']);

        $paid_months = $due_paids->pluck('recharge_month')->toArray();
        $total_due = 0;
        foreach ($credit_recharges as $credit) {
            if (!in_array($credit->recharge_month, $paid_months)) {
                $total_due += $credit->amount;
            }
        }
        if(!preg_match('/^(?:\+88)?01[3-9]\d{8}$/', $customer->phone)){
            return;
        }

        /* Prepare dynamic message */
        $message = str_replace(
            ['{id}','{username}', '{mobile}', '{area}', '{package}', '{expire_date}', '{pop}','{due}'],
            [
                $customer->id ?? '',
                $customer->username ?? '',
                $customer->phone ?? '',
                $customer->area->name ?? '',
                Branch_package::find($customer->package_id)->name ?? '',
                $customer->expire_date ?? '',
                $customer->pop->name ?? '',
                $total_due > 0 ? $total_due : 0
            ],
            $this->message_template
        );

        /*------------ Create a new Instance ---------*/
        $object = new Send_message();
        $object->pop_id         = $customer->pop_id;
        $object->area_id        = $customer->area_id;
        $object->customer_id    = $customer->id;
        $object->message        = $message;
        $object->sent_at        = Carbon::now();

        /*-------- Call Send Message Function --------*/
        send_message($customer->phone, $message);

        /* Save to the database table */
        $object->save();
    }
}
