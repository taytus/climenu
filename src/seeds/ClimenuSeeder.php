<?php

namespace taytus\climenu;
use DB;

use Illuminate\Database\Seeder;

class ClimenuSeeder extends Seeder{
    public function run(){
        DB::table('taytus_climenu')->insert([
            'label'=>"first menu option",
            'parent_id'=>0,
            'description' => 'My first menu option',
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
    }
}