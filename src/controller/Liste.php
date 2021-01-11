<?php

namespace mywishlist\controller;

use mywishlist\vue\VueListe;
use mywishlist\vue\VueUtilisateur;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Liste {
    private $container;

    public function __construct($container){
        $this->container = $container;
    }


    public function creerNouvelleListe(Request $rq, Response $rs, $args)
    {   $vue = new VueListe([], $this->container);
        if(Utilisateur::checkAccessRights(1)){
            $post = $rq->getParsedBody();
            $list = new \mywishlist\model\Liste();
            $user_id = filter_var($post['user_id'], FILTER_SANITIZE_STRING);
            $titre = filter_var($post['titre'], FILTER_SANITIZE_STRING);
            $description = filter_var($post['description'], FILTER_SANITIZE_STRING);
            $expiration = filter_var($post['expiration'], FILTER_SANITIZE_STRING);
            $token =  dechex(random_int(0, 0xFFFFFFF));
            $list->user_id = $user_id;
            $list->titre = $titre;
            $list ->description = $description;
            $list->expiration = $expiration;
            $list ->token = $token;
            $list->save();
            $rs->getBody()->write($vue ->render(0));
        } else {
            $rs->getBody()->write($vue ->render(2));
        }
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
  

}
