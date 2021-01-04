<?php
namespace mywishlist\controller;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Utilisateur{

    public function registerForm(){
            $v = new \mywishlist\vue\Utilisateur();
            $v -> render();
    }

    public function connectForm(){
        $v =  new \mywishlist\vue\Utilisateur();
        $v->ConnectionForm();
    }



    public function creerUtilisateur($username, $password){
        $v = new \mywishlist\vue\Utilisateur();
        $user = new \mywishlist\model\Utilisateur();
        $user->username = $username;
        $user -> passwd = password_hash($password, PASSWORD_DEFAULT, ['cost'=> 12]);
        $name = \mywishlist\model\Utilisateur::where('username', '=', $username)->first();
        if(is_null($name)){
            $user -> save();
        } else {
            $v->utilisateurExistant($username);
        }
    }

    public function authUtilisateur($nom, $mdp) {
        $v = new \mywishlist\vue\Utilisateur();
        $user = \mywishlist\model\Utilisateur::where('username', '=', $nom)->first();
        if(!is_null($user)){
            if(password_verify($mdp, $user->passwd)) {
                $this->loadProfile($user->uid);
                $this->checkAccessRights(1500);
                $v->utilisateurExistant($nom);
            }
        }

        return $user;
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

    public function checkAccessRights($required){
        if($_SESSION['login']['auth-level'] < $required){
            echo "ACCESS DENIED";
        }
    }


}