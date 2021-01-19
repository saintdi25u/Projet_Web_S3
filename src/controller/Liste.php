<?php

namespace mywishlist\controller;

use mywishlist\vue\VueItem;
use mywishlist\vue\VueListe;
use mywishlist\vue\VueUtilisateur;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Liste {
    private $container;

    public function __construct($container){
        $this->container = $container;
    }


    public function creerNouvelleListe(Request $rq, Response $rs, $args){
    {   $vue = new VueListe([], $this->container);

            $post = $rq->getParsedBody();
            $list = new \mywishlist\model\Liste();
            $user_id = strip_tags(filter_var($post['user_id'], FILTER_SANITIZE_STRING));
            $titre = strip_tags(filter_var($post['titre'], FILTER_SANITIZE_STRING));
            $description = strip_tags(filter_var($post['description'], FILTER_SANITIZE_STRING));
            $expiration = filter_var($post['expiration'], FILTER_SANITIZE_STRING);
            $token =  dechex(random_int(0, 0xFFFFFFF));
            $list->user_id = $user_id;
            $list->titre = $titre;
            $list ->description = $description;
            $list->expiration = $expiration;
            $list ->token = $token;
            $list->save();
            $rs->getBody()->write($vue ->render(0));
        }
        return $rs;
    }

    public function allerSurFonctionListe(Request $rq, Response $rs, $args) {
        $vue = new VueListe( [] , $this->container);

        $rs->getBody()->write($vue->render(5));

        return $rs;

    }

    public function formListe(Request $rq, Response $rs, $args) : Response {
        // pour afficher le formulaire liste
        $vue = new VueListe( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 0 ) ) ;

        return $rs;
    }


    public function afficherListe(Request $rq, Response $rs, $args) : Response {
           $allListe = \mywishlist\model\Liste::all();
           $vue =  new VueListe($allListe->toArray(), $this->container);
           $rs ->getBody()->write($vue->render(1));
           return $rs;
    }

    public function afficherListeParNo(Request $rq, Response $rs, $args) {
        $liste = \mywishlist\model\Liste::find( $args['no']);
        $vue = new VueListe( [ $liste->toArray() ] , $this->container );
        $rs->getBody()->write( $vue->render( 3 ) ) ;
        return $rs;
    }

    public function afficherListeDelete(Request $rq, Response $rs, $args){
        $allListe = \mywishlist\model\Liste::all();
        $vue = new VueListe($allListe, $this->container);
        $rs ->getBody()->write($vue->render(7));
        return $rs;
    }

    public function deleteListe(Request $rq, Response $rs, $args){
        $vue =  new VueListe([], $this->container);
        $post = $rq->getParsedBody();
        $no = $post['delete'];  
        $liste = \mywishlist\model\Liste::where('no', '=', $no)->first();
        $liste ->delete();
        $rs->getBody()->write($vue->render(6));
        return $rs;
    }

    public function modifierListe(Request $rq, Response $rs, $args){
        $model = \mywishlist\model\Liste::where('no','=',$_GET['modif']);
        $post = $rq->getParsedBody();
        $model->description = $post['description'];
        $model->expiration = $post['expiration'];
        $model->titre = $post['titre'];
        $model->save();
    }

    public function afficherFormModifListe(Request $rq, Response $rs, $args) {
        $vue = new VueListe([], $this->container);
        $rs->getBody()->write($vue->formModifListe());
        return $rs;
    }





/**
if(is_null($i->particpant)){
$vueItem = new VueItem([$liste->toArray()], $this->container);
$rs ->getBody()->write($vueItem->formNomParticipant());
}
 * */
  

}
