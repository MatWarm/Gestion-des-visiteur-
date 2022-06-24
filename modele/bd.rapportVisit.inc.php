<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once "bd.inc.php";

function listerPraticien(){
    $resultat = array();
    try {
        $cnx = connexionPDO();
        $sql="select PRA_NUM, CONCAT(PRA_NOM, ' ',PRA_PRENOM) as nom_Prat from PRATICIEN";
        $req = $cnx->prepare($sql);
        $req->execute();
        $resultat = $req->fetchAll(PDO::FETCH_ASSOC); 
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
    return $resultat;
}

function EnregistrerRapport(){
    try{
        $cnx = connexionPDO();
        $sql="select PRA_NUM, CONCAT(PRA_NOM, ' ',PRA_PRENOM) as nom_Prat from PRATICIEN";
        $req = $cnx->prepare($sql);
        $req->execute();
    } catch (Exception $ex) {

    }
}

function updateTest($date){
    try {
        $cnx = connexionPDO();
        $sql="update RAPPORT_VISITE set RAP_DATE=:date";
        $req = $cnx->prepare($sql);
        $req->bindValue(":date",$date,PDO::PARAM_STR);
        $req->execute($sql);
    } catch (PDOException $e) {
        print "Erreur !: " . $e->getMessage();
        die();
    }
}

function getCoefPraticienById($idPraticien){
    $resultat = array();
    try{
        $cnx=connexionPDO();
        $sql="select PRA_COEFNOTORIETE from PRATICIEN where PRA_NUM=:idPraticien";
        $req = $cnx->prepare($sql);
        $req->bindValue(":idPraticien",$idPraticien, PDO::PARAM_INT);
        $req->execute();
        $resultat = $req->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $ex) {
        print "Erreur !: " . $ex->getMessage();
        die();
    }
    return $resultat;
}

function ajouterRapportVisite($pVisMatricule,$pPraNum,$pRapBilan,$RapMotif,$pRapDate,$pDoc,$pRapFermer){
    try{
        $cnx=connexionPDO();
        $sql="insert into RAPPORT_VISITE (VIS_MATRICULE,PRA_NUM, RAP_BILAN,".
                "RAP_MOTIF,RAP_DATE_VISITE,RAP_DOCUMENTATION,RAP_FERMER) ".
                "values (:pVisMatricule,:pPraNum,".
                ":pRapBilan,:RapMotif,:pRapDate,:pDoc,:pRapFermer)";
        
        $req = $cnx->prepare($sql);
        $req->bindValue(":pVisMatricule",$pVisMatricule, PDO::PARAM_STR);
        $req->bindValue(':pPraNum', $pPraNum, PDO::PARAM_INT);
        $req->bindValue(':pRapBilan', $pRapBilan, PDO::PARAM_STR);
        $req->bindValue(':RapMotif', $RapMotif, PDO::PARAM_STR);
        $req->bindValue(':pRapDate', $pRapDate, PDO::PARAM_STR);
        $req->bindValue(':pDoc', $pDoc, PDO::PARAM_INT);
        $req->bindValue(':pRapFermer', $pRapFermer, PDO::PARAM_INT);
        $req->execute();
    } catch (Exception $ex) {
        print "Erreur !: " . $ex->getMessage();
        die();
    }
}

function GetDernierRapportVisite($pVisMatricule){
    $resultat=Array();
    try{
        $cnx= connexionPDO();
        $sql="SELECT RAP_NUM FROM RAPPORT_VISITE where VIS_MATRICULE=:pVisMatricule ORDER BY RAP_NUM DESC LIMIT 1 ";
        $req = $cnx->prepare($sql);
        $req->bindValue(":pVisMatricule",$pVisMatricule, PDO::PARAM_STR);
        $req->execute();
        $resultat = $req->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $ex) {
        print "Erreur !: " . $ex->getMessage();
        die();  
    }
    return $resultat;
}

function ajouterMedicPresenter($pVisMatricule,$RAP_NUM,$MED_DEPOTLEGAL){
    try{
        $cnx=connexionPDO();
        $sql="insert into PRESENTER (VIS_MATRICULE, RAP_NUM, MED_DEPOTLEGAL)".
                "values(:pVisMatricule,:pRAP_NUM,:pMED_DEPOTLEGAL)";
        $req = $cnx->prepare($sql);
        $req->bindValue(":pVisMatricule",$pVisMatricule, PDO::PARAM_STR);
        $req->bindValue(':pRAP_NUM', $RAP_NUM, PDO::PARAM_STR);
        $req->bindValue(':pMED_DEPOTLEGAL', $MED_DEPOTLEGAL, PDO::PARAM_STR);
        $req->execute();
    } catch (Exception $ex) {
        print "Erreur !: " . $ex->getMessage();
        die();
    }
}

function ajouterEchantOffer($pVisMatricule,$RAP_NUM,$MED_DEPOTLEGAL,$OFF_QTE){
    try{
        $cnx=connexionPDO();
        $sql="insert into OFFRIR (VIS_MATRICULE, RAP_NUM, MED_DEPOTLEGAL, OFF_QTE)".
                "values(:pVisMatricule,:pRAP_NUM,:pMED_DEPOTLEGAL,:pOFF_QTE)";
        $req = $cnx->prepare($sql);
        $req->bindValue(":pVisMatricule",$pVisMatricule, PDO::PARAM_STR);
        $req->bindValue(':pRAP_NUM', $RAP_NUM, PDO::PARAM_STR);
        $req->bindValue(':pMED_DEPOTLEGAL', $MED_DEPOTLEGAL, PDO::PARAM_STR);
        $req->bindValue(':pOFF_QTE', $OFF_QTE, PDO::PARAM_STR);
        $req->execute();
    } catch (Exception $ex) {
        print "Erreur !: " . $ex->getMessage();
        die();
    }
}



function AjouterQuestion($pLibelle){
    try{
        $cnx=connexionPDO();
        $sql="insert into question (libelle) values (:pLibelle)";
        $req = $cnx->prepare($sql);
        $req->bindValue(":pLibelle",$pLibelle, PDO::PARAM_STR);
        $req->execute();
    } catch (Exception $ex) {
        print "Erreur !: " . $ex->getMessage();
        die();
    }
}

function AjouterPoser($reponse,$idRapportVisite,$idQuestion,$idVismatricule){
    try{
        $cnx=connexionPDO();
        $sql="insert into poser (reponse,idRapportVisite,idQuestion,idVisMatricule) "
                . "values (:pLibelle,:idRapportVisite,:idQuestion,:idVismatricule)";
        $req = $cnx->prepare($sql);
        $req->bindValue(":reponse",$reponse, PDO::PARAM_STR);
        $req->bindValue(":idRapportVisite",$idRapportVisite, PDO::PARAM_INT);
        $req->bindValue(":idQuestion",$idQuestion, PDO::PARAM_INT);
        $req->bindValue(":idVismatricule",$idVismatricule, PDO::PARAM_STR);
    } catch (Exception $ex) {
        print "Erreur !: " . $ex->getMessage();
        die();
    }
}


function GetDernierQuestion($question){
    $resultat=Array();
    try{
        $cnx= connexionPDO();
        $sql="select `idQuestion` from question where libelle=:question order by idQuestion desc limit 1";
        $req = $cnx->prepare($sql);
        $req->bindValue(":question",$question, PDO::PARAM_STR);
        $req->execute();
        $resultat = $req->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $ex) {
        print "Erreur !: " . $ex->getMessage();
        die();  
    }
    return $resultat;
}
    