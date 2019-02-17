<?php
spl_autoload_register(function ($class_name) {
    $path_class = './class/'.$class_name.'.class.php';
    require $path_class;
});
session_start();

$vue = new Vue();
$vue->showHeader();
$vue->showFormAuth();
$array_response = $vue->showFormSrch();


//AFFICHAGE DU FORMULAIRE DE BOUTON RADIO

if (isset($_GET['etape']) && $_GET['etape'] === '2') {
    $databaseRequest= new DbSearch();
    $resultRecherche = $databaseRequest->rechercheDocument(
        $array_response['form_autor'],
        $array_response['form_desc'],
        $array_response['audio_checkbox'],
        $array_response['video_checkbox'],
        $array_response['image_checkbox']
    );

    $_SESSION['resultatRecherche'] = $resultRecherche;

    $numberResults = count($resultRecherche);
    if ($numberResults == 1) {
        //  echo "<br />resultat unique<br />";
        goto etape3 ;
    } elseif ($numberResults > 1) {
        //echo "<br />resultats multiples<br />";
        $vue->showFormSrchBtn($resultRecherche);
    } else {
        echo "<p>Aucun résultat</p>";
    }
}

//AFFICHAGE DU FORMULAIRE DE RESULTAT

if (isset($_GET['etape']) && $_GET['etape'] === '3') {
    etape3:
    $vue->showMediaContent();
}

$vue->showFooter();
