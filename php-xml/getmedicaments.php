<?php
include_once "../getRacine.php";
include_once "$racine/modele/bd.inc.php";
include_once "$racine/modele/bd.medicaments.inc.php";
header("Cache-Control: no-cache, must-revalidate"); 
header('Content-Type: text/xml; charset=UTF-8'); 
echo '<?xml version="1.0" encoding="UTF-8"?>'; 

// Contruction d'un flux XML basé sur les médicaments obtenue par post
$lesmedicaments=getMedicamentsById($_POST["medicament"]) ;

$lesMedicamentsPertubes = getMedicamentsPerturbes($_POST["medicament"]);

echo '<listemedicament>'; 
 // parcours des médicaments et construction des noeuds du XML
for ($i = 0; $i < count($lesmedicaments); $i++) { 
    echo '<medicament>';
    echo '<med_depotlegal>'.$lesmedicaments[$i]["MED_DEPOTLEGAL"].'</med_depotlegal>'; 
    echo '<med_nomcommercial>'.$lesmedicaments[$i]["MED_NOMCOMMERCIAL"].'</med_nomcommercial>'; 
    echo '<fam_code>'.$lesmedicaments[$i]["FAM_CODE"].'</fam_code>';
    echo '<med_composition>'.$lesmedicaments[$i]["MED_COMPOSITION"].'</med_composition>';
    echo '<med_effet>'.$lesmedicaments[$i]["MED_EFFETS"].'</med_effet>';
    echo '<med_contreindic>'.$lesmedicaments[$i]["MED_CONTREINDIC"].'</med_contreindic>';
    echo '<med_prixechantillon>'.$lesmedicaments[$i]["MED_PRIXECHANTILLON"].'</med_prixechantillon>';


    echo '<interactions>'; 
    // Créer une boucle pour les médicaments pertubateurs 
    for ($i=0; $i < count($lesMedicamentsPertubes); $i++) {
        echo '<med_perturbe>'.$lesMedicamentsPertubes[$i]["MED_MED_PERTURBE"].'</med_perturbe>';
    }
    echo '</interactions>'; 
    

    echo '</medicament>'; 
}

echo '</listemedicament>'; 
?>
