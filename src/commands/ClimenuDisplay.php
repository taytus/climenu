<?php

namespace taytus\climenu\commands;

use Illuminate\Console\Command;
use taytus\climenu\classes\DemoMenu;

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

        $menu=new DemoMenu($this);
        $menu->display_main_menu();




    }
}
