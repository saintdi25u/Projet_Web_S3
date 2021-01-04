<?php

namespace mywishlist\vue;

use Illuminate\Support\Facades\View;

class Utilisateur extends Vue  {

    public function registerForm(){
        echo  <<<eze
        <h2> Enregistrez-vous </h2>
        <form action = "" method = "post">
        Nom : <input type = "text" name = "nom">
        <p>Mot de passe : <input type ="password" name = "password"></p>
        <input type = "submit" value = "S'enregistrer">
         </form>
    eze;
    }

    public function ConnectionForm(){
        echo  <<<eze
        <h2> Connecter-vous </h2>
        <form action = "" method = "post">
        Nom : <input type = "text" name = "nom-connect">
        <p>Mot de passe : <input type ="password" name = "password-connect"></p>
        <input type = "submit" value = "Connexion">
         </form>
    eze;
    }

    public function accueil(){
        echo "ACCCEUIL : Racine du site";
    }

    public function creationSucees($name){
        echo '<h2> Creation de lutilisateur avec succès. Bonjour, ' . $name . '</h2>';
    }

    public function utilisateurExistant($username){
        echo '<h3> Bonjour ' . $username . '</h3>';
    }


    public function render(){
        $this->html = $this->registerForm();
        echo parent::render();
    }

}