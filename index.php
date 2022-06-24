<?php
/*
 * Description de index.php
 * fichier demarrage de l'application
 * auteur Valentin, Sylvain
 * Creation 05/04/2021
 * Derniere MAJ 27/04/2021
*/
include "getRacine.php";
include "$racine/controleur/controleurPrincipal.php";
include_once "$racine/modele/authentification.inc.php";

if (isset($_GET["action"])){
    $action = $_GET["action"];
}
else{
    $action = "defaut";
}

$fichier = controleurPrincipal($action);
include "$racine/controleur/$fichier";
?>
     