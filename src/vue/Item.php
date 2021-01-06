<?php

namespace mywishlist\vue;
class Item extends Vue{

    function creerFormItem(){
        echo <<<eze
        <h3> Creation d'un item </h3>
        <form action = "" method="post">
         ID de l'item : <input type ="number" name = "liste_id" >
         Nom de l'item : <input type = "text" name = "nom" >
         Description de l'item : <input type = "text" name="description">
         Image : <input type ="text" name = "img">
         URL : <input type = "url" name = "url">
         Tarif : <input type = "number" name = "tarif">
         <input type = "submit" value="Créer">
        </form>
        eze;
    }

    public function render(){
        $this->html= $this->creerFormItem();
        echo  parent::render();
    }
}
