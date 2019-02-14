<?php

session_start();

require_once("connexion_database.php");
require_once("function_database.php");

$autor = $_GET['form_autor'] ?? '';
$desc = $_GET['form_desc'] ?? '';
$audioSelected = $_GET['audio_checkbox'] ?? '';
$videoSelected = $_GET['video_checkbox'] ?? '';
$imageSelected = $_GET['image_checkbox'] ?? '';

if (!isset($_GET['etape'])) {
    $audioSelected = 'checked';
    $videoSelected = 'checked';
    $imageSelected = 'checked';
}

echo "<form method='get' action='#'>

		<input type='hidden' name='etape' value='2'>

        <label for='form_autor'>Auteur</label>
        <input type='text' id='form_autor' name='form_autor' value=$autor><br>

        <input type='checkbox' name='audio_checkbox' value='checked' $audioSelected>Audio<br>
        <input type='checkbox' name='image_checkbox' value='checked' $imageSelected>Image<br>
        <input type='checkbox' name='video_checkbox' value='checked' $videoSelected>Video<br>

        <label for='form_desc'>Description</label>
        <input type='text' id='form_desc' name='form_desc' maxlength='50' value=$desc><br>

        <input type='submit' value='Rechercher'>
    </form>";

if (isset($_GET['etape']) && $_GET['etape'] === '2') {

    $resultRecherche = rechercheDocument($autor, $desc, $audioSelected, $videoSelected, $imageSelected);
    //echo '<pre>'; print_r($resultRecherche); echo '</pre>';
    
$_SESSION['resultatRecherche']=$resultRecherche;

    $numberRows = count($resultRecherche);
    if ($numberRows == 1) {
        //echo '<pre>'; print_r($resultRecherche); echo '</pre>';
        goto etape3 ;
        }
    else {
        //echo '<pre>'; print_r($resultRecherche); echo '</pre>';
                echo "<form method='get' action='#'>";
        for ($i=0; $i<$numberRows; $i++) {
            $tempArray = $resultRecherche[$i];
            $tempNomAuteur = $tempArray['nom'];
            $tempDescription = $tempArray['description'];
            $tempIdData = $tempArray['idData'];
            echo "<div>

            <input type='hidden' name='etape' value='3'>

            <input type='radio' id='radioresult'.$i name='idData' value=$tempIdData>
            <label for='huey'>Nom de l'auteur : $tempNomAuteur <br> Description sommaire : $tempDescription</label>
            </div>";
        }
        
        echo "<div>
        <button type='submit'>Envoyer</button>
        </div>
        </form>";
    }
}

//etape 3

if (isset($_GET['etape']) && $_GET['etape'] === '3') {
    etape3:
    $idData=$_GET['idData'] ?? '';
    if (count($_SESSION['resultatRecherche'])==1) {
        $idData=$_SESSION['resultatRecherche'][0]['idData'];
    }
        //echo 'Notre résultat est '.$idData;
    //echo '<pre>'; print_r($_SESSION['resultatRecherche']); echo '</pre>';


    foreach ($_SESSION['resultatRecherche'] as $document) {
        if ($idData === $document['idData'] ){
            //echo '<pre>'; print_r($document); echo '</pre>';
            $mime_type=$document['mime_type'];
            preg_match('/(.+)\/(.+)$/i', $mime_type, $reg);
            $documentLocation = './application/multimedia/'.$reg[1].'/'.$document['chemin_relatif'];
            //echo '<pre>'; print_r($reg); echo '</pre>';
            switch ($reg[1]) {
                    case 'image': echo "<img src='$documentLocation' alt='Image sélectionnée' />";
                    break;
                    case 'audio': echo "<audio controls='controls'>
                            <source src=$documentLocation type=$mime_type />
                            Votre navigateur ne supporte pas le lecteur audio.
                          </audio>";
                    break;
                    case 'video': echo "<video controls width='1000'>
                            <source src=$documentLocation type=$mime_type>                        
                            Votre navigateur ne supporte pas le lecteur vidéo.
                        </video>";
                    break;
                    default: echo 'erreur format inconnu';
                }
//recherche troncage texte <script type="text/javascript"> function MaxLengthTextarea(objettextarea,maxlength){  if (objettextarea.value.length > maxlength) {    objettextarea.value = objettextarea.value.substring(0, maxlength);    alert('Votre texte ne doit pas dépasser '+maxlength+' caractères!');   }}</script>
$description=$document['description'];
echo "<p><legend>$description</legend></p>";

        }
        // foreach ($document as $key => $value) {
            
       // }
    }
}