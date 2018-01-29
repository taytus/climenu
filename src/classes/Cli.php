<?php

namespace taytus\climenu\classes;
use taytus\climenu\src\models\Items;
use ReflectionMethod;



class Cli{

        public static function display_main_menu(){

            return Items::top_menu();
        }

        public static function process_selection($item_ID){
            //I need to grab the item and see if it has childs or not
            $item=Items::where('id',$item_ID)->first();

            if($item->menu){
                Items::display_menu($item->id);
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

}