<?php

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
    
    $numberRows = count($resultRecherche);
    if ($numberRows == 1) {
        echo '<pre>'; print_r($resultRecherche); echo '</pre>';
    }
    else {
        echo "<form>";
        for ($i=0; $i<$numberRows; $i++) {
            $tempArray = $resultRecherche[$i];
            $tempNomAuteur = $tempArray['nom'];
            $tempDescription = $tempArray['description'];
            echo "<div>

            <input type='hidden' name='etape' value='3'>

            <input type='radio' id='radioresult'.$i name='drone' value='chemin relatif à écrire' checked>
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

}