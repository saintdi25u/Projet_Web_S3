<?php

require_once "vendor/autoload.php";

use Illuminate\Database\Capsule\Manager as DB;

$bdd = new DB;
$config =parse_ini_file(__DIR__ . '/conf/db.config.ini');

if($config){
    $bdd->addConnection($config);
}
$bdd -> setAsGlobal();
$bdd ->bootEloquent();
$app = new \Slim\App();
$uti = new \mywishlist\controller\Utilisateur();
$uti ->registerForm();




/**
$list = \mywishlist\model\Liste::all();
foreach ($list as $e){
    print($e->no . "<br>");
    print($e->titre. "<br>");
}
 */
