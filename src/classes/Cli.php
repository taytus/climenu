<?php

namespace taytus\climenu\classes;



use taytus\climenu\src\models\Items;
use ReflectionMethod;






class Cli {

        protected  $output;
        protected  $ids;
        protected  $parent_id;
        protected  $max_selection_limit;
        protected  $empty_menu_id;

        function __construct(){

        }

    /**
     * @param mixed $output
     */
    public function setOutput($output)
    {
        $this->output = $output;
    }

        public  function display_main_menu(){
            system('clear');
            $this->parent_id=0;
            return $this->top_menu();
        }


        public  function validate_selection($selection){

            if(is_numeric($selection)) {
                    if ($selection > $this->getMaxSelectionLimit()) {
                        echo "Select a number between 1 and ". $this->getMaxSelectionLimit() ."\n";

                    } else {
                        $this->process_selection($this->getId_from_index($selection-1));

                    }
                }else{
                    echo "Select a number between 1 and ". $this->getMaxSelectionLimit() ."\n";
            }
        }
        public function process_selection($item_ID){

        //I need to grab the item and see if it has childs or not
            $item=Items::where('id',$item_ID)->first();


            if($item->menu){


                $this->setIds($this->display_menu($item_ID));


                $selection=$this->output->ask("select something!");

                if($selection==0){
                        $this->go_back_to_previous_menu();
                }else{
                    //now I have to process the users' selection

                    $this->validate_selection($selection);

                }


            }else{
                //if I don't have a menu to display, then execute the action
                //associated with that selection
                $this->execute_method($item->class,$item->method);
               //
            }


        }
        //check if the method is static or notto determine how to call it

        public  function execute_method($class,$method){
            $MethodChecker = new ReflectionMethod($class,$method);
            if($MethodChecker->isStatic()){
                $new_class= new $class;
                call_user_func(array($new_class,$method));
            }else{
                call_user_func(array($class,$method));
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
        public  function add_option_to_current_menu($menu_ID=0){

            dd("I add a new option here");

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
    public  function setMaxSelectionLimit($max_selection_limit)
    {
        $this->max_selection_limit = $max_selection_limit;
    }

    /**
     * @return mixed
     */
    public function getMaxSelectionLimit()
    {
        return $this->max_selection_limit;
    }

    public function top_menu(){

        return $this->display_menu(0);

    }
    public  function display_menu($item_ID){



        $records= Items::where('parent_id','=',$item_ID)->orderBy('created_at','asc')->get();


        //an element can be listed as menu but not have menu items.
        //here I check and ask if they want to add items, change the item type or cancel operations

        if(count($records)==0){
            $records= Items::where('parent_id','=',500)->orderBy('created_at','asc')->get();
            echo "The menu you selected is an EMPTY menu\n";
            $this->setEmptyMenuId($item_ID);
            echo "Select an option from the menu below\n\n";
        }

        $this->setMaxSelectionLimit(count($records));

        $this->display_list_of_results($records);


        return $this->getIds();
    }
    public function display_list_of_results($records){

        //clean previous IDs
        $parent_id=(isset($this->ids['parent_id'])?$this->ids['parent_id']:0);
        $this->setIds([]);

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

    /**
     * @param mixed $ids
     */
    public  function setIds($ids){
        $this->ids = $ids;
    }

    /**
     * @return mixed
     */
    public  function getIds(){
        return $this->ids;
    }
    public  function getId_from_index($index){
        return $this->ids[$index];
    }
    public  function setId_item($item){
        $this->ids[]=$item;
    }
    public function change_menu_item_to_non_menu(){

        $item= Items::find($this->getEmptyMenuId());
        $item->menu = 0;
        $item->save();

        $this->setEmptyMenuId(null);
        $this->go_back_to_previous_menu();
    }

    /**
     * @return mixed
     */
    public  function getEmptyMenuId()
    {
        return $this->empty_menu_id;
    }

    /**
     * @param mixed $empty_menu_id
     */
    public  function setEmptyMenuId($empty_menu_id)
    {
        $this->empty_menu_id = $empty_menu_id;
    }


}