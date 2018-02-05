<?php

namespace taytus\climenu\classes;



use taytus\climenu\src\models\Items;
use ReflectionMethod;






class Cli {

        protected  $output;
        protected  $ids;
        protected  $parent_id;
        protected  $current_menu_id;
        protected  $max_selection_limit;
        protected  $empty_menu_id;
        protected  $error_message;

        function __construct(){

        }

    /**
     * @param mixed $output
     */
    public function setOutput($output)
    {
        $this->output = $output;

    }
    public function setup_main_menu($output){
        $this->setOutput($output);
        $this->parent_id=0;
        $this->current_menu_id=0;

    }




    public  function validate_selection($selection){

        if(is_numeric($selection)) {

            if ($selection > $this->max_selection_limit) {
                $this->error_message= "Select a number between 1 and ". $this->max_selection_limit ."\n";

                $this->redraw_menu();

            } else {
                $this->error_message=null;
                //now that the selection is a valid option,
                //I need to update parent_menu_id and current_menu_id
                $this->parent_id=$this->current_menu_id;
                $this->current_menu_id=$this->ids[$selection-1];

                $this->process_selection($this->current_menu_id);

            }
        }else{
            $this->error_message= "No alphabetic values allowed. Please select a number between 1 and ". $this->max_selection_limit ."\n";

            $this->redraw_menu(false);

        }
    }
    public function process_selection($item_ID){

    //I need to grab the item and see if it has childs or not
        $item=Items::where('id',$item_ID)->first();


        if($item->menu){


            $this->redraw_menu();


        }else{
            //if I don't have a menu to display, then execute the action
            //associated with that selection
            $this->execute_method($item->class,$item->method,$item_ID);
           //
        }


    }
        //check if the method is static or notto determine how to call it

        public  function execute_method($class,$method,$params){
            $MethodChecker = new ReflectionMethod($class,$method);

            if(!$MethodChecker->isStatic()){
                $new_class= new $class ($this->output);

                call_user_func(array($new_class,$method),$params);
            }else{
                call_user_func(array($class,$method),$params);
            }
        }
        /*
         * Based on current IDs I can get the parent menu and display it again
         */
        public  function go_back_to_previous_menu(){

            echo "parent menu id - ".$this->ids['parent_id']."\n";

            $this->process_selection($this->ids['parent_id']);
        }

        public  function edit_current_menu($menu_ID=0){
            echo "EDITING MODE\n";

        }
        public  function delete_current_menu($menu_ID=0){
            echo "DELETING MODE\n";

        }
        public  function add_option_to_current_menu(){

            $class="";
            $method="";


            // I need to know what menu I'm editing
            dd($this->current_menu_id,$this->parent_id);


            $label=$this->output->ask("What the label for the new option?");
            $menu=$this->output->choice("Will this option will be a menu?",['No','Yes'],0);
            if($menu=='Yes') {
                $class = $this->output->ask("Please type the class of the method this menu will trigger");
                $method = $this->output->ask("Please type the method this menu will trigger");
            }

            $item = new Items();
            $item->label =$label;
            $item->menu=($menu=='Yes'?1:0);
            $item->class=($menu=='Yes'?$class:"");
            $item->method=($menu=='Yes'?$method:"");;
            $item->parent_id=$this->parent_id;
            $item->save();




        }
        public  function edit_option_from_current_menu($menu_ID=0){

            dd("nope");
        }
        public  function delete_option_from_current_menu($menu_ID=0){
            dd("bye bye");
        }

    /**
     * @param mixed $max_selection_limit
     */


    /**
     * @return mixed
     */



    public  function display_menu($item_ID){
        

        $records= Items::where('parent_id','=',$item_ID)->orderBy('created_at','asc')->get();

        //if(count($records)==0)dd($records);

        //an element can be listed as menu but not have menu items.
        //here I check and ask if they want to add items, change the item type or cancel operations

        if(count($records)==0){
            $records= Items::where('parent_id','=',500)->orderBy('created_at','asc')->get();
            echo "The menu you selected is an EMPTY menu\n";
            $this->empty_menu_id=$item_ID;
            echo "Select an option from the menu below\n\n";
        }

        $this->max_selection_limit=(count($records));

        $this->display_list_of_results($records);


    }
    /*
     * Display the options and save the IDs on the $this->ids array
     */
    public function display_list_of_results($records){

        if(!is_null($this->error_message)) echo $this->error_message;

        //clean previous IDs
        $parent_id=(isset($this->ids['parent_id'])?$this->ids['parent_id']:0);
        $this->ids=[];

        //I need to know if I have to use a paginator or not
        $total_records=count($records);
        if($total_records<9){

            $j=1;
            foreach ($records as $item){
                echo $j ."- ".$item->label. "\n";
                $this->ids[]=$item->id;
                $j++;
            }


        }
        if($records[0]->parent_id<500){
            $this->ids['parent_id']=$records[0]->parent_id;
        }else{
            $this->ids['parent_id']=$parent_id;

        }

        if($parent_id!=0) {
            echo "\n\n";
            echo "0- Go back \n";
        }
    }



    public  function setId_item($item){
        $this->ids[]=$item;
    }
    public function change_menu_item_to_non_menu()
    {

        $item = Items::find($this->empty_menu_id);
        $item->menu = 0;
        $item->save();

        $this->empty_menu_id = null;
        $this->go_back_to_previous_menu();
    }
    public function redraw_menu($validate=true){
        $this->display_menu($this->current_menu_id);
        $selection=$this->output->ask("Select an Option");


        $this->validate_selection($selection);


    }


}