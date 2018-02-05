<?php
namespace taytus\climenu\src\models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $table = 'taytus_climenu';

    protected static $ids=[];



    protected $options;


    public function get_field_from_id($id,$field){

        $obj=self::where('id','=',$id)->first([$field]);

        return $obj->$field;
    }

}