<?php

namespace App\Console\Commands\Customer;
use App\Models\Pop_branch;
use App\Models\Bill_target;
use Illuminate\Console\Command;
use function App\Helpers\customer_bill_generate;
use function App\Helpers\customer_over_due_list;
class monthly_bill_target extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:monthly_bill_target';

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
        $_current_month             = now()->month;
        $_current_year              = now()->year;
        $_current_month_formate     = now()->format('Y-m');
        $get_all_active_pop_id      = Pop_branch::where('status','1')->pluck('id');

        /*---------------------------------*/
        foreach($get_all_active_pop_id as $pop_id){
            $is_target_exist = Bill_target::where([
                'month'     => $_current_month,
                'year'      => $_current_year,
                'pop_id'    => $pop_id,
            ])->exists();
            if($is_target_exist) continue;
            /*--------------Calculation Target -------------------*/
            $current_month_unpaid = customer_bill_generate('summary', [
                'month'  => $_current_month_formate,
                'pop_id' => $pop_id
            ]);
            $total_over_due = customer_over_due_list('summary', [
                'pop_id' => $pop_id
            ]);
            $calculated_target = round($current_month_unpaid + $total_over_due, 2);
            $object = new Bill_target();
            $object->month         = $_current_month;
            $object->year          = $_current_year;
            $object->pop_id        = $pop_id;
            $object->target_amount = $calculated_target;
            $object->save();
        }
    }
}
