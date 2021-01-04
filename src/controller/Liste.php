<?php

namespace mywishlist\controller;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

class Liste {

    private $uti ;

    public function creerListe(){
        $v = new \mywishlist\vue\Liste();
        $v ->render();
    }

    public function enregistrerListe()
    {
        $model = new \mywishlist\model\Liste();
        $model->user_id = $_POST['user_id'];
        $model->titre = $_POST['titre'];
        $model->description = $_POST['description'];
        $model->expiration = $_POST['expiration'];
        $model->token = dechex(random_int(0, 0xFFFFFFF));
        $model->save();
    }

    public function afficherListe(Request $rq, Response $rs, $args) : Response {
            $model= new \mywishlist\model\Liste();
            $lists = \mywishlist\model\Liste::all();
            $vue = new \mywishlist\vue\Liste();
            print "<h2>Listes Disponibles</h2>";
            foreach($lists as $list){
                print( 'Numéro  : ' . $list ->no . "<br>" );
                print( 'User_id : ' . $list ->user_id . "<br>" );
                print( 'Titre de la liste : ' . $list ->titre . "<br>" );
                print( 'Description de la liste  : ' . $list ->description . "<br>" );
                print( 'Expiration de la liste : ' . $list -> expiration . "<br>" );
                // $vue ->showContenuListe();
                print "<br>";
            }
    }
  

}
