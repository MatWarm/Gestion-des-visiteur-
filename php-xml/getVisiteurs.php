<?php
include_once "../getRacine.php";
include_once "$racine/modele/bd.visiteur.inc.php";
header("Cache-Control: no-cache, must-revalidate"); 
header('Content-Type: text/xml; charset=UTF-8'); 
echo '<?xml version="1.0" encoding="UTF-8"?>'; 

// Contruction d'un flux XML basé sur les médicaments obtenue par post
$lesVisiteurs = getVisiteursbyDepartement($_POST["leDepartement"]);

echo '<lesVisiteurs>'; 
 // parcours des etudiants et construction des noeuds du XML
for ($i = 0; $i < count($lesVisiteurs); $i++) { 
    echo '<visiteur>';
    echo '<id>'.$lesVisiteurs[$i]["IDENTIFIANT_COMPTE"].'</id>';
    echo '<nom>'.$lesVisiteurs[$i]["VIS_NOM"].'</nom>';
    echo '</visiteur>'; 
}
echo '</lesVisiteurs>'; 
?>