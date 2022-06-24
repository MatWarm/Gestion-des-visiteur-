<?php
    require_once("$racine/modele/bd.visiteur.inc.php");
    /* Manque ce fichier :
    *require_once("$racine/modele/bd.departement.inc.php");
    */
    
    $visVous = getVisiteurbyId($_SESSION["idVIS"])[0];
?>

<div class="corps-application">

    <div class="entete-corps">

        <h1>Visiteur</h1>
        <span class="separateur separateur-noir"></span>

    </div>

    <form action="visiteurs" method="post">
        <div class="ligne-form" id="ligne-form">
            <?php
                echo getListeDepartement(). "<br/>";
                
                echo getListeVisiteurs(1);
            ?><br/>
        </div>
        <div class="ligne-form">
            <label>NOM :</label>
            <input 
                id="NomVis"
                type="text"  name="VIS_NOM"
                placeholder="Nom" required
                value="<?php echo $visVous["VIS_NOM"]; ?>"
                onchange=""/><br/>
        </div>
        <div class="ligne-form">
            <label>PRENOM :</label>
            <input 
                id="PreVis"
                type="text"  name="Vis_PRENOM" 
                placeholder="Prénom" required
                value="<?php echo $visVous["VIS_PRENOM"]; ?>"
                onchange=""/><br/>
        </div>
        <div class="ligne-form">
            <label>ADRESSE :</label>
            <input
                id="AdrVis"
                type="text"  name="VIS_ADRESSE" 
                placeholder="Adresse" required
                value="<?php echo $visVous["VIS_ADRESSE"]; ?>"
                onchange=""/><br/>
        </div>
        <div class="ligne-form">
            <label>CODE POSTAL :</label>
            <input 
                id="CP-Vis"
                type="text" name="VIS_CP" 
                placeholder="Code postal" required
                value="<?php echo $visVous["VIS_CP"]; ?>"
                onchange=""/><br/>
        </div>
        <div class="ligne-form">
            <label>VILLE :</label>
            <input
                id="VilleVis"
                type="text" name="VIS_VILLE" 
                placeholder="Ville" required
                value="<?php echo $visVous["VIS_VILLE"]; ?>"
                onchange=""/><br/>
        </div>
        <div class="ligne-form">
            <label>SECTEUR :</label>
            <input 
                id="SecVis"
                type="text"  name="SEC_CODE" 
                placeholder="Secteur" required
                value="<?php echo $visVous["SECTEUR"]; ?>"
                onchange=""/><br/>
        </div>
        <div class="ligne-form ligne-form-bouton">
            <input type="hidden" id="currentVis" value="<?php echo $_SESSION["idVIS"]; ?>"></input>
            <input type="button" value="<"
                   onclick=""></input>
            <input type="button" value=">"
                   onclick=""></input>
        </div>
    </form>
</div>
</div>