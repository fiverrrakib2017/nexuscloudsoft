<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class database_backup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:database_backup';

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
        $username = env('BACKUP_DB_USERNAME');
        $password = env('BACKUP_DB_PASSWORD');
        $host     = env('DB_HOST');

        $backupDir = storage_path('app/backups');

        if (!file_exists($backupDir)) {
            mkdir($backupDir, 0755, true);
        }

        $databases = \DB::select('SHOW DATABASES');

        foreach ($databases as $db) {

            $database = $db->Database;

            if (in_array($database, ['information_schema', 'performance_schema', 'mysql', 'sys'])) {
                continue;
            }

            $oldBackups = glob($backupDir . "/{$database}_*.sql");
            foreach ($oldBackups as $file) {
                unlink($file);
            }

            $backupPath = $backupDir . "/{$database}_" . date('Y-m-d_H-i-s') . ".sql";

            $command = sprintf(
                'mysqldump --user=%s --password="%s" --host=%s --single-transaction --routines --triggers --events --no-tablespaces %s --result-file="%s"',
                escapeshellarg($username),
                $password,
                escapeshellarg($host),
                escapeshellarg($database),
                $backupPath
            );

            exec($command, $output, $result);

            if ($result === 0) {
                $this->info("Backup completed for {$database}");
            } else {
                $this->error("Backup failed for {$database}");
            }
        }
    }
    private function __set_tenant_connection($tenant)
    {
        \Config::set('database.connections.tenant', [
            'driver'   => 'mysql',
            'host'     => env('DB_HOST', '127.0.0.1'),
            'port'     => env('DB_PORT', '3306'),
            'database' => $tenant->db_name,
            'username' => $tenant->db_user,
            'password' => $tenant->db_pass,
        ]);

        \DB::purge('tenant');
        \DB::reconnect('tenant');
        \DB::setDefaultConnection('tenant');
    }
}
