<?php

namespace mywishlist\model;

use Illuminate\Database\Eloquent\Model;

class Liste extends Model
{

    /**
     * @var $table
     * @var $primaryKey
     * @var $timestamps
     * Attributs de la class Liste
     */
    protected $table = 'liste';
    protected $primaryKey = 'no';
    public $timestamps= false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function items(){
        return $this->hasMany('mywishlist\model\Item','liste_id');
    }
}