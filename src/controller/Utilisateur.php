<?php
namespace mywishlist\controller;

class Utilisateur{

    public function registerForm(){
        $v = new \mywishlist\vue\Utilisateur();
        $v -> render();
    }

    public function creerUtilisateur($nom, $mdp){
        $v = new \mywishlist\vue\Utilisateur();
        $user = new \mywishlist\model\Utilisateur();
        $user->username = $nom;
        $user -> passwd = password_hash($mdp, PASSWORD_DEFAULT, ['cost'=> 12]);
        $name = \mywishlist\model\Utilisateur::where('username', '=', $nom)->first();
        if(!is_null($name)){
            $v->utilisateurExistant();
        } else {
            $user -> save();
            $v->creationSucees();
        }
    }

    public function authUtilisateur($nom, $mdp) : \mywishlist\model\Utilisateur {
        $user = \mywishlist\model\Utilisateur::where('username', '=', $nom)->first();
        if(!is_null($user)){
            if(password_verify($mdp, $user->password)){
                echo ' (Utilisateur deja existant) Bonjour' . $user->username;
            }
        }
        return $user;
        }
}