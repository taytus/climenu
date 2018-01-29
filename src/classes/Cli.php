<?php

namespace taytus\climenu\classes;



use taytus\climenu\src\models\Items;
use ReflectionMethod;
use Symfony\Component\Console\Command\Command;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Application;






class Cli {

        protected static $output;

        function __construct($obj){
            self::$output=$obj;
        }

    public static function display_main_menu(){

            return Items::top_menu();
        }


        public static function process_selection($item_ID){
            //I need to grab the item and see if it has childs or not
            $item=Items::where('id',$item_ID)->first();

            if($item->menu){
                Items::display_menu($item->id);

                $answer=self::$output->ask("select something!");

                dd($answer);


            }else{
                //if I don't have a menu to display, then excecute the action
                //associated with that selection
                $class=$item->class;
                $method=$item->method;

                //check if the method is static or not, to determine how to call it
                $MethodChecker = new ReflectionMethod($class,$method);
                if($MethodChecker->isStatic()){
                    call_user_func(array($class,$method));
                }else{
                    $new_class= new $class;
                    call_user_func(array($new_class,$method));

                }

               //
            }


        }
        public static function edit_current_menu($menu_ID=0){
            echo "EDITING MODE\n";

        }
        public static function delete_current_menu($menu_ID=0){
            echo "DELETING MODE\n";

        }
        public static function add_option_to_current_menu($menu_ID=0){
            echo "add Option";
        }
        public static function edit_option_from_current_menu($menu_ID=0){
            echo "edit Option";
        }
        public static function delete_option_from_current_menu($menu_ID=0){
            echo "delete Option";
        }


}