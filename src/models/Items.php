<?php
namespace taytus\climenu\src\models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
    protected $table = 'taytus_climenu';

    protected static $ids=[];


    protected $options;


    public function get_label_from_id($id){
        $obj=self::where('id',$id)->first()->toArray();
        return $obj['label'];
    }

}