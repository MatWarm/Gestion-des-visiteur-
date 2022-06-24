<?php
/*
 * Description de c_medicament.php
 * Affichage des médicaments
 * Auteurs Sylvain
 * Creation 27/09/2021
*/
if ( $_SERVER["SCRIPT_FILENAME"] == __FILE__ ){
    $racine="..";
}
require_once "$racine/modele/authentification.inc.php";
require_once "$racine/modele/bd.inc.php";

// Récuperation des donnees GET, POST, et SESSION
if (!isset($_SESSION)) {
    session_start();
}




if (isLoggedOn()){

    
    $titre = "GSB - Visiteurs";
    include "$racine/vue/entete.php";
    include "$racine/vue/header.php";
    include "$racine/vue/vueVisiteur.php";
    include "$racine/vue/pied.php";
    
}
else{
    
    $titre = "GSB - Connexion";
    include "$racine/vue/entete.php";
    include "$racine/vue/vueConnexion.php";
}