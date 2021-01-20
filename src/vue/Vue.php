<?php

namespace mywishlist\vue;


class Vue{

    /**
     * @var $html
     * @var $tab
     * @var $container
     * Attributs de la classe Vue dont vont hériter les autres Vues
     */
    protected $html;
    protected $tab;
    protected $container;

    /**
     * Vue constructor.
     * @param $tab
     * @param $container
     */
    public function __construct($tab, $container){
        $this->tab = $tab;
        $this->container = $container;
    }
}
