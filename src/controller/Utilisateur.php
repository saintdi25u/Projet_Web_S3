<?php
namespace mywishlist\controller;

use mywishlist\vue\Vue;
use mywishlist\vue\VueUtilisateur;
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Utilisateur{

    private $container;

    public function __construct($container){
        $this->container = $container;
    }

    public function acceuil(Request $rq, Response $rs, $args) : Response{
        $vue = new VueUtilisateur([], $this->container);
        $rs->getBody()->write($vue->render(0));
        return $rs;
    }

    public function registerForm(Request $rq, Response $rs, $args) : Response{
            $vue = new VueUtilisateur([], $this->container);
            $rs->getBody()->write($vue->render(2));
            return $rs;
    }

    public function connectForm(Request $rq, Response $rs, $args) : Response{
        $vue = new VueUtilisateur([], $this->container);
        $rs->getBody()->write($vue->render(1));
        return $rs;
    }



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



    public function authUtilisateur(Request $rq, Response $rs, $args) {
       $post = $rq->getParsedBody();
       $login = filter_var($post['nom-connect'], FILTER_SANITIZE_STRING);
       $mdp = filter_var($post['password-connect'], FILTER_SANITIZE_STRING);
       $user = \mywishlist\model\Utilisateur::where('username' ,'=', $login)->first();
       $vue = new VueUtilisateur(['login' => $login], $this->container);
       if(!is_null($user)){
           if(password_verify($mdp, $user->passwd)){
               $this->loadProfile($user->uid);
               $rs ->getBody()->write($vue->render(3));
           } else {
               $rs ->getBody()->write($vue->render(6));
               //$login = "Mauvais login/mot de passe ";
           }
       } else {
           $rs ->getBody()->write($vue->render(6));
          // $login = "Mauvais login/Mot de passe";
       }


        return $rs;
    }

    public function deconnect(Request $rq, Response $rs, $args) {
        session_destroy();
        $_SESSION = [];
        $vue = new VueUtilisateur([], $this->container);
        $rs->getBody()->write($vue->render(5));
    }



    public function loadProfile($uid){
        session_destroy();
        session_start();
        $user = \mywishlist\model\Utilisateur::where('uid' ,'=', $uid) ->first();
        $info = array (
            'username' => $user->username,
            'userid' => $uid,
            'auth-level' => 1000
        );
        $_SESSION['login'] = $info;
    }

    public function checkAccessRights($required) : bool {
        if($_SESSION['login']['auth-level'] < $required){
            return true;
        }
    }




}