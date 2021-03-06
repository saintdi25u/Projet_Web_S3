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

$app->get('/liste/{no}', \mywishlist\controller\Liste::class.":afficherListeParNo") ->setName('showListeParNo');
$app->get('/liste/contenu/{no}', \mywishlist\controller\Item::class.":afficherContenuListe") ->setName('showContenuListe');

$app->get('/reserve', \mywishlist\controller\Item::class.":afficherFormParticipant")->setName('reserve');
$app->post('/reserve', \mywishlist\controller\Item::class.":insererParticipant")->setName('reserve');

$app->get('/foncliste', \mywishlist\controller\Liste::class.":allerSurFonctionListe")->setName('liste');
$app->get('/foncItem', \mywishlist\controller\Item::class.":allerSurFonctionItem")->setName('item');

$app->get('/delete/liste', \mywishlist\controller\Liste::class.":afficherListeDelete") ->setName('showContenuDeleteListe');
$app->post('/delete/liste', \mywishlist\controller\Liste::class.":deleteListe")->setName('showContenuDeleteListe');

$app->get('/modif/liste', \mywishlist\controller\Liste::class.":afficherFormModifListe")->setName('modifListe');
$app->post('/modif/liste', \mywishlist\controller\Liste::class.":modifierListe")->setName('modifListe');

$app->get('/deleteAccount', \mywishlist\controller\Utilisateur::class.":deleteAccount")->setName('supprimerAcount');

$app->run();

