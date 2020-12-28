<?php

namespace mywishlist\vue;

class Utilisateur {

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

}