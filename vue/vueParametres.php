        <div class="corps-application">

        <div class="entete-corps">
            <h1>Paramètres du compte</h1>
            <span class="separateur separateur-noir"></span>
        </div>

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
                       <!--Formulaire changement d'identifiant--> 
            <form action="./?action=parametres" method="POST">
                <div class="ligne-form">
                    <input 
                        type="text" name="nouveauIden" 
                        placeholder="Nouveau identifiant"  
                    />
                    <input type="submit" />
                </div>
            </form>
           
           <!--Formulaire changement du mot de passe--> 
            <form action="./?action=parametres" method="POST">
                <div class="ligne-form">
                    <input 
                        type="password" name="nouveauMdp" 
                        placeholder="Nouveau mot de passe"  
                    />
                    <input type="submit" />
                </div>
            </form>
        </div>
</div>