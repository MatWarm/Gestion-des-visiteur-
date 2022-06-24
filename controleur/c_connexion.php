<?php
/*
 * Description de c_connexion.php
 * Gere la connexion du visiteur
 * Auteurs Valentin, Sylvain, Mattéo, Guillaume
 * Creation 05/04/2021
 * Derniere MAJ 27/04/2021
*/

require_once "$racine/modele/authentification.inc.php";
require_once "$racine/modele/bd.inc.php";

// creation du menu 
$menuGSB = array();
$menuGSB[] = Array("url"=>"./?action=connexion","label"=>"Connexion");


// recuperation des donnees GET, POST, et SESSION

if (isset($_POST["idVIS"]) && isset($_POST["mdpVIS"])){
    
    if($_POST["idVIS"]!== "" && $_POST["mdpVIS"]!==""){
        
        $idVisit  = filter_input(INPUT_POST, 'idVIS', FILTER_SANITIZE_STRING);
        $mdpVisit = filter_input(INPUT_POST, 'mdpVIS', FILTER_SANITIZE_STRING);
        #print_r($idVisit,$mdpVisit);

        $fichier = login($idVisit,$mdpVisit);

        
    }
}
else
{
    $idVisit="";
    $mdpVisit="";
    
}

if (isLoggedOn()){
    include "$racine/controleur/$fichier";
}
else{
    $titre = "GSB - Connexion";
    include "$racine/vue/entete.php";
    include "$racine/vue/vueConnexion.php";
}


?>