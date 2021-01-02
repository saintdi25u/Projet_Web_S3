<?php

namespace mywishlist\vue;

 use Slim\App;
 use Slim\Container;

 class Liste extends Vue
 {

     protected $liste;

     public function creerFormListe()
     {
         echo <<<ezz
    <h2> Creation d'une nouvelle Liste </h2>
    <form action ="" method = "post">
    User_ID de la liste : <input type = "number" name = "user_id" >
    Titre de la liste : <input type = "text" name = "titre" required>
    Description de la liste : <input type = text name = "description">
    Expiration de la liste : <input type = "date" required name = "expiration">
    <input type = "submit" value="Créer">
</form>
ezz;
     }


     public function render()
     {
         $this->html = $this->creerFormListe();
         echo parent::render();
     }
 }