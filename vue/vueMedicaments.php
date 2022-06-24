        <div class="corps-application">

            <div class="entete-corps">
                <!-- Titre -->
                <h1>Pharmacopée</h1>

                <!-- Barre horizontale -->
                <span class="separateur separateur-noir"></span>
            </div>


            <!-- Instructions -->
            <?php if(isset($msgErreur)){ ?>
                <div class="message message-erreur">
                    <i class="fas fa-exclamation-triangle"></i>
                    <p class="message-p"><?php echo $msgErreur ?></p>
                </div>
            <?php } ?>
            
            <?php 
            
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
            
            <!-- Formulaire --> 
            <form class="formMedic" id="formulaire" name="formMEDICAMENT" method="post" action="#">
                
                <div class="ligne-form">
                    <label >MEDICAMENT :</label>
                    
                    <select name="listeMedicaments" id="listeMedicaments" onchange="javascript:envoyerRequeteMedicament(this.value)">
                        <?php
                       
                            for($i=0; $i < count($listeMedicaments); $i++){
                                echo "<option value='".$listeMedicaments[$i]["MED_DEPOTLEGAL"]."'>".$listeMedicaments[$i]['MED_NOMCOMMERCIAL']."</option>";
                            }
                        
                        ?>                        
                    </select>
                    <br>
                    <span class="separateur separateur-noir"></span>
                    
                </div>
            
                <div class="ligne-form">
                    <label >DEPOT LEGAL :</label>
                    <input type="text" name="MED_DEPOTLEGAL" placeholder="Dépot légal" disabled required/>
                </div>
                
                <div class="ligne-form">
                    <label >NOM COMMERCIAL :</label>
                    <input type="text"  name="MED_NOMCOMMERCIAL" placeholder="Nom commercial" disabled required/>
                </div>
                
                <div class="ligne-form">
                    <label >FAMILLE :</label>
                    <input type="text" name="FAM_CODE" placeholder="Famille" disabled required/>
                </div>
                
                <div class="ligne-form">
                    <label >COMPOSITION :</label>
                    <textarea name="MED_COMPOSITION" placeholder="Composition" disabled required></textarea>
                </div>
                
                <div class="ligne-form">
                    <label >EFFETS :</label>
                    <textarea name="MED_EFFETS" placeholder="Effets" disabled required></textarea>
                </div>
                
                <div class="ligne-form">
                    <label >CONTRE INDICATION :</label>
                    <textarea name="MED_CONTREINDIC" placeholder="Contre indication" disabled required></textarea>
                </div>
                
                <div class="ligne-form">
                    <label >PRIX ECHANTILLON :</label>
                    <input type="text" name="MED_PRIXECHANTILLON" placeholder="Prix échantillon" disabled required/>
                </div>

                <div class="ligne-form ligne-form-bouton">
                    
                    <input type="button" value="<" onclick="javascript:direction(-1)"/>
                    <input type="button" value=">" onclick="javascript:direction(1)"/>

                </div>
            </form>

            <!-- Ajout tableau perturbateur -->
            <table id="tableauInteractions">
                <tr>
                    <th>
                        <h3>Médicaments perturbés</h3>
                    </th>
                </tr>
            </table>

        </div>
</div>
