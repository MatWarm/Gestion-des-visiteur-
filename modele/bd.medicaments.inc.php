<?php
/*
 * Description de bd.medicaments.inc.php
 * Propose les fonctions et méthode de la table medicament
 * auteur Mattéo, Sylvain, Valentin
 * Creation 01/2021
 * Derniere MAJ 27/04/2021
*/

include_once "bd.inc.php";

// Fonction permettant de récupérer tous les médicaments
function getMedicaments(){
    $resultat = array();
    
    try{
        $cnx = connexionPDO();

        $sql="SELECT * FROM MEDICAMENT";

        $req = $cnx->prepare($sql);

        $req->execute();
        
        // Récupération de l'enregistrement
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) {
            $resultat[] = $ligne;
            $ligne = $req->fetch(PDO::FETCH_ASSOC);
        }
        
    } catch (Exception $ex) {
        print('Erreur de connexion pdo');
        die();
    }
    
    return $resultat;
}

// Fonction permettant de récupérer tous les médicaments
function getMedicamentsById($idMedicament){
    $resultat = array();
    
    try{
        $cnx = connexionPDO();

        $sql="SELECT * FROM MEDICAMENT WHERE MED_DEPOTLEGAL =:idMedicament";

        $req = $cnx->prepare($sql);
        
        $req->bindValue(':idMedicament', $idMedicament, PDO::PARAM_STR);

        $req->execute();
        
        // Récupération de l'enregistrement
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) {
            $resultat[] = $ligne;
            $ligne = $req->fetch(PDO::FETCH_ASSOC);
        }
        
    } catch (Exception $ex) {
        print('Erreur de connexion pdo');
        die();
    }
    
    return $resultat;
}

// Fonction permettant de récupérer tous les médicaments perturbés
function getMedicamentsPerturbes($idMedicament){
    $resultat = array();
    
    try{
        $cnx = connexionPDO();

        $sql="SELECT MED_MED_PERTURBE from INTERAGIR join MEDICAMENT on MED_PERTURBATEUR = MED_DEPOTLEGAL where MED_DEPOTLEGAL = :idMedicament";

        $req = $cnx->prepare($sql);
        
        $req->bindValue(':idMedicament', $idMedicament, PDO::PARAM_STR);

        $req->execute();
        
        // Récupération de l'enregistrement
        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) {
            $resultat[] = $ligne;
            $ligne = $req->fetch(PDO::FETCH_ASSOC);
        }
        
    } catch (Exception $ex) {
        print('Erreur de connexion pdo');
        die();
    }
    
    return $resultat;
}

?>