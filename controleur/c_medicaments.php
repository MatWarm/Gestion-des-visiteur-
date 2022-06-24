<?php
/*
 * Description de c_medicament.php
 * Affichage des médicaments
 * Auteurs Valentin
 * Creation 13/09/2021
*/
if ( $_SERVER["SCRIPT_FILENAME"] == __FILE__ ){
    $racine="..";
}

require_once "$racine/modele/bd.inc.php";
require_once "$racine/modele/authentification.inc.php";
require_once "$racine/modele/bd.medicaments.inc.php";

// Récuperation des donnees GET, POST, et SESSION
if (!isset($_SESSION)) {
    session_start();
}

// Variable stockant un booléen permettant de créer un message d'erreur
$erreurAffichage=false;

// Gestion du message d'erreur :
if(isset($_POST["nouveauIden"]) && $erreurAffichage === true){
    
    $msgErreur="Base de données vide<br/>";
    
}

// ZONE DE TESTS
//var_dump(getMedicamentsPerturbes("CLAZER6"));

// Chargement des médicaments
$listeMedicaments= getMedicaments();
//var_dump($listeMedicaments);


if (isLoggedOn()){

    
    $titre = "GSB - Pharmacopée";
    include "$racine/vue/entete.php";
    include "$racine/vue/header.php";
    include "$racine/vue/vueMedicaments.php";
    include "$racine/vue/pied.php";
    
}
else{
    
    $titre = "GSB - Connexion";
    include "$racine/vue/entete.php";
    include "$racine/vue/vueConnexion.php";
}

?>