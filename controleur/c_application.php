<?php
/*
 * Description de c_application.php
 * Affiche l'accueil de l'application
 * Auteurs Valentin, Sylvain, Mattéo, Guillaume
 * Creation 01/2021
 * Derniere MAJ 27/04/2021
*/
if ( $_SERVER["SCRIPT_FILENAME"] == __FILE__ ){
    $racine="..";
}
include_once "$racine/modele/authentification.inc.php";

// Vérifie si un visiteur est connecté
if (isLoggedOn()){
   
    // traitement si necessaire des donnees recuperees


    // appel du script de vue qui permet de gerer l'affichage des donnees
    $titre = "GSB - Application";
    include "$racine/vue/entete.php";
    include "$racine/vue/header.php";
    include "$racine/vue/vueApplication.php";
    include "$racine/vue/pied.php";
}
else{
    $titre = "GSB - Connexion";
    include "$racine/vue/entete.php";
    include "$racine/vue/vueConnexion.php";
}

?>