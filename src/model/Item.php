<?php

namespace mywishlist\model;

use Illuminate\Database\Eloquent\Model;

class Item extends Model{

    /**
     * @var $table
     * @var $primaryKey
     * @var $timestamps
     * Attributs de la class Item
     */
    protected $table = 'item';
    protected $primaryKey = 'id';
    public $timestamps= false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function list(){
        return $this -> belongsTo('mywishlist\model\Liste', 'liste_id');
    }
}
