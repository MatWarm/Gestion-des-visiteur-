<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if ( $_SERVER["SCRIPT_FILENAME"] == __FILE__ ){
    $racine="..";
}

require_once "$racine/modele/authentification.inc.php";
require_once "$racine/modele/bd.inc.php";
require_once "$racine/modele/bd.rapportVisit.inc.php";
require_once "$racine/modele/bd.medicaments.inc.php";
// recuperation des donnees GET, POST, et SESSION

if (!isset($_SESSION)) {
    session_start();
}
/**
 * Récuperation des médicaments
 * <code>
 * $listeProduits= getMedicaments("3MYC7");
 * </code>
 * Récuperation des praticiens 
 * <code>
 * $listerPraticien= listerPraticien();
 * </code>
 * Récuperation de la date d'aujourd'hui
 * <code>
 * $dateActuel=date("Y-m-d");
 * </code>
 */
$listeProduits= getMedicaments();
$listerPraticien= listerPraticien();
$dateActuel=date("Y-m-d");

/**
 * Permet d'avoir le praticien numero 1 de séléctionné au moment
 * du chargement de la page
 * <code>
 * $lePraticien=getCoefPraticienById(1);
 * </code>
 */
$lePraticien=getCoefPraticienById(1);


/**
 * Déclaration des variables nécessaires au traitement des données
 * <code>
 * $dateVisite="";
 * $motifAutre=False;
 * $motifAutreStr="";
 * $motif="";
 * $bilan="";
 * $doc=0;
 * $lock=0;
 * $existe=0;
 * </code>
 */
$dateVisite="";
$motifAutreBool=False;
$motifAutreStr="";
$motif="";
$bilan="";
$doc=0;
$lock=0;
$existe=0;
$j=1;
$vide=false;
$premierPassageEch=true;
$h=1;
$premierPassageProd= true;


/**
 * Verification des saisies d'un rapport visite
 * 
 */
if(isset($_POST["DATE_VISITE"]) && isset($_POST["PRA_COEFF"]) && isset($_POST["RAP_BILAN"]) 
        && isset($_POST["listePraticiens"]) && isset($_POST["RAP_MOTIF"]) && isset($_POST["PROD1"]) 
        && isset($_POST["PROD2"])){

    if($_POST["DATE_VISITE"] === "")
    {
        $msgErreur="Aucune date de visite saisie.";
    }
    else
    {
        /**
         * Lavage de la valeur du post(DATE_VISITE) en string
         * <code>
         * $dateVisite=filter_input(INPUT_POST, 'DATE_VISITE', FILTER_SANITIZE_STRING);
         * </code>
         */
        $dateVisite=filter_input(INPUT_POST, 'DATE_VISITE', FILTER_SANITIZE_STRING);
        
        if($_POST["PRA_COEFF"] ==="")
        {
            $msgErreur="Aucun coefficient saisie.";
        }
        else
        {
            
            //Verification du motif de rapport choisis
            if($_POST["RAP_MOTIF"] === "AUT" )
            {
                $motifAutreBool=true;
                if($_POST["RAP_MOTIFAUTRE"]=== ""){
                    $msgErreur="Le motif autre n'est pas saisie.";
                }   
            }
            else
            {
               /**
                * Lavage de la valeur du post(RAP_MOTIF) en string
                * <code>
                * $motif=filter_input(INPUT_POST,'RAP_MOTIF', FILTER_SANITIZE_STRING);
                * </code>
                */
               $motif=filter_input(INPUT_POST,'RAP_MOTIF', FILTER_SANITIZE_STRING);
            }   
            
            if($_POST["RAP_BILAN"]==="")
            {
                $msgErreur="Aucun bilan saisie.";
            }
            else
            {
                /**
                * Lavage de la valeur du post(RAP_BILAN) en string
                * <code>
                * $bilan=filter_input(INPUT_POST, 'RAP_BILAN', FILTER_SANITIZE_STRING);
                * </code>
                */
                $bilan=filter_input(INPUT_POST, 'RAP_BILAN', FILTER_SANITIZE_STRING);
                if($_POST["PRA_COEFF"]==="")
                {
                    $msgErreur="Le coefficient n'est pas saisie";
                }
                else
                {
                    if(!is_numeric($_POST["PRA_COEFF"]))
                    {
                        $msgErreur="Le coefficient n'est pas un chiffre";
                    }
                    else
                    {
                        //Verification de valeurs sur les checkbox RAP_LOCK et RAP_DOC
                        if(isset($_POST["RAP_DOC"]) && $_POST["RAP_DOC"])
                            $doc=1;
                        
                        if(isset($_POST["RAP_LOCK"]) && $_POST["RAP_LOCK"])
                            $lock=1;
                        
                        
                        //Envoie de la requete d'insertion sql a la bdd
                        //si un autre motif est choisis on change la variable a envoyer
                        if($motifAutreBool){
                            //si un autre motif est choisis on prends la saisie du motif
                            ajouterRapportVisite($_SESSION["idVIS"],$_POST["listePraticiens"],$bilan,$_POST["RAP_MOTIFAUTRE"],$dateVisite,$doc,$lock);
                            var_dump("Ajout RV motif autre");
                        }else{
                            //sinon on prend la valeur choisis dans la liste déroulante des motifs
                            ajouterRapportVisite($_SESSION["idVIS"],$_POST["listePraticiens"],$bilan,$motif,$dateVisite,$doc,$lock);
                            var_dump("Ajout RV motif");
                        }
                        
                        
                        //récuperation du dernier rapport visite en fonction du visiteur connecté
                        $numRAP=GetDernierRapportVisite($_SESSION["idVIS"]);
                        var_dump($numRAP["RAP_NUM"]);
                        //boucle d'ajout des produits présenté dans la bdd
                        
                        while(!$existe && isset($_POST["PROD".$h])){
                            if($premierPassageProd)
                            {
                                $premierPassageProd=false;
                                ajouterMedicPresenter($_SESSION["idVIS"],$numRAP["RAP_NUM"],$_POST["PROD".$h]);
                                var_dump("ajout de ".$_POST["PROD".$h]." au rapport n°".$numRAP["RAP_NUM"]." au visiteur :".$_SESSION["idVIS"]);
                                $h++;
                            }
                            else
                            {
                                if($_POST["PROD".$h-1] === $_POST["PROD".$h])
                                {
                                    $msgErreur="Ajout des produit intérrompue, les deux même produits ont été saisie";
                                    $existe=true;
                                }
                                else
                                {
                                    ajouterMedicPresenter($_SESSION["idVIS"],$numRAP["RAP_NUM"],$_POST["PROD".$h]);
                                    var_dump("ajout de ".$_POST["PROD".$h]." au rapport n°".$numRAP["RAP_NUM"]." au visiteur :".$_SESSION["idVIS"]);
                                    $h++;
                                }
                            }     
                        }
                        
                        var_dump($_POST["Question1"]);
                        if(isset($_POST["Question1"]) && isset($_POST["reponse1"]) ){
                            var_dump($_POST["Question1"]);
                            AjouterQuestion($_POST["Question1"]);
                            $DerniereQuestion=GetDernierQuestion($_POST["Question1"]);
                            var_dump($DerniereQuestion);
                            var_dump($_POST["reponse1"]);
                            var_dump($numRAP["RAP_NUM"]);
                            var_dump($_SESSION["idVIS"]);
                            AjouterPoser($_POST["reponse1"],$numRAP["RAP_NUM"],$DerniereQuestion,$_SESSION["idVIS"]);
                        }
                            
                        if(isset($_POST["RAP_ECHANTILLION"]))
                        {
                            //boucle d'ajout des échantillons dans la bdd
                            while(!$vide && (isset($_POST["PRA_ECH".$j]) && isset($_POST["PRA_QTE".$j])))
                            {
                                if($premierPassageEch)
                                {
                                    $premierPassageEch=false;
                                    ajouterEchantOffer($_SESSION["idVIS"],$numRAP["RAP_NUM"],$_POST["PRA_ECH".$j],$_POST["PRA_QTE".$j]);
                                    var_dump(" ajout de l'echan : ".$_POST["PRA_ECH".$j]." qtn :".$_POST["PRA_QTE".$j]." rapNum :".$numRAP["RAP_NUM"]." vis :".$_SESSION["idVIS"]);
                                    $j++;
                                }
                                else
                                {
                                    if($_POST["PRA_QTE".$j] ==="" )
                                    {
                                        $msgErreur="la quantité de l'échantillion n°".$j." n'est pas saisie";
                                        $vide=true;
                                    }
                                    else
                                    {
                                        if(!is_numeric($_POST["PRA_QTE".$j]))
                                        {
                                            $msgErreur="la quantité de l'échantillion n°".$j
                                                ." ne peux pas etre constitué uniquement de chiffres.";
                                            $vide=true;
                                        }
                                        else
                                        {
                                            if($_POST["PRA_QTE".$j] <= 0)
                                            {
                                                $msgErreur="la quantité de l'échantillion n°".$j
                                                ." ne peux pas etre une valeur négative ou 0.";
                                            $vide=true;
                                            }
                                            else
                                            {
                                                if(($_POST["PRA_ECH".$j-1] === $_POST["PRA_ECH".$j]) && ($_POST["PRA_QTE".$j-1] && $_POST["PRA_QTE".$j])){
                                                    $vide=true;
                                                    $msgErreur="Les échantillions n°".$_POST["PRA_ECH".$j]." et ".$_POST["PRA_ECH".$j-1]."sont identique en quantité";
                                                }
                                                else
                                                {
                                                    ajouterEchantOffer($_SESSION["idVIS"],$numRAP["RAP_NUM"],$_POST["PRA_ECH".$j],$_POST["PRA_QTE".$j]); 
                                                    var_dump(" ajout de l'echan : ".$_POST["PRA_ECH".$j]." qtn :".$_POST["PRA_QTE".$j]." rapNum :".$numRAP["RAP_NUM"]." vis :".$_SESSION["idVIS"]);
                                                    $j++;
                                                }
                                                
                                            }
                                        }
                                    }
                                }
                            }
                            
                            
                            $j--;
                            if(!$vide && !$existe)
                            {
                                
                                $msgPositif="Rapport visite enregistré, avec présentation de produit, ".$j." échantillons offert. "; 
                            }
                            else{
                                if(!$existe){
                                    $msgPositif="Rapport visite enregistré avec présentation de produit.";
                                }
                                else
                                {
                                    if(!$vide && $existe)
                                    {
                                        $msgPositif="Rapport visite enregistré sans présentation de produit, ".$j." échantillons offert.";
                                    }
                                    else
                                    {
                                        $msgPositif="Rapport visite enregistré sans présentation de produit et sans échantillons offert.";
                                    }
                                }
                            }
                        }
                        else
                        {
                            if(!$existe){
                                $msgPositif="Rapport visite enregistré avec présentation de produit.";
                            }
                            else{
                                $msgPositif="Rapport visite enregistré sans présentation de produit et sans échantillons offert.";
                            }
                            
                        }
                    }
                }
            }
        }
    }
}
else
{
    $msgInformatif="Aucune saisie"; 
}


if (isLoggedOn())
{
    $titre = "GSB - Rapport Visite";
    include "$racine/vue/entete.php";
    include "$racine/vue/header.php";
    include "$racine/vue/vueRapportVisite.php";
    include "$racine/vue/pied.php";
}
else
{
    $titre = "GSB - Connexion";
    include "$racine/vue/entete.php";
    include "$racine/vue/vueConnexion.php";
}