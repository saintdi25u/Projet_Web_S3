<?php

namespace mywishlist\controller;

use mywishlist\vue\VueItem;
use mywishlist\vue\VueListe;
use mywishlist\vue\VueUtilisateur;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Liste {

    /**
     * @var $container
     */
    private $container;

    /**
     * Liste constructor.
     * @param $container
     */
    public function __construct($container){
        $this->container = $container;
    }

    /**
     * Permet la création d'une nouvelle liste
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     * @throws \Exception
     */
    public function creerNouvelleListe(Request $rq, Response $rs, $args){  
        $vue = new VueListe([], $this->container);
        if(Utilisateur::checkAccessRights(1))  {
            

            $post = $rq->getParsedBody();
            $list = new \mywishlist\model\Liste();

            $titre = strip_tags(filter_var($post['titre'], FILTER_SANITIZE_STRING));
            $description = strip_tags(filter_var($post['description'], FILTER_SANITIZE_STRING));
            $expiration = filter_var($post['expiration'], FILTER_SANITIZE_STRING);
            $token =  dechex(random_int(0, 0xFFFFFFF));
            $list->user_id = $_SESSION['user']['userid'];
            $list->titre = $titre;
            $list ->description = $description;
            $list->expiration = $expiration;
            $list ->token = $token;
            $list->save();
            $rs->getBody()->write($vue ->render(0));
        } else {
            $rs->getBody()->write($vue->render(2));
        }
        return $rs;
       
        
       
    }

    /**
     * Permet d'aller sur la fonction de la Liste
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function allerSurFonctionListe(Request $rq, Response $rs, $args) {
        $vue = new VueListe( [] , $this->container);

        $rs->getBody()->write($vue->render(5));

        return $rs;

    }

    /**
     * Permet l'affichage du formulaire de la liste
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function formListe(Request $rq, Response $rs, $args) : Response {
        // pour afficher le formulaire liste
        $vue = new VueListe( [] , $this->container ) ;
        $rs->getBody()->write( $vue->render( 0 ) ) ;

        return $rs;
    }

    /**
     * Permet d'afficher toutes les listes
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function afficherListe(Request $rq, Response $rs, $args) : Response {
           $allListe = \mywishlist\model\Liste::all();
           $vue =  new VueListe($allListe->toArray(), $this->container);
           $rs ->getBody()->write($vue->render(1));
           return $rs;
    }

    /**
     * Permet d'afficher la liste via son numéro
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function afficherListeParNo(Request $rq, Response $rs, $args) {
        $liste = \mywishlist\model\Liste::find( $args['no']);
        $vue = new VueListe( [ $liste->toArray() ] , $this->container );
        $rs->getBody()->write( $vue->render( 3 ) ) ;
        return $rs;
    }

    /**
     * Permet l'affichage du formulaire pour supprimer une liste
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function afficherListeDelete(Request $rq, Response $rs, $args){
        $allListe = \mywishlist\model\Liste::all();
        $vue = new VueListe($allListe, $this->container);
        $rs ->getBody()->write($vue->render(7));
        return $rs;
    }

    /**
     * Permet de supprimer une liste
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function deleteListe(Request $rq, Response $rs, $args){
        $vue =  new VueListe([], $this->container);
        if(Utilisateur::checkAccessRights(1)) {
            $post = $rq->getParsedBody();
            $no = $post['delete'];  
            $liste = \mywishlist\model\Liste::where('no', '=', $no)->first();
            $liste ->delete();
            $rs->getBody()->write($vue->render(6));
        } else {
            $rs->getBody()->write($vue ->render(2));
        }
        
    }


    /**
     * Permet de supprimer une liste
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function modifierListe(Request $rq, Response $rs, $args){
        $vue = new VueListe([], $this->container);
        if(Utilisateur::checkAccessRights(1)) {
        $post = $rq->getParsedBody();
        $no = $post['modif'];
        $liste = \mywishlist\model\Liste::where('no', '=', $no)->first();
        $liste->description = $post['description'];
        $liste->expiration = $post['expiration'];
        $liste->titre = $post['titre'];
        $liste->save(); 
       $rs->getBody()->write($vue->render(7));
        } else {
        $rs->getBody()->write($vue->render(2));
        }
        return $rs;
    }

    /**
     * Permet l'affichage du formulaire pour modifier la liste
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function afficherFormModifListe(Request $rq, Response $rs, $args) {
        $vue = new VueListe([], $this->container);
        $rs->getBody()->write($vue->formModifListe());
        return $rs;
    }


}
