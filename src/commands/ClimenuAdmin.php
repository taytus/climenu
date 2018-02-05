<?php

namespace taytus\climenu\commands;

use Illuminate\Console\Command;
use taytus\climenu\classes\AdminMenu;

class ClimenuAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'climenu:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manages your menues';

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
        $menu=new AdminMenu($this);
        $menu->display_main_menu();


    }
}
