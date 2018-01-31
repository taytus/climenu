<?php

namespace taytus\climenu\classes;



use taytus\climenu\src\models\Items;
use ReflectionMethod;






class Cli {

        protected static $output;
        protected static $ids;
        protected static $parent_id;
        protected static $max_selection_limit;
        protected static $empty_menu_id;

        function __construct($obj){
            self::$output=$obj;
        }

        public static function display_main_menu(){
            system('clear');
            self::$parent_id=0;
            return self::top_menu();
        }


        public static function validate_selection($selection){

            if(is_numeric($selection)) {
                    if ($selection > self::getMaxSelectionLimit()) {
                        echo "Select a number between 1 and ". self::getMaxSelectionLimit() ."\n";

                    } else {
                        Cli::process_selection(self::getId_from_index($selection-1));

                    }
                }else{
                    echo "Select a number between 1 and ". self::getMaxSelectionLimit() ."\n";
            }
            echo "VALIDATION PASSED \n\n";
        }
        public static function process_selection($item_ID){

        //I need to grab the item and see if it has childs or not
            $item=Items::where('id',$item_ID)->first();


            if($item->menu){


                self::setIds(self::display_menu($item_ID));


                $selection=self::$output->ask("select something!");

                if($selection==0){
                        self::go_back_to_previous_menu();
                }else{
                    //now I have to process the users' selection

                    self::validate_selection($selection);

                }


            }else{
                //if I don't have a menu to display, then execute the action
                //associated with that selection
                self::excecute_method($item->class,$item->method);
               //
            }


        }
        //check if the method is static or notto determine how to call it

        public static function excecute_method($class,$method){
            $MethodChecker = new ReflectionMethod($class,$method);
            if($MethodChecker->isStatic()){
                call_user_func(array($class,$method));
            }else{
                $new_class= new $class;
                call_user_func(array($new_class,$method));

            }
        }
        /*
         * Based on current IDs I can get the parent menu and display it again
         */
        public static function go_back_to_previous_menu(){

            echo "parent menu id - ".self::$ids['parent_id']."\n";

            self::process_selection(self::$ids['parent_id']);
        }

        public static function edit_current_menu($menu_ID=0){
            echo "EDITING MODE\n";

        }
        public static function delete_current_menu($menu_ID=0){
            echo "DELETING MODE\n";

        }
        public static function add_option_to_current_menu($menu_ID=0){

            dd("I add a new option here");

        }
        public static function edit_option_from_current_menu($menu_ID=0){

            dd("nope");
        }
        public static function delete_option_from_current_menu($menu_ID=0){
            dd("bye bye");
        }

    /**
     * @param mixed $max_selection_limit
     */
    public static function setMaxSelectionLimit($max_selection_limit)
    {
        self::$max_selection_limit = $max_selection_limit;
    }

    /**
     * @return mixed
     */
    public static function getMaxSelectionLimit()
    {
        return self::$max_selection_limit;
    }

    public static function top_menu(){

        return self::display_menu(0);

    }
    public static function display_menu($item_ID){



        $records= Items::where('parent_id','=',$item_ID)->orderBy('created_at','asc')->get();


        //an element can be listed as menu but not have menu items.
        //here I check and ask if they want to add items, change the item type or cancel operations

        if(count($records)==0){
            $records= Items::where('parent_id','=',500)->orderBy('created_at','asc')->get();
            echo "The menu you selected is an EMPTY menu\n";
            self::setEmptyMenuId($item_ID);
            echo "Select an option from the menu below\n\n";
        }

        self::setMaxSelectionLimit(count($records));

        self::display_list_of_results($records);


        return self::getIds();
    }
    public static function display_list_of_results($records){

        //clean previous IDs
        $parent_id=(isset(self::$ids['parent_id'])?self::$ids['parent_id']:0);
        self::setIds([]);

        //I need to know if I have to use a paginator or not
        $total_records=count($records);
        if($total_records<9){

            $j=1;
            foreach ($records as $item){
                echo $j ."- ".$item->label. "\n";
                self::$ids[]=$item->id;
                $j++;
            }


        }
        if($records[0]->parent_id<500){
            self::$ids['parent_id']=$records[0]->parent_id;
        }else{
            self::$ids['parent_id']=$parent_id;

        }

        if($parent_id!=0) {
            echo "\n\n";
            echo "0- Go back \n";
        }
    }

    /**
     * @param mixed $ids
     */
    public static function setIds($ids){
        self::$ids = $ids;
    }

    /**
     * @return mixed
     */
    public static function getIds(){
        return self::$ids;
    }
    public static function getId_from_index($index){
        return self::$ids[$index];
    }
    public static function setId_item($item){
        self::$ids[]=$item;
    }
    public static function change_menu_item_to_non_menu(){
        $item= Items::find(self::getEmptyMenuId());
        $item->menu = 0;
        $item->save();

        self::setEmptyMenuId(null);
        self::go_back_to_previous_menu();
    }

    /**
     * @return mixed
     */
    public static function getEmptyMenuId()
    {
        return self::$empty_menu_id;
    }

    /**
     * @param mixed $empty_menu_id
     */
    public static function setEmptyMenuId($empty_menu_id)
    {
        self::$empty_menu_id = $empty_menu_id;
    }


}