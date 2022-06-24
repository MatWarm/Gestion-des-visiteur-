<?php
/*
 * Description de controleurPrincipal.php
 * 
 * auteur Valentin, Sylvain
 * Creation 05/04/2021
 * Derniere MAJ 27/04/2021
*/
function controleurPrincipal(string $action){
    $lesActions = array();
    $lesActions["defaut"] = "c_connexion.php";
    $lesActions["deconnexion"] = "c_deconnexion.php";
    $lesActions["application"] = "c_application.php";
    $lesActions["parametres"] = "c_parametres.php";
    $lesActions["medicaments"] = "c_medicaments.php";
    $lesActions["rapportVisite"] = "c_rapportVisite.php";
    $lesActions["visiteurs"] = "c_visiteur.php";

    if (array_key_exists ( $action , $lesActions )){
        return $lesActions[$action];
    }
    else{
        return $lesActions["defaut"];
    }

}

?>