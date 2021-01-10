<?php
 namespace mywishlist\controller;



use mywishlist\vue\VueItem;
use \Psr\Http\Message\ServerRequestInterface as Request;
use  \Psr\Http\Message\ResponseInterface as Response;

class Item {

    private $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function afficherItem(Request $rq, Response $rs, $args ){
        $item = \mywishlist\model\Item::where('id', '=', $args['id'])->first();
        $vue = new VueItem([$item->toArray()], $this->container);
        $rs ->getBody()->write($vue->render(1));
        return $rs;
    }

    public function afficherAllItem(Request $rq, Response $rs, $args) {
        $Allitem = \mywishlist\model\Item::all();
        $vue = new VueItem($Allitem->toArray(), $this->container);
        $rs->getBody()->write($vue ->render(2));
        return $rs;

    }
/**
    public function creerItem(){
        $v = new \mywishlist\vue\VueItem();
        $v ->render();
    }
 * */



    public function enregistrerItem(){
        $model = new \mywishlist\model\Item();
        $model->liste_id = $_POST['liste_id'];
        $model->nom = $_POST['nom'];
        $model->descr = $_POST['description'];
        $model ->img = $_POST['img'];
        $model -> url = $_POST['url'];
        $model ->tarif = $_POST['tarif'];

        $model ->save();
    }
}