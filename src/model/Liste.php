<?php

namespace mywishlist\model;

use Illuminate\Database\Eloquent\Model;

class Liste extends Model
{
    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps= false;

    public function items(){
        return $this->hasMany('mywishlist\model\Item','liste_id');
    }
}