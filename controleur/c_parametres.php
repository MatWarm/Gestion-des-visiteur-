<?php
/*
 * Description de c_nouveauMdp.php
 * gere la connexion du conseiller
 * Auteurs Valentin, Sylvain, Mattéo, Guillaume
 * Creation 06/04/2021
 * Derniere MAJ 27/04/2021
*/
if ( $_SERVER["SCRIPT_FILENAME"] == __FILE__ ){
    $racine="..";
}
require_once "$racine/modele/authentification.inc.php";
require_once "$racine/modele/bd.inc.php";

// recuperation des donnees GET, POST, et SESSION

if (!isset($_SESSION)) {
    session_start();
}
// Variables:

// Variable identifiant l'utilisateur
$identifiant = $_SESSION['idVIS']; 

// Variable stockant un booléen permettant de créer un message d'erreur
$erreurIdentifiant=false;

// Variable stockant un booléen permettant de créer message d'erreur
$erreurMdp=false;



// Changement de l'identifiant :
if ((isset($_POST["nouveauIden"]) && isset($identifiant)) 
    && ($_POST["nouveauIden"] !== "" && $identifiant !==  "")
    && !existe_identifiant($_POST["nouveauIden"])){
    // si un nouvel identifiant a été choisi
    // et si celui-ci n'existe pas encore dans la base de donnée
    
    
    // on change l'identifiant dans la base de donnée
    $newIdentifiant = filter_input(INPUT_POST,"nouveauIden",FILTER_SANITIZE_STRING);
    if(identifiant_est_valid($newIdentifiant)){
        nouveauIden($newIdentifiant,$identifiant);
        $msgPositif = "Changement d'identifiant effectué !";
    }
    else
    {
        $msgErreur = "Identifiant invalide, un identifiant doit au moins contenir une lettre minuscule, une lettre majuscule et un chiffre";
    }
    
    
}else{
    $erreurIdentifiant=true;
}



// Gestion du message d'erreur de l'identifiant :
if(isset($_POST["nouveauIden"]) && $erreurIdentifiant === true){
    
    $msgErreur="Champs nouveau identifiant vide<br/>";
    
}



// Changement du mot de passe :
if ( (isset($_POST["nouveauMdp"]) && isset($identifiant)) 
    && ($_POST["nouveauMdp"] !== "" && $identifiant !==  "")){
    // si un nouveau mot de passe a été choisi
    
    
    // on change le mot de passe dans la base de donnée
    $newmdp = filter_input(INPUT_POST,"nouveauMdp",FILTER_SANITIZE_STRING);
    if (mdp_est_valid($newmdp)){
        nouveauMdp($newmdp,$identifiant);
        $msgPositif = "Changement de mot de passe effectué !";
    }
    else
    {
        $msgErreur = "Mot de passe invalide, 12 charactères dont au moins un charactère spécial un chiffre et une lettre de l'alphabet";
    }

}else{
    
    $erreurMdp=true;
    
}



// Déconnexion après un changement d'id ou de mot de passe réussi.
if(isset($newIdentifiant) || isset($newmdp)){
    
    // si l'id ou le mdp à été changé, alors on déconnecte l'utilisateur
    logout(); 
}



// Gestion du message d'erreur du mot de passe :
if(isset($_POST["nouveauMdp"]) && $erreurMdp===true){
    
    $msgErreur="Champs nouveau mot de passe vide<br/>";
}



if (isLoggedOn()){

    
    $titre = "GSB - Paramètres";
    include "$racine/vue/entete.php";
    include "$racine/vue/header.php";
    include "$racine/vue/vueParametres.php";
    include "$racine/vue/pied.php";
    
}
else{
    
    $titre = "GSB - Connexion";
    include "$racine/vue/entete.php";
    include "$racine/vue/vueConnexion.php";
}

?>