<?php

namespace taytus\climenu\commands;

use Illuminate\Console\Command;
use taytus\climenu\classes\Cli;
use taytus\climenu\classes\Ask;
use taytus\climenu\classes\DemoMenu;
use taytus\climenu\classes\Posta;
use Symfony\Component\Console\Application;

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

        $menu=new DemoMenu();
        //this variable is what let me ASK from the other class
        $menu->setOutput($this);

        $menu->display_main_menu();





        dd("END FROM CliMenuDisplay");
        $menu->display_main_menu();
        //options is an array with IDs



        $selection = $this->ask('Please select an option from 1 to 9');

       // dd(Cli::getMaxSelectionLimit(), $selection);

        $menu->validate_selection($selection);
        //Cli::process_selection($selection);

       /*
       */


    }
}
