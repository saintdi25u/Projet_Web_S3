<?php

namespace mywishlist\model;

use Illuminate\Database\Eloquent\Model;

class Liste extends Model
{
    protected $table = 'liste';
    protected $primaryKey = 'user_id';
    public $timestamps= false;

    public function items(){
        return $this->hasMany('mywishlist\model\Item','liste_id');
    }
}