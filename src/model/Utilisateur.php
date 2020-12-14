<?php

namespace mywishlist\model;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model{
    protected $table = 'utilisateur';
    protected $primaryKey = 'id';
    public $timestamps= false;
}