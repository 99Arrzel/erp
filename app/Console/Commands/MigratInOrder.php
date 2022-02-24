<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MigrateInOrder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate_in_order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute migrations in specific order. All tables will be dropped';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

       /** Specify the names of the migrations files in the order you want to
        * loaded
        * $migrations =[
        *               'xxxx_xx_xx_000000_create_nameTable_table.php',
        *    ];
        */
        $migrations = [
                        '2021_12_24_185355_create_city_table.php',

        ];
        $this->call('db:wipe'); //Clean all db

        foreach ($migrations as $migration) {
            $basePath = '/database/migrations/';
            $migrationName = trim($migration);
            $path = $basePath.$migrationName;
            $this->call('migrate', [
            '--path' => $path ,
           ]);
        }
    }
}
