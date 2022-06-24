<?php
/*
 * Description de bd.departement.inc.php
 * propose les fonctions d'accés à la base de données (partie conseiller)
 * auteur Sylvain
 * Creation 01/2021
 * Derniere MAJ 04/10/2021
*/




function getDepartement(){
    
    $resultat = array();
    
    try{
        $cnx = connexionPDO();

        $sql="SELECT * FROM DEPARTEMENT";

        $req = $cnx->prepare($sql);
        
        $req->execute();
        
        // Récupération de l'enregistrement
        $resultat = $req->fetchAll();
        
    } catch (Exception $ex) {
        print('Erreur de connexion pdo');
        die();
    }
    
    return $resultat;
    
}



function getDepartementbyId($id){
    
    $resultat = array();
    
    try{
        $cnx = connexionPDO();

        $sql="SELECT * FROM DEPARTEMENT WHERE DEPARTEMENT_ID= :id";

        $req = $cnx->prepare($sql);
        $req->bindValue(':id', $id, PDO::PARAM_INT);
        
        $req->execute();
        
        // Récupération de l'enregistrement
        $resultat = $req->fetchAll();
        
    } catch (Exception $ex) {
        print('Erreur de connexion pdo');
        die();
    }
    
    return $resultat;
    
}