<?php

namespace mywishlist\model;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model {
    protected $table = 'user';
    protected $primaryKey = 'uid';
    public $timestamps= false;

}