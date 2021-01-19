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
            <form action ="$url_listes" method = "post">
                User_ID de la liste : <input type = "number" name = "user_id" required >
                Titre de la liste : <input type = "text" name = "titre" required>
                Description de la liste : <input type = text name = "description" required >
                Expiration de la liste : <input type = "date" required name = "expiration" required >
            <input type = "submit" value="Créer">
            </form>
    FIN;
     }

     public function afficherAllListes() {
         $html = '';
         $id = 1;
         foreach($this->tab as $liste){
             $url = $this->container->router->pathFor('showContenuListe', ['no' => $id]);
             $html .= "<p>{$liste['titre']}''{$liste['description']} </p>";
             $html .= "<a href = '$url'>Voir le détail de la liste </a> ";
             $id++;
         }
         $html = "<ulstyle = list-style: none>$html</ul>";
         return $html;
     }


     public function afficherUneListeAvecContenu(){
         $liste = $this->tab[0];
         $html = "<link type='text/css' rel='stylesheet' href='../../main.css'>";
         $html .= "<h2> Liste  : {$liste['no']} </h2>";
         $html .= "<h2> Titre : {$liste['titre']} </h2>";
         $html .= "<h2> Description : {$liste['description']} </h2>";
         return $html;
     }

     public function afficherListeAvecDelete(){
        $html = '';
        $no = 1;
        foreach($this->tab as $liste){
            $url = $this->container->router->pathFor('showContenuDeleteListe');
            $html = "<link type='text/css' rel='stylesheet' href='../../main.css'>";
            $html .= "<li>{$liste['titre']}''{$liste['description']} </li>";
            $html .= "  <form action ='$url' method = 'post'>
                        <button type = 'submit' name = 'delete' value = '{$liste['no']}'> Supprimer </button> <br>
                        </form>";
        }
        $html = "<ulstyle = list-style: none>$html</ul>";
        return $html;
     }

     public function formModifListe(){
        $url = $this->container->router->pathFor('racine');
        echo <<<FIN
        <h2> Modification de la liste  </h2>
        <form action ="$url" method = "post">
        Description : <input type = "text" name = "description" required >
        Titre de la liste : <input type = "text" name = "titre" required>
        Expiration de la liste : <input type = "date" required name = "expiration" required >
        <input type = "submit" value="Modifier">
    </form>
    FIN;
     }



     public function reservationSucces(){
         $html = "<h2> Vous avez bien reservé l'item</h2>";
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
             }case 2 : {
                 $content = "<h2>Vous n'avez pas les droits pour effectuer cette action</h2>";
                 break;
             }
             case 3 : {
                $content = $this->afficherUneListeAvecContenu();
                 break;
             }
             case 4 : {
                 $content = $this->reservationSucces();
                 break;
             }

             case 5 : {
                 $content = "<p>Voici les fonctionalités disponibles pour les listes</p>";
                 break;
             }

             case 6 : {
                 $content = "<h2> La liste que vous avez choisi a été supprimé";
                 break;
             }

             case 7 : {
                 $content = $this->afficherListeAvecDelete();
             }
         }


         $url_acceuil = $this->container->router->pathFor( 'racine' );
         $url_connection = $this->container->router->pathFor( 'connect' );
         $url_deconnexion = $this->container->router->pathFor('deconnexion');
         $url_showlistes = $this->container->router->pathFor('showListe');
         $url_formListe = $this->container->router->pathFor('formListe');
         $url_showListeParNo = $this->container->router->pathFor('showListeParNo', ['no' => 1]);
         $url_deleteListe = $this->container->router->pathFor('showContenuDeleteListe');

         $html = <<<aaa

<!DOCTYPE html>
<html>
  <head>
    <title>Accueil</title> 
    
  <link type="text/css" rel="stylesheet" href="../main.css">
  </head>
  <body>
        <h1><a href="$url_acceuil">Wish List</a></h1>
		<nav>
			<ul>
				<li><a href="$url_acceuil">Accueil</a></li> 
				<li><a href = "$url_deconnexion"> Déconnexion</a></li>
				<li><a href ="$url_formListe">Ajouter une liste</a></li>
			    <li><a href ="$url_showlistes">Afficher les listes disponibles</a></li>
                <li><a href ="$url_showListeParNo">Afficher une liste par son numéro</a></li>
                <li><a href ="$url_deleteListe">Supprimer une liste</a></li>
			</ul>
		</nav>
		<h2> Fonctionalités pour les listes </h2>
    $content
  </body>
  <footer>© 2021 Wishlist</footer>
</html>
aaa;
         return $html;


     }
 }