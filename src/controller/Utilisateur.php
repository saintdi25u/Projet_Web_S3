<?php
namespace mywishlist\controleur;

class Utilisateur{

    public function registerForm(){
        $v = new \mywishlist\vue\Utilisateur();
        $v -> registerForm();
    }

    public function creerUtilisateur($nom, $mdp){
        $user = new \mywishlist\model\Utilisateur();
        $user->nom = $nom;
        $user -> mdp = password_hash($mdp, PASSWORD_DEFAULT, ['cost'=> 12]);
        $user -> save();

    }

    public function authUtilisateur($nom, $mdp) : \mywishlist\model\Utilisateur {
        $user = \mywishlist\model\Utilisateur::where('nom', '=', $nom)->first();
        if(!is_null($user)){
            if(password_verify($mdp, $user->password)){
                return $user;
            }
        }
    }
}