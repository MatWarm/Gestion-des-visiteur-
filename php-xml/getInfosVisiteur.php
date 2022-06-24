<?php
include_once "../getRacine.php";
include_once "$racine/modele/bd.visiteur.inc.php";
header("Cache-Control: no-cache, must-revalidate"); 
header('Content-Type: text/xml; charset=UTF-8'); 
echo '<?xml version="1.0" encoding="UTF-8"?>'; 
// construit un flux xml basé sur les etudiants d'une classe obtenue par post
$leVisiteur=getVisiteurbyId($_POST['leVisiteur'])[0];
echo '<visiteur>';
    echo '<NomVis>'.$leVisiteur["VIS_NOM"].'</NomVis>';
    echo '<PreVis>'.$leVisiteur["VIS_PRENOM"].'</PreVis>';
    echo '<AdrVis>'.$leVisiteur["VIS_ADRESSE"].'</AdrVis>';
    echo '<CP-Vis>'.$leVisiteur["VIS_CP"].'</CP-Vis>';
    echo '<VilleVis>'.$leVisiteur["VIS_VILLE"].'</VilleVis>';
    echo '<SecVis>'.$leVisiteur["SECTEUR"].'</SecVis>';
echo '</visiteur>'; 
?>