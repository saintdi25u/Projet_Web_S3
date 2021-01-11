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

    public function formItem(Request $rq, Response $rs , $args) : Response{
        $vue = new VueItem([], $this->container);
        $rs->getBody()->write($vue ->render(0));
        return $rs;
    }

    public function afficherItem(Request $rq, Response $rs, $args ) : Response{
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

    public function createItem(Request $rq, Response $rs, $args) : Response{
        $vue = new VueItem([], $this->container);
        if(Utilisateur::checkAccessRights(1)) {
            $post = $rq->getParsedBody();
            $model = new \mywishlist\model\Item();
            $liste_id = filter_var($post['liste_id'], FILTER_SANITIZE_STRING);
            $nom = filter_var($post['nom'], FILTER_SANITIZE_STRING);
            $desc = filter_var($post['description'], FILTER_SANITIZE_STRING);
            $img = filter_var($post['img'], FILTER_SANITIZE_STRING);
            $url = filter_var($post['url'], FILTER_SANITIZE_STRING);
            $tarif = filter_var($post['tarif'], FILTER_SANITIZE_STRING);

            $model->liste_id = $liste_id;
            $model->nom = $nom;
            $model->descr = $desc;
            $model->img = $img;
            $model->url = $url;
            $model->tarif = $tarif;
            $model->save();
            $rs->getBody()->write($vue->render(0));
        } else {
            $rs->getBody()->write($vue->render(3));
        }
        return $rs;
    }
}