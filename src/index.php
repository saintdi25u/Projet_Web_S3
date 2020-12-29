<?php

require_once "vendor/autoload.php";
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Illuminate\Database\Capsule\Manager as DB;

$bdd = new DB;
$config =parse_ini_file(__DIR__ . '/conf/db.config.ini');

if($config){
    $bdd->addConnection($config);
}
$bdd -> setAsGlobal();
$bdd ->bootEloquent();
session_start();
$app = new \Slim\App();





$app->get('/auth', function () {
    $controleur = new \mywishlist\controller\Utilisateur();
    $controleur->registerForm();
});
$app->post('/auth', function(){
    $controleur = new \mywishlist\controller\Utilisateur();
    $controleur->creerUtilisateur($_POST['nom'], $_POST['password']);
});

$app->get('/create', function(){
    $controleur = new \mywishlist\controller\Liste();
    $controleur ->creerListe();
});

$app->post('/create', function(){
    $controleur = new \mywishlist\controller\Liste();
    $controleur ->enregistrerListe();
});


$app->run();

/**
$list = \mywishlist\model\Liste::all();
foreach ($list as $e){
    print($e->no . "<br>");
    print($e->titre. "<br>");
}
 */
