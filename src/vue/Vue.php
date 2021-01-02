<?php

namespace mywishlist\vue;
class Vue{

    protected $html, $menu, $role;


    public function render (){
        /**
        if($this->role == DEMANDEUR){
            $titre = "Creation d'une liste de voeux";
        } else {
            $titre = "Participation à une liste de cadeaux";
        }
         * */
        return <<<eze
        <!DOCTYPE html>
        <html lang = "fr">
        <head>
            <meta charset="utf-8">
            
        </head>
        <body>
            $this->html
        </body>
eze;
    }
}
