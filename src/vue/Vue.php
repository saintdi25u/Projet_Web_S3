<?php

namespace mywishlist\vue;


class Vue{

    protected $html;
    protected $tab;
    protected $container;

    public function __construct($tab, $container){
        $this->tab = $tab;
        $this->container = $container;
    }
}
