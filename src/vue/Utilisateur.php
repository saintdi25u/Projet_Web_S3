<?php

namespace mywishlist\vue;

use Illuminate\Support\Facades\View;

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

    public function creationSucees(){
        echo '<h2> Creation de lutilisateur avec succès </h2>';
    }

    public function utilisateurExistant(){
        echo '<h2> Utilisateur deja existant </h2>';
    }

    public function render(){
        $content = $this->registerForm();
         $html = <<<END
         <!DOCTYPE html>
         <head>
         </head>
          <body>
          $content;
</body>
END;

         return $html;
    }

}