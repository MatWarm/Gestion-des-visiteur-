<?php
/*
 * Description de bd.visiteur.inc.php
 * auteur Sylvain
 * Creation 01/2021
 * Derniere MAJ 04/10/2021
*/
require_once 'bd.inc.php';
include_once "bd.departement.inc.php";




function getVisiteurbyId($visId){
    $resultat = array();
    
    try{
        $cnx = connexionPDO();

        $sql="SELECT IDENTIFIANT_COMPTE, VIS_NOM, VIS_PRENOM, VIS_ADRESSE, VIS_CP, VIS_VILLE, VIS_DEPARTEMENT, "
             . "IFNULL( (SELECT SEC_LIBELLE FROM SECTEUR WHERE VISITEUR.SEC_CODE = SECTEUR.SEC_CODE), 'Secteur non renseigné') "
             . "AS 'SECTEUR' "
             . "FROM VISITEUR "
             . "WHERE VIS_MATRICULE=:visId";

        $req = $cnx->prepare($sql);
        $req->bindValue(':visId', $visId, PDO::PARAM_STR);
        
        $req->execute();
        
        // Récupération de l'enregistrement
        $resultat = $req->fetchAll();
        
        
    } catch (Exception $ex) {
        print('Erreur de connexion pdo');
        die();
    }
    
    return $resultat;
}




function getVisiteursbyDepartement($idDepart){
    $resultat = array();
    
    try{
        $cnx = connexionPDO();

        $sql="SELECT VIS_NOM, IDENTIFIANT_COMPTE FROM VISITEUR WHERE VIS_DEPARTEMENT = :id";

        $req = $cnx->prepare($sql);

        $req->bindValue(':id', $idDepart, PDO::PARAM_INT); 
        
        $req->execute();
        
        $resultat = $req->fetchAll();
        
    } catch (Exception $ex) {
        print('Erreur de connexion pdo');
        die();
    }
    
    return $resultat;
}





function getListeDepartement(){
    $listederoulante='<select name="listeDepartement" id="listeDepartement" onchange="envoyerRequeteVisiteur(this.value)">';
    $i=0;  
    $lesDepartements = getDepartement();
    
    
    // parcours du tableau des départements
    while ($i<count($lesDepartements)){
        
        
    $listederoulante=$listederoulante.'<option value="'.$lesDepartements[$i]["DEPARTEMENT_ID"]
                .'">'.$lesDepartements[$i]["DEPARTEMENT_NOM"].'</option>';
        $i++;
    }
    $listederoulante .= '</select><br>';
    return $listederoulante;
}




function getListeVisiteurs($idDepartement){
    $listederoulante='<select name="listeVisiteurs" id="listeVisiteurs">';
    $i = 0;
    $lesVisiteurs = getVisiteursbyDepartement($idDepartement);
    
    while ($i<count($lesVisiteurs))
    {

        $listederoulante = $listederoulante.'<option value="'.$lesVisiteurs[$i]["IDENTIFIANT_COMPTE"].'" '
            . 'onclick="envoyerinfosVisiteur(this.value)">'.$lesVisiteurs[$i]["VIS_NOM"].'</option>';
        $i++;
    }
    
    
    $listederoulante .= '</select><br>';
    return $listederoulante;
    
}


function nouveauMdp(string $nouveauMdp, string $identifiant){
    try {
       $sql = "update VISITEUR SET MDP_COMPTE = :nouveauMdp "
            . "where IDENTIFIANT_COMPTE = :identifiantV";
       $cnx = connexionPDO();
       $req = $cnx->prepare($sql);
       // Affectation des valeur SQL aux variables PHP
       $req->bindValue(':nouveauMdp', hash('md5',$nouveauMdp), PDO::PARAM_STR);
       $req->bindValue(':identifiantV', $identifiant, PDO::PARAM_STR);
       $req->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}


function nouveauIden(string $nouveauIdentifiant, string $identifiant){
    try {
       $sql = "update VISITEUR SET IDENTIFIANT_COMPTE = :nouveauId "
               . "where IDENTIFIANT_COMPTE = :identifiantV";
       $cnx = connexionPDO();
       $req = $cnx->prepare($sql);
       // Affectation des valeur SQL aux variables PHP
       $req->bindValue(':nouveauId', $nouveauIdentifiant, PDO::PARAM_STR);
       $req->bindValue(':identifiantV', $identifiant, PDO::PARAM_STR);
       $result = $req->execute();
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $result;
}


function existe_identifiant(string $id){
    $exist = False;
    
    try{
        $cnx = connexionPDO();

        $sql="SELECT COUNT(IDENTIFIANT_COMPTE) FROM VISITEUR "
                . "where IDENTIFIANT_COMPTE = :identifiant";

        $req = $cnx->prepare($sql);

        $req->bindValue(':identifiant', $id, PDO::PARAM_STR); 

        $req->execute(); //test la requète

        $cb_correspondance = $req->fetch(PDO::FETCH_ASSOC);
        if($cb_correspondance['COUNT(IDENTIFIANT_COMPTE)'] > 0){
            $exist = True;
        }
    }catch(PDOException $e){
        print('Erreur de connexion pdo');
        die();
    }
    
    return $exist;
}


function existe_mdp(string $mdp){
    $exist = False;
    
    try{
        $cnx = connexionPDO();

        $sql="SELECT COUNT(*) FROM VISITEUR "
                . "where MDP_COMPTE = :mdp";

        $req = $cnx->prepare($sql);

        $req->bindValue(':mdp', hash('md5',$mdp), PDO::PARAM_STR); 

        $req->execute(); //test la requète
        
        $cb_correspondance = $req->fetch(PDO::FETCH_ASSOC);
        if($cb_correspondance['COUNT(*)'] > 0){
            $exist = True;
        }
    } catch (Exception $ex) {
        print('Erreur de connexion pdo');
        die();
    }
    
    return $exist;
}



?>