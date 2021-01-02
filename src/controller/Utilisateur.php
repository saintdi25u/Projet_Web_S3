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
            $v->utilisateurExistant($nom);
            $this->authUtilisateur($nom,$mdp);
        } else {
            $user -> save();
            $v->creationSucees($nom);
        }
    }

    public function authUtilisateur($nom, $mdp) : \mywishlist\model\Utilisateur {
        $v = new \mywishlist\vue\Utilisateur();
        $user = \mywishlist\model\Utilisateur::where('username', '=', $nom)->first();
            if(password_verify($mdp, $user->password)) {
                $v->utilisateurExistant($nom);
            }
        return $user;
        }
}