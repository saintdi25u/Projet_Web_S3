<?php

namespace mywishlist\vue;

 use Slim\App;
 use Slim\Container;

 class VueListe extends Vue
 {

     /**
      * VueListe constructor.
      * @param $tab
      * @param $container
      */
     public function __construct($tab, $container)
     {
         parent::__construct($tab, $container);
     }

     /**
      * Permet la création et l'affichage du formulaire pour les listes
      */
     public function creerFormListe()
     {
         $url_listes = $this->container->router->pathFor('formListe');
         echo <<<FIN
            <div><form action ="$url_listes" method = "post">
                <p>User_ID de la liste : <input type = "number" name = "user_id" required ></p>
                <p>Titre de la liste : <input type = "text" name = "titre" required></p>
                <p>Description de la liste : <input type = text name = "description" required ></p>
                <p>Expiration de la liste : <input type = "date" required name = "expiration" required ></p>
                <p><input type = "submit" value="Créer"></p>
            </form></div>
    FIN;
     }

     /**
      * Permet la création et l'affichage du formulaire pour toutes les listes
      */
     public function afficherAllListes() {
         $html = '';
         $id = 1;
         foreach($this->tab as $liste){
             $url = $this->container->router->pathFor('showContenuListe', ['no' => $id]);
             $html .= "<div><p>{$liste['titre']} -- {$liste['description']} -- Date de fin : {$liste['expiration']}</p>";
             $html .= "<p><a href = '$url'>Voir le détail de la liste </a></p></div> ";
             $id++;
         }
         $html = "<ulstyle = list-style: none>$html</ul>";
         return $html;
     }

     /**
      * Permet la création et l'affichage du formulaire pour une liste avec son contenu détaillé
      */
     public function afficherUneListeAvecContenu(){
         $liste = $this->tab[0];
         $html = "<link type='text/css' rel='stylesheet' href='../../main.css'>";
         $html .= "<div><p> Liste : {$liste['no']} </p>";
         $html .= "<p> Titre : {$liste['titre']} </p>";
         $html .= "<p> Description : {$liste['description']} </p>";
         $html .= "<p> Expiration : {$liste['expiration']} </p></div>";
         return $html;
     }

     /**
      * Permet la création et l'affichage du formulaire pour les listes à supprimer
      */
     public function afficherListeAvecDelete(){
        $html = '';
        foreach($this->tab as $liste){
            $url = $this->container->router->pathFor('showContenuDeleteListe');
            $url_modif = $this->container->router->pathFor('modifListe');
            $html .= "<link type='text/css' rel='stylesheet' href='../../main.css'>";
            $html .= "<div><p>{$liste['titre']}''{$liste['description']} </p>";
            $html .= "       <form action ='$url' method = 'post'>
                                <p><button type = 'submit' name = 'delete' value = '{$liste['no']}'> Supprimer </button></p>
                            </form> 
                        
                            <form action ='$url_modif' method = 'get' >
                                <p><button type = 'submit' name = 'modif' value = '{$liste['no']}'> Modifier </button></p>
                            </form>   
                       </div>";
        }
        return $html;
     }

     /**
      * Permet la création et l'affichage du formulaire pour les listes à modifier
      */
     public function formModifListe(){
        $url = $this->container->router->pathFor('modifListe');
        echo <<<FIN
        <link type='text/css' rel='stylesheet' href='../../main.css'>
        <h2> Modification de la liste </h2>
        <div><form action ='$url' method = 'post'>
        <p>Description : <input type = "text" name = "description" required ></p>
        <p>Titre de la liste : <input type = "text" name = "titre" required></p>
        <p>Expiration de la liste : <input type = "date" required name = "expiration" required ></p>
        <p><button type = 'submit' name = 'modif' value = '{$_GET['modif']}'> Modifier </button></div></p>
        <footer>© 2021 Wishlist</footer>
    </form>
    FIN;
     }


     /**
      * Permet l'afficher lorsque la réservation a été effectué'
      */
     public function reservationSucces(){
         $html = "<h2> Vous avez bien reservé l'item</h2>";
         return $html;
     }

     /**
      * @param int $select
      * @return string
      * Permet de choisir quel formulaire choisir
      */
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
                 $content = "<h2> La liste que vous avez choisi a été supprimée</h2>";
                 break;
             }

             case 7 : {
                 $content = $this->afficherListeAvecDelete();
                 break;
             }

             case 8 : {

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
  <link type='text/css' rel='stylesheet' href='../../main.css'>
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
  <footer>© 2021 Wishlist / SAINT-DIZIER Corentin - VIRICH John - RUDYNSKI Thomas</footer>
</html>
aaa;
         return $html;


     }
 }