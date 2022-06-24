    <div class="corps-application"> 

    <div class="entete-corps">

        <h1>Rapport Visite</h1>
        <span class="separateur separateur-noir"></span>

    </div>

        <?php if(isset($msgErreur)){ ?>
            <div class="message message-erreur">
                <i class="fas fa-exclamation-triangle"></i>
                <p class="message-p"><?php echo $msgErreur ?></p>
            </div>
        <?php } ?>
        
        <?php if(isset($msgPositif)){ ?>
            <div class="message message-positif">
                <i class="fas fa-check-circle"></i>
                <p class="message-p"><?php echo $msgPositif ?></p>
            </div>
        <?php }
        
        if(isset($msgInformatif)) { ?>
            <div class="message message-informatif">
                <i class="fas fa-info-circle"></i>
                <p class="message-p"> <?php echo $msgInformatif ?> </p>
            </div>
        <?php }

        require_once "$racine/modele/authentification.inc.php";
        if( premiere_connexion($_SESSION['idVIS']) ){ 
        ?>
            <div class="message message-erreur">
                <i class="fas fa-exclamation-triangle"></i>
                <p class="message-p">
                    <?php echo "Première connexion"
                          . ", veuillez changer de mot de passe" 
                    ?>
                </p>
            </div>
        <?php 
        } 
        ?>
        
        <form 
            name="formRAPPORT_VISITE" method="post" 
            action="./?action=rapportVisite">
            <div class="ligne-form">
               
                
                <label>DATE VISITE :</label>
                <input type="date" id="start" name="DATE_VISITE"
                       <?php echo "value='".$dateActuel."'"; ?>
                       <?php echo "max='".$dateActuel."'"; ?>>
                
            </div>
            
            <div class="ligne-form">
                <label >PRATICIEN :</label>
                <select  name="listePraticiens" id="listePraticiens" onchange="javascript:envoyerCoeffPraticien(this.value)">
                    <?php
                        for($i=0; $i < count($listerPraticien); $i++)
                        {
                            echo "<option value='".$listerPraticien[$i]["PRA_NUM"]."'>".$listerPraticien[$i]['nom_Prat']."</option>";
                        }
                    ?>
                </select>
            </div>
            <div class="ligne-form">
                <label >COEFFICIENT :</label>
                <input 
                    type="text" name="PRA_COEFF" 
                    placeholder="Coefficient" 
                    
                    <?php echo "value='".$lePraticien["PRA_COEFNOTORIETE"]."'"; ?>>
            </div>
            
            <div class="ligne-form">
                <label >MOTIF :</label>
                <select name="RAP_MOTIF" onclick="selectionne('AUT', this.value, 'RAP_MOTIFAUTRE')" >
                    <option value="PRD">Périodicité</option>
                    <option value="ACT">Actualisation</option>
                    <option value="REL">Relance</option>
                    <option value="SOL">Sollicitation praticien</option>
                    <option value="AUT">Autre</option>
                </select>
                
                <input 
                    type="text" name="RAP_MOTIFAUTRE" 
                    disabled="disabled" style="width: 35.4%;" 
                    placeholder="Autre motif" />
            </div>
            <div class="ligne-form">
                <label>BILAN :</label>
                <textarea 
                    name="RAP_BILAN" 
                    placeholder="Bilan" 
                    value="test"></textarea>
            </div>
            
            <span class="separateur separateur-noir"></span>
            
            <div class="ligne-form">
                <h3>Éléments présentés</h3><br/>
                <label  >PRODUIT 1 : </label>
                <select name="PROD1" id="listeProduits">
                    <?php
                        for($i=0;$i<count($listeProduits);$i++)
                        {
                            echo "<option value='".$listeProduits[$i]["MED_DEPOTLEGAL"]."'>".$listeProduits[$i]["MED_NOMCOMMERCIAL"]."</option>";
                        }
                        ?>
                </select>
            </div>
            <div class="ligne-form">
                <label  >PRODUIT 2 : </label>
                <select name="PROD2" >
                    <?php
                        for($i=0;$i<count($listeProduits);$i++)
                        {
                            echo "<option value='".$listeProduits[$i]["MED_DEPOTLEGAL"]."'>".$listeProduits[$i]["MED_NOMCOMMERCIAL"]."</option>";
                        }
                        ?>
                </select>
            </div>
            
            <div class="ligne-form">
                <label >DOCUMENTATION OFFERTE :</label>
                <input name="RAP_DOC" type="checkbox" value="true"/>
            </div>
            
            <span class="separateur separateur-noir"></span>
            
            <div class="ligne-form">
                <h3>Échantillon</h3><br/>
                
                <label >ECHANTILLON OFFERT :</label>
                <input type="checkbox" name="RAP_ECHANTILLION"  value="false" onclick="echantillionOffert(this.value)">
                    
                <div  id="lignes">
                    <div class="ligne-form-ech">
                        <label  >PRODUIT : </label>
                        <select name=PRA_ECH1 >

                        <?php
                        //ajoute la liste de produit
                        for($i=0;$i<count($listeProduits);$i++)
                        {
                            echo "<option value='".$listeProduits[$i]["MED_DEPOTLEGAL"]."'>".$listeProduits[$i]["MED_NOMCOMMERCIAL"]."</option>";
                        }
                        ?>
                        </select>
                        <input
                            type="text" name="PRA_QTE1" 
                            placeholder="Quantité" />
                        <input
                            type="button" id="but1" value="+" 
                            onclick="ajoutLigne(1);"  />
                    </div>
                    
                </div>
            </div>
            <span class="separateur separateur-noir"></span>
            <div class="ligne-form">
                <label >SAISIE DEFINITIVE :</label>
                <input name="RAP_LOCK" type="checkbox">
            </div>
            
            
<!--            <div  id="lignes">
                <div class="ligne-form-ech">
                    <label>Question :</label>
                    <input type="text" name="Question1" placeholder="Question" >
                    <input type="button" id="button1" value="+" onclick="ajoutLigneQuestion(1);"  />
                </div>
            </div>-->
               <div  id="lignes">
<!--                   <div class="ligne-form-ech">-->
                       <label>Question :</label>
                       <input type="text" name="Question1" placeholder="Question" >
                       <input type="text" name="reponse1" placeholder="reponse" >
<!--                </div>-->
            </div>
            
                
            <div class="ligne-form ligne-form-bouton">
                <input type="submit" id="boutonEnvoyer" value="Envoyer"></input>
                <input type="reset" id="boutonAnnuler" value="Annuler"></input>
            </div>
        </form>
    </div>
</div>
</div>
