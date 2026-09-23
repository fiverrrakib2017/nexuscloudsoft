<?php
namespace App\Console\Commands\Customer;
use App\Jobs\Customer_usages;
use App\Models\Router;

use Illuminate\Console\Command;
use function App\Helpers\formate_uptime;
class customer_usage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:customer_usage';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch daily user usage from MikroTik';

    public function handle(): int
    {
        $this->info('--- Customer Daily Usage Job Dispatch Started ---');

        Router::where('status', 'active')
            ->select('id')
                ->chunk(50, function ($routers)  {
                foreach ($routers as $router) {
                    Customer_usages::dispatch($router->id);
                }
            });

        $this->info('--- Customer Daily Usage Job Dispatch Finished ---');
        return Command::SUCCESS;
    }
}
