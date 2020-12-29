<?php
 namespace mywishlist\controller;

class Item {

    public function creerItem(){
        $v = new \mywishlist\vue\Item();
        $v ->render();
    }

    public function enregistrerItem(){
        $model = new \mywishlist\model\Item();

        $model->liste_id = $_POST['liste_id'];
        $model->nom = $_POST['nom'];
        $model->descr = $_POST['description'];
        $model ->img = $_POST['img'];
        $model -> url = $_POST['url'];
        $model ->tarif = $_POST['tarif'];

        $model ->save();
    }
}