<?php

namespace mywishlist\controller;

class Liste {

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

}
