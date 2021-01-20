<?php

namespace mywishlist\vue;
class VueItem extends Vue{

    /**
     * VueItem constructor.
     * @param $tab
     * @param $container
     */
    public function __construct($tab, $container)
    {
        parent::__construct($tab, $container);
    }

    /**
     * Permet la création et l'affichage du formulaire pour les items
     */
    public function creerFormItem(){
        $url_create = $this->container->router->pathFor('createItem');
        echo <<<eze
            <div><h3> Creation d'un item </h3>
            <form action = "$url_create" method="post">
                <p>ID de la liste a inserer : <input type ="number" name = "liste_id" required></p>
                <p>Nom de l'item : <input type = "text" name = "nom" required></p>
                <p>Description de l'item : <input type = "text" name="description"></p>
                <p>Image : <input type ="text" name = "img"></p>
                <p>URL : <input type = "url" name = "url"></p>
                <p>Tarif : <input type = "number" name = "tarif" required></p>
                <p><input type = "submit" value="Créer"></p>
            </form></div>
        eze;
    }

    /**
     * Permet la création et l'affichage du formulaire pour les items triés par id
     */
    public function afficherItemParId()
    {
        $item = $this->tab[0];
        $html = "<div><h2 class='item'>Item {$item['id']}</h2>";
        $html .= "<p><b>Nom:</b> {$item['nom']}</p>";
        $html .= "<p><b>Description:</b> {$item['descr']}</p>";
        $html .= "<p><img src = '../../../img/{$item['img']}' alt = '{$item['nom']}' width = 100px></div></p>";
        return $html;
    }

    /**
     * Permet la création et l'affichage du formulaire pour tous les items
     */
    public function afficherAllItem() {
        $html = '';
        foreach($this->tab as $item){
            $html .= "<div class='afficherAllItem'><img src = '../../img/{$item['img']}' alt = '{$item['nom']}'   width = 100px> ";
            $html .= "<p> ID : {$item['id']} </p> <p> Nom : {$item['nom']}</p> <p> Description : {$item['descr']}</p>  <p> Prix :{$item['tarif']}€ </p> </div>";
        }
        $html = "<ulstyle = list-style: none>$html</ul>";
        return $html;
    }

    /**
     * Permet la création et l'affichage du formulaire pour réserver un item
     */
    public function formMessageItem(){
        $url_reserve = $this->container->router->pathFor('reserve');
        $url_acceuil = $this->container->router->pathFor('racine');
        $html = <<<FIN
            <link type="text/css" rel="stylesheet" href="../../../main.css">
            <h2> Reserver un item</h2>
            <form action = "$url_reserve" method="post">
            Entrer l'ID de l'item que vous souhaitez réserver : <input type = "number" name = "id_item" required>
            Entrer votre nom <input type = "text" name = "nomParticipant" required>
            Entrer votre message <input type="text" name="message" required>
            <input type="submit" value= "Reserver">
            </form>
            <a href = "$url_acceuil"><button> Revenir a l'accueil </button></a> 
        FIN;
        return $html;
    }

    /**
     * Permet la création et l'affichage du formulaire pour le contenu d'un item
     */
    public function contenuItem(){
        $html = "<link type='text/css' rel='stylesheet' href='../../../main.css'>";
        foreach($this->tab as $i){
            $html .="<div>";
            $html .="<p> ID : {$i->id} </p>";
            $html .="<p> Nom : {$i->nom} </p>";
            $html .="<p> Description : {$i->descr} </p>";
            $html .="</div>";
        }

        return $html;
    }


    /**
     * @param int $select
     * @return string
     * Permet de choisir quel formulaire nous souhaitons
     */
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
            case 5 : {
                $content = '<p> Fonctionnalités pour les items</p>';
                break;
            }
        }


        $url_acceuil = $this->container->router->pathFor( 'racine' );
        $url_connection = $this->container->router->pathFor( 'connect' );
        $url_deconnexion = $this->container->router->pathFor('deconnexion');
        $url_showlistes = $this->container->router->pathFor('showListe');
        $url_formListe = $this->container->router->pathFor('formListe');
        $url_formItem = $this->container->router->pathFor('createItem');
        $url_showItem = $this->container->router->pathFor('showItem', ['id' => 1]);
        $url_showAllItem = $this->container->router->pathFor('showAllItem');


        $html = <<<aaa

<!DOCTYPE html>
<html>
  <head>
    <title>WishList</title>
    <link type="text/css" rel="stylesheet" href="../../main.css">
    <link type="text/css" rel="stylesheet" href="../main.css">
  </head>
  <body>
        <h1><a href="$url_acceuil">Wish List</a></h1>
		<nav>
			<ul>
				<li><a href="$url_acceuil">Accueil</a></li>
				<li><a href = "$url_deconnexion">Déconnexion</a></li>
				<li><a href ="$url_formItem" >Ajouter un item</a></li>
			    <li><a href ="$url_showItem" >Afficher un item par son ID</a></li>
			     <li><a href ="$url_showAllItem" >Afficher tous les items</a></li>
			    
			</ul>
		</nav>
	    <h2>Fonctionnalités pour les items </h2>
    $content
  </body>
  <footer>© / SAINT-DIZIER Corentin - VIRICH John - RUDYNSKI Thomas/footer>
</html>
aaa;
        return $html;


    }
}
