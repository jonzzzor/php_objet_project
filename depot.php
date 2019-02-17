<?php
try {
    spl_autoload_register(function ($class_name) {
        $path_class = './class/'.$class_name.'.class.php';
        require $path_class;
    });
    session_start();
    ob_start();

    $vue = new Vue();
    $vue->showHeader();
    $vue->showFormAuth();

    if (!Authentification::getInstance()->isAuth()) {
        header('location: ./index.php');
    }
    ob_flush();

    if (Authentification::getInstance()->isAuth()) {
        $vue->showFormDepot();
        $form_depot = new FormulaireDepot();
        //si formulaire déja rempli, on recupèere les infos du dernier formulaire
        $array_depot = $form_depot->getResponse();
        if (isset($array_depot['file_upload']) && isset($array_depot['description'])) {
            $file = $array_depot['file_upload'];
            $description = $array_depot['description'];
            $user_id = Session::getInstance()->getUserId();

            $manager_fichier = new ManagerFichier();
            $recup_adress = $manager_fichier->write_data($file, $description, $user_id);
            $manager_db = new DbRequest();
            $manager_db->write_table($recup_adress);
        }
    }

    $vue->showFooter();
} catch (Exception $e) {
    printf("<div class='container'><div class='alert alert-danger' role='alert'>Erreur revenue : <em>%s</em></div></div>", $e->getMessage());
}
