<?php
namespace mywishlist\controller;

use mywishlist\vue\Vue;
use mywishlist\vue\VueUtilisateur;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Utilisateur{

    /**
     * @var $container
     */
    private $container;

    /**
     * Utilisateur constructor.
     * @param $container
     */
    public function __construct($container){
        $this->container = $container;
    }

    /**
     * Permet l'affichage de la page d'accueil
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     */
    public function acceuil(Request $rq, Response $rs, $args) : Response{
        $vue = new VueUtilisateur([], $this->container);
        $rs->getBody()->write($vue->render(0));
        return $rs;
    }

    /**
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     * Permet l'affichage du formulaire de l'enregistrement d'un client
     */
    public function registerForm(Request $rq, Response $rs, $args) : Response{
            $vue = new VueUtilisateur([], $this->container);
            $rs->getBody()->write($vue->render(2));
            return $rs;
    }


    /**
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     * Permet l'affichage du formulaire de la connexion
     */
    public function connectForm(Request $rq, Response $rs, $args) : Response{
        $vue = new VueUtilisateur([], $this->container);
        $rs->getBody()->write($vue->render(1));
        return $rs;
    }

    /**
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     * Permet de créer un nouvel utilisateur
     */
    public function creerUtilisateur(Request $rq, Response $rs, $args){
        $post = $rq->getParsedBody();
        $login = filter_var($post['nom'], FILTER_SANITIZE_STRING );
        $mdp = filter_var($post['password'],FILTER_SANITIZE_STRING);
        $user = \mywishlist\model\Utilisateur::where('username', '=', $login)->first();
        if(is_null($user)){
            $u = new \mywishlist\model\Utilisateur();
            $u->username = $login;
            $u->passwd = password_hash($mdp, PASSWORD_DEFAULT);
            $u ->save();
        }
        $vue = new VueUtilisateur(['login' => $login], $this->container);
        $rs ->getBody()->write($vue->render(4));
        return $rs;
    }

    /**
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     * Permet de connecter un utilisateur
     */
    public function authUtilisateur(Request $rq, Response $rs, $args) {

            $post = $rq->getParsedBody();
            $login = filter_var($post['nom-connect'], FILTER_SANITIZE_STRING);
            $mdp = filter_var($post['password-connect'], FILTER_SANITIZE_STRING);
            $user = \mywishlist\model\Utilisateur::where('username', '=', $login)->first();
            $vue = new VueUtilisateur(['login' => $login], $this->container);
        if(!isset($_SESSION['user'])) {
            if (!is_null($user)) {
                if (password_verify($mdp, $user->passwd)) {
                    $this->loadProfile($user->uid);
                    $rs->getBody()->write($vue->render(3));
                } else {
                    $rs->getBody()->write($vue->render(6));
                }
            } else {
                $rs->getBody()->write($vue->render(6));
            }
        } else {
            $rs->getBody()->write($vue->render(11));
        }
        return $rs;
        }


    /**
     * @param Request $rq
     * @param Response $rs
     * @param $args
     * @return Response
     * Permet de déconnecter un utilisateur
     */
    public function deconnect(Request $rq, Response $rs, $args) : Response {
        if(isset($_SESSION['user'])){
            session_destroy();
            $_SESSION['user'] = [];
            $vue = new VueUtilisateur([], $this->container);
            $rs->getBody()->write($vue->render(5));
        } else {
            $vue = new VueUtilisateur([], $this->container);
            $rs->getBody()->write($vue->render(10));
        }
        return $rs;
    }

    /**
     * @param $uid
     * Permet de charger le profil d'un utilisateur
     */
    public function loadProfile($uid){
        session_start();
        $user = \mywishlist\model\Utilisateur::where('uid' ,'=', $uid) ->first();
        $info = array (
            'username' => $user->username,
            'userid' => $uid,
            'auth-level' => 1
        );
        $_SESSION['user'] = $info;
        var_dump($_SESSION['user']);
    }

    /**
     * @param $required
     * @return bool
     * Permet de vérifier si l'utilisateur possède les droits ou non
     */
    public static function checkAccessRights($required) : bool {
        if(isset($_SESSION['user'])){
            if($_SESSION['user']['auth-level'] === $required){
                return true;
            }
        } else  {
            return false;
        }
    }
}