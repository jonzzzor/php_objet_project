<?php
spl_autoload_register(function ($class_name) {
    $path_class = './class/'.$class_name.'.class.php';
    require $path_class;
});
session_start();


require_once('./html/header.html');




/*********************************/
/*      AUTHENTIFICATION         */
/*********************************/
 
//ON RECUPERE LA SESSION SI ELLE EXISTE
/*
if(isset($_SESSION["SessionUser"]) && $_SESSION["SessionUser"] instanceof SESSION){
    $session = $_SESSION["SessionUser"];
    SESSION::setInstance($session);
}
*/

 
//ON RECUPERE LA REPONSE DU FORMULAIRE DE CONNEXION
$form_auth = new FormulaireAuthentification();
$array_auth = $form_auth->getResponse();

//SI USER && MDP EXISTE _ ON VERIFIE L'AUTHENTIFICATION
if($array_auth && isset($array_auth['user']) && isset($array_auth['passwd']) ){

    $resultat_auth = Authentification::getInstance()->checkUser($array_auth['user'], $array_auth['passwd']);    
    if($resultat_auth)
    {
       // echo "Bienvenue ". SESSION::getInstance()->getUserNom()." <br/>";
        //echo "Vous êtes connecté ! <br/>";
    }
    else{
        echo "login/mdp invalide <br/>";
    }
}
//SINON SI DEMANDE DE DECONNEXION
else if($array_auth && isset($array_auth['session_destroy'])){ 
    Authentification::getInstance()->disconnect();
}

//ON AFFICHE LE FORMULAIRE DE CONNEXION EN CONSEQUENCE
$form_auth->showForm();
 



/*********************************/
/*      FORMULAIRE RECHERCHE     */
/*********************************/


//AFFICHAGE DU FORMULAIRE DE RECHERCHE
//on crée l'instance
$form_recherche = new FormulaireRecherche();
//si formulaire déja rempli, on recupèere les infos du dernier formulaire
$array_response = $form_recherche->getResponse();
//on affiche le formulaire
$form_recherche->showForm();


//AFFICHAGE DU FORMULAIRE DE BOUTON RADIO
if (isset($_GET['etape']) && $_GET['etape'] === '2') {
    $databaseRequest= new DbSearch();
    $resultRecherche = $databaseRequest->rechercheDocument($array_response['form_autor'], $array_response['form_desc'],
    $array_response['audio_checkbox'], $array_response['video_checkbox'], $array_response['image_checkbox']);

    $_SESSION['resultatRecherche'] = $resultRecherche;

    /* echo '
    <pre>';
        // print_r($resultRecherche);
        // echo '</pre>';
    */

    $numberResults = count($resultRecherche);
    if ($numberResults == 1) {
      //  echo "<br />resultat unique<br />";
        goto etape3 ;
    } elseif ($numberResults > 1) {
        //echo "<br />resultats multiples<br />";
        $form_recherche_radioButton = new FormulaireRechercheRadioButton();
        $form_recherche_radioButton->showForm($resultRecherche);
    } else {
        echo "<p>Aucun résultat</p>";
    }
}






//AFFICHAGE DU FORMULAIRE DE RESULTAT
if (isset($_GET['etape']) && $_GET['etape'] === '3') {
    etape3:


    //on crée l'instance
    $form_recherche_radioButton = new FormulaireRechercheRadioButton();
    //si formulaire déja rempli, on recuprere les info du derniers formulaire
    $array_response = $form_recherche_radioButton->getResponse();


    $idData = '';

    //SI RESULTAT UNIQUE
    if (count($array_response)==0 && count($_SESSION['resultatRecherche'] ?? array())==1) {
    $idData=$_SESSION['resultatRecherche'][0]['idData'];
    }
    //SI RESULTAT MULTIPLE
    elseif (count($array_response)>0 && count($_SESSION['resultatRecherche'] ?? array())>0) {
    $idData = $array_response['idData'] ?? '';
    }



    if ($idData != '') {
        foreach ($_SESSION['resultatRecherche'] as $array_document) {
            if ($idData === $array_document['idData']) {
                //on creer l'instance
                $form_affichage = new FormulaireAffichageDocument();
                //si affiche le formulaire
                $form_affichage = $form_affichage->showForm($array_document);
            }
        }
    } 
    else {
        echo "Le document n'existe pas";
    }
}


require_once('./html/footer.html');