<?php
spl_autoload_register(function ($class_name) {
    $path_class = './class/'.$class_name.'.class.php';
    require $path_class;
});
session_start();


require_once('./html/header.html');
$form_auth = new FormulaireAuthentification();
$form_auth->showForm();


$array_auth = $form_auth->getResponse();


$resultat_auth = Authentification::getInstance()->checkUser($array_auth['user'], $array_auth['passwd']);
echo "résultat de l'authentification : $resultat_auth <br/>";
$messageSession = <<<EOFMSG
<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item active" aria-current="page"><?php printf("%s", Session::getInstance()->getUserId()) ?>
</li>
</ol>
</nav>
EOFMSG;

if (Authentification::getInstance()->isAuth()) {
printf('%s',$messageSession);
}
else {
//faire message d'erreur
}



//AFFICHAGE DU FORMULAIRE DE RECHERCHE

//on creer l'instance
$form_recherche = new FormulaireRecherche();
//si formualire déja rempli, on recuprere les info du derniers formulaire
$array_response = $form_recherche->getResponse();
//on affiche le formulaire
$form_recherche->showForm();

$query_result = new DbSearch();


if (isset($_GET['etape']) && $_GET['etape'] === '2') {
$resultRecherche = $query_result->rechercheDocument($array_response['form_autor'], $array_response['form_desc'],
$array_response['audio_checkbox'], $array_response['video_checkbox'], $array_response['image_checkbox']);

$_SESSION['resultatRecherche'] = $resultRecherche;

/* echo '
<pre>';
    // print_r($resultRecherche);
    // echo '</pre>';
*/

$numberResults = count($resultRecherche);
if ($numberResults == 1) {
echo "<br />resultat unique<br />";
goto etape3 ;
} elseif ($numberResults > 1) {
echo "<br />resultats multiples<br />";
$form_recherche_radioButton = new FormulaireRechercheRadioButton();
$form_recherche_radioButton->showForm($resultRecherche);
} else {
echo "<br />aucun resultat<br />";
}
}


if (isset($_GET['etape']) && $_GET['etape'] === '3') {
etape3:


//on creer l'instance
$form_recherche_radioButton = new FormulaireRechercheRadioButton();
//si formualire déja rempli, on recuprere les info du derniers formulaire
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
} else {
echo "Le document n'existe pas";
}
}



require_once('./html/footer.html');