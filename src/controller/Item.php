<?php
 namespace mywishlist\controller;

use mywishlist\vue\VueItem;
use mywishlist\vue\VueListe;
use \Psr\Http\Message\ServerRequestInterface as Request;
use  \Psr\Http\Message\ResponseInterface as Response;

class Item {

    /**
     * @var $container
     */
    private $container;

    /**
     * Item constructor.
     * @param $container
     */
    public function __construct($container){
        $this->container = $container;
    }

    /**
     * Permet l'affichage du formulaire de l'item
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function formItem(Request $rq, Response $rs , $args) : Response{
        $vue = new VueItem([], $this->container);
        $rs->getBody()->write($vue ->render(0));
        return $rs;
    }

    /**
     * Permet d'afficher un item
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function afficherItem(Request $rq, Response $rs, $args ) : Response{
        $item = \mywishlist\model\Item::where('id', '=', $args['id'])->first();
        $vue = new VueItem([$item->toArray()], $this->container);
        $rs ->getBody()->write($vue->render(1));
        return $rs;
    }

    /**
     * Permet d'afficher de tous les items
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function afficherAllItem(Request $rq, Response $rs, $args) {
        $Allitem = \mywishlist\model\Item::all();
        $vue = new VueItem($Allitem->toArray(), $this->container);
        $rs->getBody()->write($vue ->render(2));
        return $rs;
    }

    /**
     * Permet la création d'un item
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
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

    /**
     * Permet d'aller sur la fonction Item
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function allerSurFonctionItem(Request $rq, Response $rs, $args) {
        $vue = new VueItem( [] , $this->container);

        $rs->getBody()->write($vue->render(5));

        return $rs;

    }

    /**
     * Permet d'afficher le contenu de la liste
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function afficherContenuListe(Request $rq, Response $rs, $args){
        $item = \mywishlist\model\Item::where('liste_id', '=', $args['no'])->get();
        $vue = new VueItem($item, $this->container);
        $rs ->getBody()->write(" <h2> Contenu de la Liste :</h2> ");
        $rs->getBody()->write($vue->contenuItem());
        $rs ->getBody()->write($vue->formMessageItem());
        return $rs;
    }


    /**
     * Permet d'insérer un participant d'une liste
     * @param Request $rq
     * @param Response $rs
     * @param $args
     */
    public function insererParticipant(Request $rq, Response $rs, $args) {
        $post = $rq->getParsedBody();
        $i = \mywishlist\model\Item::where('id', '=', filter_var($post['id_item'])) -> first();
        $participant = $i->participant;
        if(!is_null($participant)){
            $item = \mywishlist\model\Item::where('id', '=', filter_var($post['id_item']))->update(['message' =>  filter_var($post['message'])]);
            $item = \mywishlist\model\Item::where('id', '=', filter_var($post['id_item']))->update(['participant' =>  filter_var($post['nomParticipant'])]);
            $vue = new VueListe([], $this->container);
            $rs ->getBody()->write($vue->render(4));
        } else {
            $rs ->getBody()->write("<h3>Cet Item est deja reservé</h3>");
        }
    }

    public function modifierUneImageDunItem(Request $rq, Response $rs, $args){
        /**
         * Pour cette fonctionnalité, il aurait fallu faire un lien qui renvoyait vers un formulaire ou l'utilisateur 
         * aurait pu mettre les informations qu'ils souhaitaient, quand il appuie sur le bouton modifier, cela va mettre a jour dans la base de donnée
         * les valeurs pour l'item correspondant.
         * Bien évidemement, on aurait récuperer l'id de l'item au préalable
         */
    }


   
}