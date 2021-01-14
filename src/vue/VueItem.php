<?php

namespace mywishlist\vue;
class VueItem extends Vue{

    public function __construct($tab, $container)
    {
        parent::__construct($tab, $container);
    }

    public function creerFormItem(){
        $url_create = $this->container->router->pathFor('createItem');
        echo <<<eze
        <h3> Creation d'un item </h3>
        <form action = "$url_create" method="post">
         ID de la liste a inserer : <input type ="number" name = "liste_id" required >
         Nom de l'item : <input type = "text" name = "nom" required >
         Description de l'item : <input type = "text" name="description">
         Image : <input type ="text" name = "img">
         URL : <input type = "url" name = "url">
         Tarif : <input type = "number" name = "tarif" required>
         <input type = "submit" value="Créer">
        </form>
        eze;
    }

    public function afficherItemParId()
    {
        $item = $this->tab[0];
        $html = "<h2>Item {$item['id']}</h2>";
        $html .= "<b>Nom:</b> {$item['nom']}<br>";
        $html .= "<b>Descr:</b> {$item['descr']}<br>";
        return $html;
    }


    public function afficherAllItem() {
        $html = '';
        foreach($this->tab as $item){
            $html .= "<li > ID : {$item['id']} <br> Nom : {$item['nom']} <br>   Description : {$item['descr']} <br>    Prix :{$item['tarif']}€ <br> <br> </li>";
        }
        $html = "<ulstyle = list-style: none>$html</ul>";
        return $html;
    }

    public function formMessageItem(){
        $url_reserve = $this->container->router->pathFor('reserve');
        $html = <<<FIN
            <h2> Reserver un item</h2>
            <form action = "$url_reserve" method="post">
            Entrer l'ID de l'item que vous souhaitez réserver : <input type = "number" name = "id_item" required> <br>
           <br> Entrer votre nom <input type = "text" name = "nomParticipant" required><br>
           <br> Entrer votre message <input type="text" name="message" required>
            <input type="submit" value= "Reserver">
            </form>
        FIN;
        return $html;

    }

    public function contenuItem(){
        $html = '';
        foreach($this->tab as $i){
            $html .="<p> ID : {$i->id} </p>";
            $html .="<p> Nom : {$i->nom} </p>";
            $html .="<p> Description : {$i->descr} </p>";
        }
        return $html;
    }





    public function render (int $select) : string
    {
        switch ($select) {
            case 0 :
            {
                $content = $this->creerFormItem();
                break;
            }
            case 1 :
            {
                $content = $this->afficheritemParId();
                break;
            }
            case 2 :
            {
                $content = $this->afficherAllItem();
                break;
            }
            case 3 :
            {
                $content = "<h2> Vous n'avez pas les droits pour effectuer cette action</h2>";
                break;
            }
            case 4 : {
                $content = $this->reservationSucces();
                break;
            }
        }


        $url_acceuil = $this->container->router->pathFor( 'racine' );
        $url_connection = $this->container->router->pathFor( 'connect' );
        $url_deconnexion = $this->container->router->pathFor('deconnexion');
        $url_showlistes = $this->container->router->pathFor('showListe');
        $url_formListe = $this->container->router->pathFor('formListe');
        $url_showItem = $this->container->router->pathFor('showItem', ['id' => 1]);
        $url_showAllItem = $this->container->router->pathFor('showAllItem');


        $html = <<<aaa

<!DOCTYPE html>
<html>
  <head>
    <title>WishList</title>
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
			    <li><a href ="$url_showItem" >Afficher un item par son ID</a></li>
			     <li><a href ="$url_showAllItem" >Afficher tous les items</a></li>
			    
			</ul>
		</nav>
    $content
  </body>
</html>
aaa;
        return $html;


    }
}
