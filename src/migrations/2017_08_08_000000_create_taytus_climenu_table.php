<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaytusClimenuTable extends Migration
{
    public function up()
    {
        Schema::create('taytus_climenu', function (Blueprint $table) {
            $table->increments('id');
            $table->string('label',100);
            $table->string('method',255)->default("");
            $table->string('class',255)->default("");
            $table->string('params',255)->default("");
            $table->integer("parent_id")->default(0);
            $table->string("description",255)->default("");
            $table->boolean('menu')->default(0);


            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('taytus_climenu');
    }
}