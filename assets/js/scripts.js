// Script du formulaire rapport visite
function ajoutLigne(pNumero){//ajoute une ligne de produits/qt la div "lignes"     
    //masque le bouton en cours
    document.getElementById("but"+pNumero).setAttribute("hidden","true");	
    pNumero++;										//incrémente le numéro de ligne
    var laDiv=document.getElementById("lignes");	//récupére l'objet DOM qui contient les données
    var ligne = document.createElement("div");      // Création de la div contenant le tratra
    ligne.setAttribute("class","ligne-form");       // Ajout de l'attribut ligne-form
    var titre = document.createElement("label") ;	//crée un label
    ligne.appendChild(titre) ;						//l'ajoute é la DIV
    titre.setAttribute("class","titre") ;			//définit les propriétés
    titre.innerHTML= "   PRODUIT : ";
    var liste = document.createElement("select");	//ajoute une liste pour proposer les produits
    ligne.appendChild(liste) ;
    liste.setAttribute("name","PRA_ECH"+pNumero) ;
    liste.setAttribute("class","zone");

    //remplit la liste avec les valeurs de la premiére liste construite en PHP à partir de la base
    liste.innerHTML=formRAPPORT_VISITE.elements["PRA_ECH1"].innerHTML;
    var qte = document.createElement("input");
    ligne.appendChild(qte);
    qte.setAttribute("name","PRA_QTE"+pNumero);
    qte.setAttribute("size","2");
    qte.setAttribute("placeholder","Quantité"); 
    qte.setAttribute("class","zone");
    qte.setAttribute("type","text");

    var bouton = document.createElement("input");
    ligne.appendChild(bouton);

    //ajoute une gestion évenementielle en faisant évoluer le numéro de la ligne
    bouton.setAttribute("onClick","ajoutLigne("+ pNumero +");");
    bouton.setAttribute("type","button");
    bouton.setAttribute("value","+");
    bouton.setAttribute("class","zone");	
    bouton.setAttribute("id","but"+ pNumero);
    

    //saut de ligne
    laDiv.appendChild(ligne);
}

function ajoutLigneQuestion(pNumero){//ajoute une ligne de produits/qt la div "lignes"     
    //masque le bouton en cours
    document.getElementById("button"+pNumero).setAttribute("hidden","true");	
    pNumero++;										//incrémente le numéro de ligne
    var laDiv=document.getElementById("lignes");	//récupére l'objet DOM qui contient les données
    var ligne = document.createElement("div");      // Création de la div contenant le tratra
    ligne.setAttribute("class","ligne-form");       // Ajout de l'attribut ligne-form
    var titre = document.createElement("label") ;	//crée un label
    ligne.appendChild(titre) ;						//l'ajoute é la DIV
    titre.setAttribute("class","titre") ;			//définit les propriétés
    titre.innerHTML= "   Question : ";
    var liste = document.createElement("input");	//ajoute une liste pour proposer les produits
    ligne.appendChild(liste) ;
    liste.setAttribute("type","text");
    liste.setAttribute("name","Question1");
    liste.setAttribute("placeholder","text");
    
    var bouton = document.createElement("input");
    ligne.appendChild(bouton);

    //ajoute une gestion évenementielle en faisant évoluer le numéro de la ligne
    bouton.setAttribute("onClick","ajoutLigne("+ pNumero +");");
    bouton.setAttribute("type","button");
    bouton.setAttribute("value","+");
    bouton.setAttribute("class","zone");	
    bouton.setAttribute("id","but"+ pNumero);
    

    //saut de ligne
    laDiv.appendChild(ligne);
}

/*
* Fonction direction() permettant de naviguer de médicament médicament
* Partie de valentin
*/
var i = 0;
function direction(sens){

    // Récupération de nombre de médicament
    var lesMedicaments = document.getElementById("listeMedicaments");

    i = i + sens;
    //console.log(i);

    if (i < 0){
        i = lesMedicaments.length - 1;
        //console.log(i);
    }
    
    if (i > lesMedicaments.length - 1){
        i = 0;
        //console.log(i);
    }
    
    envoyerRequeteMedicament(lesMedicaments[i].value);
}

/*
* Partie de Mattéo
*/

function selectionne(pValeur, pSelection,  pObjet) {
    //active l'objet pObjet du formulaire si la valeur sélectionnée (pSelection) est égale à la valeur attendue (pValeur)
        if (pSelection==pValeur) 
        { 
            formRAPPORT_VISITE.elements[pObjet].disabled=false; 
        }
        else 
        { 
            formRAPPORT_VISITE.elements[pObjet].disabled=true; 
        }
    }
    
function echantillionOffert($valeurCheckbox){
    var monElement = document.getElementsByClassName("ligne-form-ech");
    if($valeurCheckbox)
    {
        monElement[0].style.display = "block";
    }
    else
    {
        monElement[0].style.display = "none";
    }
}
