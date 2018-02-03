<?php

namespace taytus\climenu\commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class Climenu extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'climenu:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs the package climenu.';

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
     * @return mixed
     */
    public function handle()
    {
        $table='taytus_climenu';
        //publish the assets
        //
        if (Schema::hasTable($table)) {
            Schema::drop($table);
        }

        $this->call ('vendor:publish',['--tag'=>'migrations']);

        $this->call('migrate');
        //seed the database

         $this->call('db:seed',['--class'=>'taytus\climenu\ClimenuSeeder']);


    }
}
