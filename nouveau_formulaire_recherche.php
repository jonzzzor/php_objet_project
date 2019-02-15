<?php

require_once("connexion_database.php");
require_once("function_database.php");
require_once("class/FormulaireRecherche.class.php");
require_once("class/FormulaireRechercheRadioButton.class.php");



//AFFICHAGE DU FORMULAIRE DE RECHERCHE

//on creer l'instance
$form_recherche = new FormulaireRecherche();
//si formualire déja rempli, on recuprere les info du derniers formulaire
$array_response = $form_recherche->getResponse();
//on affiche le formulaire
$form_recherche->showForm();


if (isset($_GET['etape']) && $_GET['etape'] === '2') {
    
    $resultRecherche = rechercheDocument($array_response['form_autor'], $array_response['form_desc'], $array_response['audio_checkbox'], $array_response['video_checkbox'], $array_response['image_checkbox']);
    
    echo '<pre>'; print_r($resultRecherche); echo '</pre>';
    
    
    $numberResults = count($resultRecherche);
    if ($numberResults == 1) { 
        
        echo "<br/>resultat unique<br/>";
        //goto etape3 ;
    }
    else if($numberResults > 1){
        
        echo "<br/>resultats multiples<br/>";
        $form_recherche_radioButton = new FormulaireRechercheRadioButton(); 
        $form_recherche_radioButton->showForm($resultRecherche);
    }
    else
    {
        echo "<br/>aucun resultat<br/>";
    }
    
    
}
 