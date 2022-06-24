    <header>
        <div class="header-gauche">
            <div class="box-logo"></div>
            <h1 class="titre-logo">Laboratoire Galaxy Suisse Bourdin</h1>
        </div>
        <div class="header-droite">
            <a class="bouton bouton-deconnexion" href="./?action=deconnexion">
                <i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </div>
    </header>
    <div class="corps" >
        <nav class="menu-lateral">
            <div class="menu-titre menu-titre-principal">
                <i class="fas fa-tachometer-alt"></i>
                <h2>Dashboard</h2>
            </div>
            <ul>
                <li class="sous-menu">
                <a class="sous-menu-lien" href="./?action=application">Accueil</a>
                </li>
                <li>
                    <div class="menu-titre menu-sous-titre">
                        <i class="fas fa-marker"></i> 
                        <p>Comptes-rendus</p>
                    </div>
                    <ul class="sous-menu">
                        <li>
                            <a class="sous-menu-lien" href="?action=rapportVisite">Nouveau rapport de visite</a>
                        </li>
                        <!--
                        <li>
                            <a class="sous-menu-lien" href="#">Consulter</a>
                        </li>
                        -->
                    </ul>
                </li>
                <li>
                    <div class="menu-titre menu-sous-titre">
                        <i class="far fa-eye"></i>
                        <p>Consulter</p>
                    </div>
                    <ul class="sous-menu">
                        <li>
                            <a class="sous-menu-lien" href="?action=medicaments">Médicaments</a>
                        </li>
                        <!--
                        <li>
                            <a class="sous-menu-lien" href="#">Praticiens</a>
                        </li>
                        -->
                        <li>
                            <a class="sous-menu-lien" href="?action=visiteurs">
                                Autres visiteurs
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <div class="menu-titre menu-sous-titre">
                        <i class="fas fa-user-cog"></i>
                        <p>Gérer son compte</p>
                    </div>
                    <ul class="sous-menu">
                        <li>
                            <a 
                                class="sous-menu-lien" 
                                href="./?action=parametres"
                            >
                                Changer son mot de passe</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
    <body>