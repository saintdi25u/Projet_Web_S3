<?php

namespace mywishlist\vue;

 use Slim\App;
 use Slim\Container;

 class VueListe extends Vue
 {

     public function __construct($tab, $container)
     {
         parent::__construct($tab, $container);
     }

     public function creerFormListe()
     {
         $url_listes = $this->container->router->pathFor('formListe');
         echo <<<FIN
    <h2> Creation d'une nouvelle VueListe </h2>
    <form action ="$url_listes" method = "post">
    User_ID de la liste : <input type = "number" name = "user_id" >
    Titre de la liste : <input type = "text" name = "titre" required>
    Description de la liste : <input type = text name = "description">
    Expiration de la liste : <input type = "date" required name = "expiration">
    <input type = "submit" value="Créer">
</form>
FIN;
     }

     public function afficherAllListes() {
         $html = '';
         foreach($this->tab as $liste){
             $html .= "<li>{$liste['titre']}''{$liste['description']}</li>";
         }
         $html = "<ul>$html</ul>";
         return $html;
     }


     public function render (int $select) : string {
         switch($select){
             case 0 : {
                 $content = $this->creerFormListe();
                 break;
             }
             case 1 : {
                 $content = $this->afficherAllListes();
                 break;
             }
         }

         $url_acceuil = $this->container->router->pathFor( 'racine' );
         $url_connection = $this->container->router->pathFor( 'connect' );
         $url_deconnexion = $this->container->router->pathFor('deconnexion');
         $url_showlistes = $this->container->router->pathFor('showListe');
         $url_formListe = $this->container->router->pathFor('formListe');

         $html = <<<aaa

<!DOCTYPE html>
<html>
  <head>
    <title>Acceuil</title>
  </head>
  <body>
		<h1><a href="$url_acceuil">Wish List</a></h1>
		<nav>
			<ul>
				<li><a href="$url_acceuil">Accueil</a></li>
				<li><a href="$url_connection">Connection</a></li>
				<li><a href = "$url_deconnexion"> Déconnexion</a></li>
				<li><a href ="$url_formListe" >Ajouter une liste</a></li>
			    <li><a href ="$url_showlistes" >Afficher les listes disponibles</a></li>
			</ul>
		</nav>
    $content
  </body>
</html>
aaa;
         return $html;


     }
 }