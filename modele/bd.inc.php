<?php
/*
 * Description de bd.inc.php
 * fonction de connexion à la base de données
 * Auteurs Valentin, Sylvain, Mattéo, Guillaume
 * Creation 01/2021
 * Derniere MAJ 27/09/2021
*/


function connexionPDO() {
    $login = "20ap2g02";
    $mdp = "spRing4)";
    $bd = "20ap2g02"; //base de donnée
    $serveur = "localhost";

    try {
        $conn = new PDO("mysql:host=$serveur;dbname=$bd", $login, $mdp,array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\'')); 
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        print "Erreur de connexion PDO ";
        die();
    }
}

?>
