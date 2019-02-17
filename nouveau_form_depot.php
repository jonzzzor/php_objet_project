<?php
require_once('./class/FormulaireDepot.class.php');
require_once('./class/ManagerFichier.class.php');
require_once('./class/Connexion.class.php');
require_once('./class/DbSearch.class.php');

$formulaireDepot = new FormulaireDepot();

$formulaireDepot->showForm();

$array_infos = $formulaireDepot->getResponse();

if($array_infos){
    $file = $array_infos['file_upload'];
    $description = $array_infos['description'];
    $user_id = 1; // A RECUP DANS FORM JONHATHAN
    $manager_fichier = new ManagerFichier();
    $recup_adress = $manager_fichier->write_data($file, $description, $user_id);
    $manager_db = new DbSearch();
    $manager_db->write_table($recup_adress);
}

