<?php

namespace mywishlist\model;

use Illuminate\Database\Eloquent\Model;

class Item extends Model{

    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps= false;

    public function list(){
        return $this -> belongsTo('mywishlist\models\Liste', 'liste_id');
    }
}
