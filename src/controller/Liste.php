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

    /**
    public function enregistrerListe()
    {
        $model = new \mywishlist\model\Liste();
        $model->user_id = $_POST['user_id'];
        $model->titre = $_POST['titre'];
        $model->description = $_POST['description'];
        $model->expiration = $_POST['expiration'];
        $model->token = dechex(random_int(0, 0xFFFFFFF));
        $model->save();
    }
*/
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
