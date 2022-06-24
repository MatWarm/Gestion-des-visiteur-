<body class="body-connexion">
    <div class="box-connexion">
        <div class="box-logo"></div>
        <h1>Connexion</h1>
        <?php 
        // Gestion des messages informatifs :
        if(isset($msgPositif)){
            ?>
        <div class="message message-erreur">
            <i class="fas fa-check-circle"></i>
            <p class="message-p"><?php $msgPositif; ?></p>
        </div>
        <?php 
        }
        
        if(isset($msgErreur)){ ?>
            <div class="message message-positif">
                <i class="fas fa-exclamation-triangle"></i>
                <p class="message-p"><?php echo $msgErreur; ?></p>
            </div>
        <?php 
        } 
        ?>
        <form action="./?action=connexion" method="post">
            <i class="far fa-user"></i>
            <input type="text" name="idVIS" id="idVIS" placeholder="Identifiant" required><br/>
            <i class="fas fa-lock"></i>
            <input type="password" name="mdpVIS" id="mdpVIS" placeholder="Mot de passe" required><br/>
            <button type="submit">Se connecter</button>
        </form>
        <a href="#independant">Mot de passe oublié ?</a>
</body>
</html>