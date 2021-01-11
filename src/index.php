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

$app->post('/listes', \mywishlist\controller\Liste::class.':creerNouvelleListe')->setName('formListe');
$app->get('/listes', \mywishlist\controller\Liste::class.':formListe')->setName('formListe');

$app->get('/showlistes', \mywishlist\controller\Liste::class.':afficherListe')->setName('showListe');

$app->get('/item/{id}', \mywishlist\controller\Item::class.':afficherItem')->setName('showItem');
$app->get('/allItem', \mywishlist\controller\Item::class.':afficherAllItem')->setName('showAllItem');

$app->get('/item', \mywishlist\controller\Item::class.':formItem')->setName('createItem');
$app->post('/item', \mywishlist\controller\Item::class.':createItem')->setName('createItem');
$app->run();




/**
$list = \mywishlist\model\VueListe::all();
foreach ($list as $e){
    print($e->no . "<br>");
    print($e->titre. "<br>");
}
 */
