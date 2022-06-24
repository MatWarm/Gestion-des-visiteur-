<?php
/*
 * Description de bd.inc.php
 * fonction de connexion à la base de données
 * auteur sylvain
 * Creation 30/03/2021
 * Derniere MAJ 30/03/2021
*/

function premiere_connexion($id){
    $rech = False;
    
    try{
        $cnx = connexionPDO();

        $sql="SELECT EXTRACT(YEAR FROM VIS_DATEEMBAUCHE) as YEAR, EXTRACT(MONTH FROM VIS_DATEEMBAUCHE), MDP_COMPTE as MONTH FROM VISITEUR "
                . "where IDENTIFIANT_COMPTE = :identifiant";

        $req = $cnx->prepare($sql);

        $req->bindValue(':identifiant', $id, PDO::PARAM_STR); 

        $req->execute(); //test la requète

        $ligne = $req->fetch(PDO::FETCH_ASSOC);
        while ($ligne) {
            $resultat[] = $ligne;
            // recupère l enregistrement suivant
            $ligne = $req->fetch(PDO::FETCH_ASSOC);
        }
        
        if($ligne['YEAR'] . $ligne['MONTH'] === $ligne['MDP_COMPTE']){
            $exist = True;
        }
    }catch(PDOException $e){
        print('Erreur de connexion pdo');
        die();
    }
    
    return $rech;
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
        if($cb_correspondance['count(*)'] > 0){
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

        $req->bindValue(':mdp', $id, PDO::PARAM_STR); 

        $req->execute(); //test la requète
        
        $cb_correspondance = $req->fetch(PDO::FETCH_ASSOC);
        if($cb_correspondance['count(*)'] > 0){
            $exist = True;
        }
    } catch (Exception $ex) {
        print('Erreur de connexion pdo');
        die();
    }
    
    return $exist;
} 

function mdp_est_valid(string $mdp){
    $valide = False;
    
    //  composition d'un mot de passe:
    //  
    //  1+ maj; 1+ min; 1+ caractère spécial; 12 caractères min; 1+ chiffre
    
    return preg_match("/^((?=.*?[a-z])"
            . "(?=.*?[A-Z])"
            . "(?=.*?[0-9])"
            . "(?=.*?[!#\$%&'\(\)\*\+,-\.\/:;<=>\?@[\]\^_`\{\|}~]))"
            . "[a-zA-Z0-9!#\$%&'\(\)\*\+,-\.\/:;<=>\?@[\]\^_`\{\|}~]{12,20}$/"
            , $mdp);
}

function test_injection(string $atester){
    
    // Si on détecte la présence d'un quote simple, alors on retourne Vrai,
    // Sinon on retourne faux
    
    return preg_match("/^[']|[']$/",$atester);
}

function identifiant_est_valid(string $identifiant){
    return preg_match("/^[a-zA-Z-0-9]$/",$identifiant);
}
?>      