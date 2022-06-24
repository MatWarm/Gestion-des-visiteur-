<?php
/*
 * Description de c_deconnexion.php
 *
 * auteur Valentin, Sylvain
 * Creation 01/2021
 * Derniere MAJ 27/04/2021
*/
if ( $_SERVER["SCRIPT_FILENAME"] == __FILE__ ){
    $racine="..";
}
include_once "$racine/modele/authentification.inc.php";

logout();

$titre = "GSB - Connexion";
include "$racine/vue/entete.php";
include "$racine/vue/vueConnexion.php";



?>