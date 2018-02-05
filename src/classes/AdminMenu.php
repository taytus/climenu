<?php

namespace taytus\climenu\classes;

use taytus\climenu\src\models\Items;


class AdminMenu{

    protected $output;
    protected $ids;
    protected $parent_id;
    protected $current_menu_id;

    protected $Cli;
    function __construct($output=null)
    {
        $this->output=$output;
        $this->Items=new Items();


    }


    public function display_main_menu(){
        system('clear');
        $this->Cli=new Cli();
        $this->Cli->setup_admin_menu($this->output);
        $this->Cli->redraw_menu();
    }

    //this is the method assigned to this menu.
    //check the class and method fields in the DB.

    public  function create_new_menu($parent_id){

        $obj=$this->Items->get_field_from_id($parent_id,'label');

        echo "****************\n";
        echo $obj . "\n";
        echo "****************\n";
    }
}




