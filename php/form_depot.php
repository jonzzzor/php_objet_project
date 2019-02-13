<?php
session_start();
require_once('./connexion.php');


// Formulaire de dépot
//
$form_up = <<<EOFUPLOAD
<form method='post' action='#' id="data_upload" enctype="multipart/form-data"><br/>
    <input type='file' name='file_upload'/><br/>
    <legend>Formats autorisés : .webm, .gif, .jpeg, .jpg, .png, .svg ou .ogg</legend><br/>
    <input type='textarea' name='description' placeholder='Description'/><br/>
    <button type='submit' name='send_file' value='click'>ENVOYER</button><br/>
</form>"
EOFUPLOAD;

printf('%s', $form_up);

// Variables temporaires pour les tests
// $_SESSION['nom'] = 'Temp_Session_Name';
// $_SESSION['passwd'] = 'Temp_Session_Password';

// Récupération des champs

// write_data($_FILES['file_upload']);
$file_name = $_FILES['file_upload']['name'] ?? '';
$description = $_POST['description'] ?? '';
$send_file = $_POST['send_file'] ?? '';
$user = $_SESSION['nom'] ?? '';
$pwd = $_SESSION['passwd'] ?? '';
$date = date('Y/m/d');




// Lancement des actions
if ($send_file == 'click') {

    // Affichage résumé envoi
    control_remplissage_champ($file_name);
    echo('FILE : '.$file_name.'<br/>');
    control_remplissage_champ($description);
    echo('DESCRIPTION : '.$description.'<br/>');
    echo('SEND : '.$send_file.'<br/>');
    echo('USER : '.$user.'<br/>');
    echo('PWD : '.$pwd.'<br/>');
    echo('DATE : '.$date.'<br/>');
}

// Controle remplissage des champ
function control_remplissage_champ($champ)
{
    if (isset($champ)) {
        echo "CONTROLE_REMPLISSAGE_CHAMP : ".$champ."<br/>";
        return true;
    } else {
        echo "CONTROLE_REMPLISSAGE_CHAMP : champ vide<br/>";
        return false;
    }
}

// Controle type de file
function control_type_file($file_name)
{
    if (preg_match('/(.+)\.(.+)$/i', $file_name, $reg)) {
        // var_dump($reg);
        // echo("EXTENSION FICHIER : $reg[2]<br/>");
        return $reg[2];
    }
}

// Répartition type de fichier
function check_type_extension($extension)
{
    switch ($extension) {
        case 'webm': $rangement = 'video';
        break;
        case 'gif':
        case 'jpeg':
        case 'jpg':
        case 'png':
        case 'svg': $rangement = 'image';
        break;
        case 'ogg': $rangement = 'audio';
        break;
        default: echo "CECI n'est pas un fichier valide<br/>";
        return false;
    }
    // echo "RANGEMENT FILE DANS : $rangement<br/>";
    return $rangement;
}

check_type_extension(control_type_file($file_name));

function write_data()
{
    $dest_dir = '../application/multimedia';
    $new_folder_extension = check_type_extension(control_type_file($_FILES['file_upload']['name']));
    if (!$new_folder_extension) {
        echo 'error';
        return false;
    }
    // $new_name = basename($_FILES['file_upload']['name']); //récupère le nom du fichier à écrire.
    $new_name = $new_folder_extension.date('ymd_His').'.'.control_type_file($_FILES['file_upload']['name']);
    $new_location = $dest_dir.'/'.$new_folder_extension.'/'.$new_name;
    if (isset($_FILES['file_upload']['error']) && UPLOAD_ERR_OK === $_FILES['file_upload']['error']) {
        if (@move_uploaded_file($_FILES['file_upload']['tmp_name'], $new_location)) {
            printf("<h2>transfert de <samp>%s</samp> réalisé</h2>\n", $new_name);
            printf("<p>le lien suivant <a href=\"%s\">%s</a> donne accès au fichier transféré</p>\n", $new_location, $new_location);
            $tab_assoc = array();
            $tab_assoc['chemin_relatif'] = $new_location;
            $tab_assoc['mime_type'] = $_FILES['file_upload']['type'];
            $tab_assoc['description'] = $_POST['description'];
            $tab_assoc['auteur_id'] = 2;
            return $tab_assoc;
        } else {
            $message = sprintf(
                        "Une erreur interne est survenue lors de la récupération du fichier <samp>%s</samp> (<em>%s</em>).<br/>".
                        "<p>message : <code>%s</code><br/>",
                        $_FILES['file_upload']['tmp_name'],
                        $new_name,
                        join("<br/>\n", error_get_last())
                        );
        }
    } else {
        $message = 'Une erreur interne a empêché l\'upload de l\'image : '. $_FILES['file_upload']['error'];
    }
    return false;
}
$result_tab_write = write_data();

function write_table($result_tab_write, $dbh)
{
    $query_insert = $dbh->prepare("INSERT INTO datas (chemin_relatif, mime_type, description, auteur_id) VALUES (?, ?, ?, ?)");
    $query_insert->execute(array($result_tab_write['chemin_relatif'], $result_tab_write['mime_type'], $result_tab_write['description'], $result_tab_write['auteur_id']));
}

if (!$result_tab_write) {
    echo 'ERREUR VA ECOUTER DE LASMR 5MIN';
} else {
    write_table($result_tab_write, $dbh);
    echo 'SUCCESS';
}
