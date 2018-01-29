<?php

namespace taytus\climenu\commands;

use Illuminate\Console\Command;
use taytus\climenu\classes\Cli;

class ClimenuDisplay extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'climenu:menu';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all the menu options';

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
        //get all the options and list them ordered by created_at
        $options=Cli::display_main_menu();

        $selection = $this->ask('Please select an option from 1 to 9');

        Cli::process_selection($options[$selection -1]);


    }
}
