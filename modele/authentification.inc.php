<?php
/*
 * Description de authentification.inc.php
 * fonctions gérant la partie authentification de l'utilisateur
 * auteur Valentin, Sylvain
 * Creation 06/04/2021
 * Derniere MAJ 27/04/2021
*/
require_once "bd.visiteur.inc.php";
require_once "authentification.inc.php";
require_once "bd.inc.php";


function login(string $idV, string $mdpV) {
    $fichier = "";
    if (!isset($_SESSION)) {
        session_start();
    }
    
    if (existe_identifiant($idV) && existe_mdp($mdpV)){
        
        if(!premiere_connexion($idV)){
            $_SESSION["idVIS"] = $idV;
            $_SESSION["mdpVIS"] = $mdpV;
            $fichier = "c_application.php";
        }
        else
        {
            $_SESSION["idVIS"] = $idV;
            $_SESSION["mdpVIS"] = $mdpV;
            $fichier = "c_parametres.php";
        }
    }

    return $fichier;
}


function logout() {
    if (!isset($_SESSION)) {
        session_start();
    }
    unset($_SESSION["idVIS"]);
    unset($_SESSION["mdpVIS"]);
}




function isLoggedOn() {
    if (!isset($_SESSION)) {
        session_start();
    }
    $ret = false;

    if (isset($_SESSION["idVIS"])) {
        if (existe_identifiant($_SESSION["idVIS"]) 
         && existe_mdp($_SESSION["mdpVIS"])) {
            $ret = true;
        }
    }
    return $ret;
}




function premiere_connexion($id){
    $is_prem_co = False;
    
    try{
        $cnx = connexionPDO();

        $sql="SELECT EXTRACT(YEAR_MONTH FROM VIS_DATEEMBAUCHE) as "
                . "FIRSTMDP, MDP_COMPTE FROM VISITEUR "
                . "where IDENTIFIANT_COMPTE = :identifiant";

        $req = $cnx->prepare($sql);

        $req->bindValue(':identifiant', $id, PDO::PARAM_STR); 

        $req->execute(); //test la requète

        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        
        #var_dump($ligne);
        if(hash('md5',$ligne['FIRSTMDP']) === $ligne['MDP_COMPTE']){
            $is_prem_co = True;
        }
    }catch(PDOException $e){
        print('Erreur de connexion pdo');
        die();
    }
    
    return $is_prem_co;
}


function mdp_est_valid(string $mdp){
    $valide = False;
    
    //  composition d'un mot de passe:
    //  
    //  1+ maj; 1+ min; 1+ caractère spécial; 12 caractères min; 1+ chiffre
    
    return preg_match("/^((?=.*?[a-z])"
            . "(?=.*?[A-Z])"
            . "(?=.*?[0-9])"
            . "(?=.*?[!#\$%&'\(\)\*\+,-\.\/:;<=>\?@[\]\^_`\{\|}~]))"
            . "[a-zA-Z0-9!#\$%&'\(\)\*\+,-\.\/:;<=>\?@[\]\^_`\{\|}~]{12,20}$/"
            , $mdp);
}


function identifiant_est_valid(string $identifiant){
    return preg_match("/^[a-zA-Z-0-9]$/",$identifiant);
}



?>