<?php

namespace mywishlist\model;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model {

    /**
     * @var $table
     * @var $primaryKey
     * @var $timestamps
     * Attributs de la class Utilisateur
     */
    protected $table = 'user';
    protected $primaryKey = 'uid';
    public $timestamps= false;

}