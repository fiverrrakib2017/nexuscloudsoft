<?php

namespace App\Console\Commands\Customer;
use App\Models\Customer;
use Illuminate\Console\Command;
use App\Models\Daily_usages;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class weekly_usage_rollup extends Command
{
    protected $signature = 'app:weekly_usage_rollup';

    protected $description = 'Aggregate daily usages into weekly totals and cleanup';
    public function handle()
    {
        $startOfWeek = Carbon::now()->startOfWeek()->subWeek();
        $endOfWeek   = Carbon::now()->startOfWeek();

        DB::transaction(function () use ($startOfWeek, $endOfWeek) {

            $weeklyTotals = Daily_usages::where('is_weekly', 0)
                ->whereBetween('date', [
                    $startOfWeek->toDateString(),
                    $endOfWeek->toDateString(),
                ])
                ->select(
                    'customer_id',
                    DB::raw('SUM(upload) as total_upload'),
                    DB::raw('SUM(download) as total_download')
                )
                ->groupBy('customer_id')
                ->get();

            foreach ($weeklyTotals as $row) {
                Daily_usages::create([
                    'customer_id' => $row->customer_id,
                    'upload'      => $row->total_upload,
                    'download'    => $row->total_download,
                    'date'        => $startOfWeek->toDateString(),
                    'is_weekly'   => 1,
                ]);
            }

            Daily_usages::where('is_weekly', 0)
                ->whereBetween('date', [
                    $startOfWeek->toDateString(),
                    $endOfWeek->toDateString(),
                ])
                ->delete();
        });

        $this->info('Weekly usage aggregation completed successfully.');
    }

}
