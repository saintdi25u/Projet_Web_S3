<?php

namespace mywishlist\vue;


class VueUtilisateur extends Vue  {

    public function __construct($tab, $container)
    {
        parent::__construct($tab, $container);
    }


    public function registerForm(){
        $url_connection = $this->container->router->pathFor('register');
        $html = <<<eze
        <h2> Enregistrez-vous </h2>
        <form action = "$url_connection" method = "post">
        <p>Nom : <input type = "text" name = "nom"></p>
        <p>Mot de passe : <input type ="password" name = "password"></p>
        <p><input type = "submit" value = "S'enregistrer"></p>
         </form>
    eze;

        return $html;
    }

    public function ConnectionForm() : string{
        $url_connection = $this->container->router->pathFor( 'connect' );
        $html=  <<<eze
        <h2> Connectez-vous </h2>
        <form action = "$url_connection" method = "post">
        <p>Nom : <input type = "text" name = "nom-connect"></p>
        <p>Mot de passe : <input type ="password" name = "password-connect"></p>
        <p><input type = "submit" value = "Connexion"></p>
         </form>
    eze;

        return $html;
    }




        public function render (int $select) : string {
            switch($select){
                case 0 : {
                    $content = '<h1>Bienvenue sur notre Application web MyWishList.</h1>
                                <p> Les fonctionnalités sont disponibles sur la barre de navigation situé en haut </p>';
                    break;
                }
                case 1 : {
                    $content = $this->ConnectionForm();
                    break;
            }
                case 2 : {
                    $content = $this->registerForm();
                    break;
                }
                case 3 : {
                    $content = '<h2 style = color:blue> Bienvenue ' . $this->tab['login'] .'</h2>';
                    break;
                }
                case 4 : {
                    $content = '<h2 style = color:blue> Vous êtes enregistré ' . $this->tab['login'] . '</h2>' ;
                    break;
                }
                case 5 : {
                    $content = '<h2 style = color:blue> Vous êtes déconnecté <h2>';
                    $content .= $this->ConnectionForm();
                    break;
                }
                case 6 : {
                    $content = '<h2 style = color:#ff0000> Login ou mot de passe incorrect, veuillez réessayer</h2>';
                    $content .= $this->ConnectionForm();
                    break;
                }
                case 7 : {
                    $vue = new VueListe($this->tab, $this->container);
                    $content = $vue->afficherAllListes();
                    break;
                }
                case 8 : {
                    $vue = new VueItem($this->tab, $this->container);
                    $content = $vue->afficherItemParId();
                    break;
                }
                case 9 : {
                    $vue = new VueItem($this->tab, $this->container);
                    $content = $vue->afficherAllItem();
                    break;
                }
                case 10 : {
                    $content = "<h2> Vous êtes deja déconnecté</h2>";
                    break;
                }
                case 11 : {
                    $content = '<h2 style = color:blue> Vous êtes deja connecté avec le profil :  ' . $this->tab['login'] .'</h2>';
                    break;
                }

            }

            $url_acceuil = $this->container->router->pathFor( 'racine' );
            $url_connection = $this->container->router->pathFor( 'connect' );
            $url_register = $this->container->router->pathFor( 'register' );
            //$url_voirListe = $this->container->router->pathFor('partieListe');

            $url_deconnexion = $this->container->router->pathFor('deconnexion');
            $url_formListe = $this->container->router->pathFor('formListe');
            $url_showlistes = $this->container->router->pathFor('showListe');
            $url_showItem = $this->container->router->pathFor('showItem', ['id' => 2]);
            $url_showAllItem = $this->container->router->pathFor('showAllItem');
            $url_createItem = $this->container->router->pathFor('createItem');

            $url_liste = $this->container->router->pathFor('liste');
            $url_items = $this->container->router->pathFor('item');

            $html = <<<aaa

<!DOCTYPE html>
<html>
  <head>
    <title>Accueil</title>
    <link type="text/css" rel="stylesheet" href="../main.css">
  </head>
  <body>
		<h1 id="titre"><a href="$url_acceuil">Wish List</a></h1>
		<nav>
			<ul class="menu">
				<li><a href="$url_acceuil">Accueil</a></li>
				<li><a href="$url_connection">Connection</a></li>
				<li><a href="$url_register">Si vous n'avez pas de compte, enregistrez-vous</a></li>
                <li><a href="$url_deconnexion"> Déconnexion</a></li>    
                <li><a href = "$url_liste"> Fonctionalités pour les listes</a></li>
                <li><a href = "$url_items"> Fonctionalités pour les items</a></li>     
			</ul>
		</nav>
    $content
  </body>
  <footer>© 2021 Wishlist / SAINT-DIZIER Corentin - VIRICH John - RUDYNSKI Thomas</footer>
</html>
aaa;
            return $html;
    }

}