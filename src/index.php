<?php

require_once "vendor/autoload.php";
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as DB;

$bdd = new DB;
$config =parse_ini_file(__DIR__ . '/conf/db.config.ini');


$container = new \Slim\Container($config);
$container['settings']['displayErrorDetails'] = true;
$bdd->addConnection($config);

$bdd -> setAsGlobal();
$bdd ->bootEloquent();

session_start();
$app = new \Slim\App($container);


$app->get('/', \mywishlist\controller\Utilisateur::class.':acceuil')->setName('racine');
$app->get('/connect', \mywishlist\controller\Utilisateur::class.':connectForm')->setName('connect');
$app->get('/register', \mywishlist\controller\Utilisateur::class.':registerForm')->setName('register');

$app->post('/connect', \mywishlist\controller\Utilisateur::class.':authUtilisateur')->setName('connect');
$app->post('/register', \mywishlist\controller\Utilisateur::class.':creerUtilisateur')->setName('register');

$app->get('/deconnect', \mywishlist\controller\Utilisateur::class.':deconnect')->setName('deconnexion');
$app->run();




/**
$list = \mywishlist\model\Liste::all();
foreach ($list as $e){
    print($e->no . "<br>");
    print($e->titre. "<br>");
}
 */
