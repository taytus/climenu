<?php

namespace taytus\climenu;
use DB;

use Illuminate\Database\Seeder;
use taytus\climenu\classes\Cli;

class ClimenuSeeder extends Seeder{
    public function run(){

        $table='taytus_climenu';
        $now=\Carbon\Carbon::now();
        $demo_class='taytus\climenu\classes\DemoMenu';
        $class='taytus\climenu\classes\Cli';

        DB::table($table)->insert([
            'label'=>"Red",
            'parent_id'=>0,
            'description' => 'Example menu, just prints out the word Red',
            'class'=>$demo_class,
            'method'=>'print',
            'params'=>'red',
            'menu'=>0,
            'created_at' => $now,
            'updated_at' =>$now
        ]);
        DB::table($table)->insert([
            'label'=>"Blue",
            'parent_id'=>0,
            'description' => 'Example menu, just prints out the word Blue',
            'class'=>$demo_class,
            'method'=>'print',
            'params'=>'blue',
            'menu'=>0,
            'created_at' => $now,
            'updated_at' =>$now
        ]);
        DB::table($table)->insert([
            'label'=>"White",
            'parent_id'=>0,
            'description' => 'Example menu, just prints out the word White',
            'class'=>$demo_class,
            'method'=>'print',
            'params'=>'white',
            'menu'=>0,
            'created_at' => $now,
            'updated_at' =>$now
        ]);











        //options for editing the current menu

        DB::table($table)->insert([
            'label'=>"Add a new option",
            'parent_id'=>500,
            'description' => 'Add a new menu entry',
            'class'=>$class,
            'method'=>'add_option_to_current_menu',
            'menu'=>0,
            'created_at' => $now,
            'updated_at' =>$now
        ]);
        DB::table($table)->insert([
            'label'=>"Edit Entry from current Menu",
            'parent_id'=>1,
            'description' => 'Select an option to edit it',
            'class'=>$class,
            'method'=>'edit_option_from_current_menu',
            'menu'=>0,
            'created_at' => $now,
            'updated_at' =>$now
        ]);
        DB::table($table)->insert([
            'label'=>"Select and delete an entry from Current Menu",
            'parent_id'=>1,
            'description' => 'Select and delete an entry from Current Menu',
            'class'=>$class,
            'method'=>'delete_option_from_current_menu',
            'menu'=>0,
            'created_at' => $now,
            'updated_at' =>$now
        ]);
        DB::table($table)->insert([
            'label'=>"Empty menu option",
            'parent_id'=>1,
            'description' => 'This is an option only to test EMPTY menues',
            'class'=>$class,
            'method'=>'not_available',
            'menu'=>1,
            'created_at' => $now,
            'updated_at' =>$now
        ]);

        ///system menu for when an item is marked as menu but it has no items

        DB::table($table)->insert([
            'label'=>"Add a new option",
            'parent_id'=>700,
            'description' => 'Add a new menu entry to an empty menu',
            'class'=>$class,
            'method'=>'add_option_to_current_menu',
            'menu'=>0,
            'created_at' => $now,
            'updated_at' =>$now
        ]);
        DB::table($table)->insert([
            'label'=>"Change the Item type to Non-Menu-Item",
            'parent_id'=>500,
            'description' => 'The element won\'t be considerated a Menu entry',
            'class'=>$class,
            'method'=>'change_menu_item_to_non_menu',
            'menu'=>0,
            'created_at' => $now,
            'updated_at' =>$now
        ]);

    }
}