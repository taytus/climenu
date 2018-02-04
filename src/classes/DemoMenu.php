<?php

namespace taytus\climenu\classes;

use taytus\climenu\src\models\Items;


class DemoMenu
{

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
        $this->Cli->setup_main_menu(0,0,$this->output);
        $this->Cli->redraw_menu();
    }

    //this is the method assigned to this menu.
    //check the class and method fields in the DB.

    public  function printing($item_id)
    {

        $obj=$this->Items->get_label_from_id($item_id);

        echo "****************\n";
        echo $obj . "\n";
        echo "****************\n";
    }
}




