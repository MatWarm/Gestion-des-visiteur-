<?php
include_once "../getRacine.php";
include_once "$racine/modele/bd.rapportVisit.inc.php";

header("Cache-Control: no-cache, must-revalidate"); 
header('Content-Type: text/xml; charset=UTF-8'); 
echo '<?xml version="1.0" encoding="UTF-8"?>'; 


//récuperation du coefPraticien en fonction de l'id récuperer en post
$lePraticien=getCoefPraticienById($_POST["idPraticien"]);

echo '<praticien>';
    echo '<coefficient>'.$lePraticien["PRA_COEFNOTORIETE"].'</coefficient>';
echo '</praticien>';
?>