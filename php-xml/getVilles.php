<?php
include_once "../getRacine.php";
include_once "$racine/modele/bd.inc.php";
header("Cache-Control: no-cache, must-revalidate"); 
header('Content-Type: text/xml; charset=UTF-8'); 
echo '<?xml version="1.0" encoding="UTF-8"?>'; 

// Contruction d'un flux XML basé sur les médicaments obtenue par post
$lesVilles = getVilleFromDepartement($_POST["leDepartement"]) ;

echo '<lesVilles>'; 
 // parcours des etudiants et construction des noeuds du XML
for ($i = 0; $i < count($lesVilles); $i++) { 
    echo '<ville>';
    echo '<nom>' . $lesVilles[$i]["VIS_VILLE"] . '</nom>';
    echo '</ville>'; 
}
echo '</lesVilles>'; 
?>