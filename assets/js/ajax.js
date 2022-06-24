/*
 * Description de ajax.js
 * Fichier de fonctions AJAX
 * Auteur Valentin
 * Creation 13/09/2021
*/

// Fonction permettant la compatibilité de la technologie AJAX avec différents navigateurs
function getRequeteHttp() {
    
    var requeteHttp;
    if (window.XMLHttpRequest) {	
        // Mozilla
        requeteHttp=new XMLHttpRequest();
        if (requeteHttp.overrideMimeType) { 
            // Problème Mozilla
            requeteHttp.overrideMimeType('text/xml');
        }
    } else {
        if (window.ActiveXObject) {	
            // Internet explorer < IE7
            try {
                requeteHttp=new ActiveXObject("Msxml2.XMLHTTP");
            } catch(e) {
                try {
                    requeteHttp=new ActiveXObject("Microsoft.XMLHTTP");
                } catch(e) {
                    requeteHttp=null;
                }
            }
        }
    }
    return requeteHttp;
}

/*
* MEDICAMENTS / PHARMACOPÉE
* Partie de Valentin
*/

// Fonction permettant de créer le fichier XML pour stocker les données
function envoyerRequeteMedicament(depotLegal) {

    // Déclaration des variables :
    var requeteHTTP = getRequeteHttp();
    
    if(requeteHTTP == null) {

        alert("Impossible d'utiliser la technologie Ajax sur ce navigateur.");

    } else {
        
        requeteHTTP.open("POST", "php-xml/getmedicaments.php");
        
        requeteHTTP.onreadystatechange = function() {
            recevoirListeMedicaments(requeteHTTP);
        };
        
        requeteHTTP.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        requeteHTTP.send('medicament='+escape(depotLegal));
        //Test -> console.log(requeteHTTP);
        
    }
}

// Fonction permettant de retransmettre les données du fichiers XML
function recevoirListeMedicaments(requeteHttp) {
    
    if (requeteHttp.readyState == 4) {
            //Test -> console.log("Http",requeteHttp.status);
        if (requeteHttp.status == 200) {

            // Récupération des données du fichiers XML
            var medicaments = requeteHttp.responseXML.getElementsByTagName("medicament");
            var medicamentsPerturbes = requeteHttp.responseXML.getElementsByTagName("interactions");
            
            // Récupération de la liste des médicaments
            var selecteurMedicament = document.getElementById("listeMedicaments");

            // Boucle attribution de l'attribut SELECTED de la liste lors de la navigation avec les flèches
            let j = 0;
            var confirmation = false;

            while(j < selecteurMedicament.length && confirmation === false) {

                if(medicaments[0].childNodes[0].textContent === selecteurMedicament[j].value) {

                    // Boucle qui supprime tous attributs selected
                    for(let i = 0; i < selecteurMedicament.length; i++) {
                        selecteurMedicament[i].removeAttribute("selected");
                    }

                    // Ajout attribut selected à l'élément concerné
                    selecteurMedicament[j].setAttribute("selected","selected");
                    confirmation = true;
                    
                } else {
                    j++;
                }
            }

            // Affichage des données dans la vue
            // 1 -> Récupération des structures HTML de chaque champs (grâce àu DOM)
            // 2 -> Attribution des valeurs
            
            // Tableau des nom des champs dans le formulaire (attribut name)
            var nomChamps = ["MED_DEPOTLEGAL", "MED_NOMCOMMERCIAL", "FAM_CODE", "MED_COMPOSITION", "MED_EFFETS", "MED_CONTREINDIC", "MED_PRIXECHANTILLON"];
            
            // Tableau des champs HTML (DOM)
            var mesInputs = [];

            // Récupération des éléments par l'attribut html name (champs de la page)
            for(let i = 0; i < nomChamps.length; i++) {

                var input = document.getElementsByName(nomChamps[i]);
                mesInputs.push(input);
                
            }

            // Modification de la valeur des champs HTML
            for(let i = 0; i < mesInputs.length; i++) {

                // Ajout des valeurs du fichier XML dans le champs adapté :
                // mesInputs[i] -> Récupération d'une NodeList comprenant un élément HTML
                // .item(0) -> Récupération de l'élément HTML commprenant la valeur (.value)

                mesInputs[i].item(0).value = medicaments[0].childNodes[i].textContent;

            }

            // Récupération de l'élément HTML du tableau
            var tableau = document.getElementById("tableauInteractions");

            if(medicamentsPerturbes.item(0).childNodes.length > 0) {

                // Création du tableau des interactions
                for (var i = 0; i < medicamentsPerturbes.item(0).childNodes.length; i++) {

                    // Ajout d'une ligne
                    var ligne = tableau.insertRow(1);

                    // Ajout d'une cellule
                    var cellule = ligne.insertCell(0);

                    // Ajout d'une valeur dans la cellule
                    cellule.innerHTML = '<a class="lienTableauInteractions" onClick="envoyerRequeteMedicament(\''+medicamentsPerturbes.item(0).childNodes[i].textContent+'\')">'+medicamentsPerturbes.item(0).childNodes[i].textContent+'</a>';

                }

            } else {

                // Suppression des lignes à chaque changement de médicaments à condition que le tableau ait des plus de une ligne
                if(tableau.rows.length > 1) {

                    for(let i = -1; i < tableau.rows.length; i++) {
                        var ligne = tableau.deleteRow(1)
                    }

                }

                
            }


        } else {
                alert("La requête ne s'est pas correctement exécutée");
        }
    }
}

/*
* RAPPORT VISITE
* Partie de Mattéo
*/

function envoyerCoeffPraticien(praticien){
    //console.log("praticien : ",praticien);
    var requeteHTTP = getRequeteHttp();
    if(requeteHTTP == null) {
        alert("Impossible d'utiliser la technologie Ajax sur ce navigateur.");
    } else {
        requeteHTTP.open("POST", "php-xml/getcoefficient.php");
        
        requeteHTTP.onreadystatechange = function() {
            recevoirCoeffPraticien(requeteHTTP);
        };
        
        requeteHTTP.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        requeteHTTP.send('idPraticien='+escape(praticien));
        //console.log(requeteHTTP);
    }
}


function recevoirCoeffPraticien(requeteHttp){
        
    if (requeteHttp.readyState == 4){
            //Test -> console.log("Http",requeteHttp.status);
        if (requeteHttp.status == 200){
            // résultat xml (balise html dans le fichier getcoefficient.php)
            var coefficient = requeteHttp.responseXML.getElementsByTagName("coefficient");
            console.log("coef = ",coefficient);
            //On vise l'élément hmtl qui se nomme PRA_COEFF
            var nomChamp = document.getElementsByName("PRA_COEFF");
            //console.log("nom champ :",nomChamp);
            // donne la valeur du coefficient a l'élément html
            nomChamp.item(0).value = coefficient.item(0).childNodes[0].data;
            console.log("nom champ :",nomChamp);
        }
        else{
            alert("La requête ne s'est pas correctement exécutée");
        }
    }
    
}

/*
* VISITEURS
* Partie de Sylvain
*/

// Fonction permettant d'envoyer les données dans un fichier XML
function envoyerRequeteVisiteur(idDepartement) {
    
    // Test -> alert(depotLegal);
    
    // Déclaration des variables :
    var requeteHTTP = getRequeteHttp();
    
    if(requeteHTTP == null) {
        alert("Impossible d'utiliser la technologie Ajax sur ce navigateur.");
    } else {
        
        requeteHTTP.open("POST", "php-xml/getVisiteurs.php");
        
        requeteHTTP.onreadystatechange = function() {
            recevoirListeVisiteur(requeteHTTP);
        };
        
        requeteHTTP.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        requeteHTTP.send('leDepartement='+idDepartement);
        //Test -> console.log(requeteHTTP);
        
    }
}

// Fonction permettant de recevoir la liste des médicaments
function recevoirListeVisiteur(requeteHttp){
    
    if (requeteHttp.readyState == 4){
            //Test -> console.log("Http",requeteHttp.status);
        if (requeteHttp.status == 200){

            // on récupère les valeurs de notre tableau XML créé en fonction du département
            var visiteurs = requeteHttp.responseXML.getElementsByTagName("visiteur");
            
            // On récupère le select déjà fait via la div (récupérée dans la variable corps), dans laquelle il (le select) est.
            var corps=document.getElementById("ligne-form");
            var selectvisiteurs=corps.getElementsByTagName("select").item(1);
            
            
            // si on avait des éléments dans la liste, on les supprimes
            if (selectvisiteurs != null){
                
                selectvisiteurs.remove();
            }
            
            // on recréé le select après l'avoir détruit
            selectvisiteurs=document.createElement("select");
            selectvisiteurs.setAttribute("id","listeVisiteurs");
            selectvisiteurs.setAttribute("size","4");
            
            
            
            
            
            for (let i = 0; i < visiteurs.length; i++){
                
                // On créé l'option
                var nouvOption = document.createElement('option');
                
                // on récupère la ville
                leVisiteur = visiteurs.item(i);
                
                // on récupère la ville
                idVis = leVisiteur.getElementsByTagName('id').item(0).firstChild.nodeValue
                nomVis = leVisiteur.getElementsByTagName('nom').item(0).firstChild.nodeValue;
                
                // on affecte la valeur à l'option
                nouvOption.value = idVis;
                
                // on ajoute la fonction onclick
                // nouvOption.onselect = envoyerinfosVisiteur(nouvOption.value);
                nouvOption.appendChild(document.createTextNode(nomVis));
                
                // on affecte l'option au select
                selectvisiteurs.appendChild(nouvOption);
                
            }
            selectvisiteurs.onchange = function() {envoyerinfosVisiteur(this.value);};
            // on affiche le select avant le premier label
            corps.insertBefore(selectvisiteurs,corps.getElementsByTagName("label").item(0));
            

        }else{
                alert("La requête ne s'est pas correctement exécutée");
        }
    }
}



// Fonction permettant d'envoyer les données dans un fichier XML
function envoyerinfosVisiteur(idVis) {
    
    // Test -> alert(depotLegal);
    
    // Déclaration des variables :
    var requeteHTTP = getRequeteHttp();
    
    if(requeteHTTP == null) {
        alert("Impossible d'utiliser la technologie Ajax sur ce navigateur.");
    } else {
        
        requeteHTTP.open("POST", "php-xml/getInfosVisiteur.php");
        console.log(requeteHTTP);
        requeteHTTP.onreadystatechange = function() {
            recevoirinfosVisiteur(requeteHTTP);
        };
        
        requeteHTTP.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
        requeteHTTP.send('leVisiteur='+idVis);
        //Test -> console.log(requeteHTTP);
        
    }
}

// Fonction permettant de recevoir la liste des médicaments
function recevoirinfosVisiteur(requeteHttp){
    
    if (requeteHttp.readyState == 4){
            //Test -> console.log("Http",requeteHttp.status);
        if (requeteHttp.status == 200){

            // on récupère les valeurs de notre tableau XML créé en fonction du département
            var visiteur = requeteHttp.responseXML.getElementsByTagName("visiteur");
            
            // labels
            var champs = ["NomVis","PreVis","AdrVis","CP-Vis","VilleVis","SecVis"];
            
            
            for(let i = 0; i < champs.length; i++){
                let label = document.getElementById(champs[i]);
                label.setAttribute('value',visiteur.item(0).getElementsByTagName(champs[i]).item(0).firstChild.nodeValue); 
            }
            

        }else{
                alert("La requête ne s'est pas correctement exécutée");
        }
    }
}