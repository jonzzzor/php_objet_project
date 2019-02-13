<?php

// Formulaire de dépot
echo "<form method='post' action=''><br/>\n
<input type='file' name='file'/><br/>\n
<legend>Formats autorisés : webm, gif, jpeg, png, svg ou ogg'</legend><br/>\n
<input type='textarea' name='description' placeholder='Description'/><br/>\n
<button type='submit' name='send_file' value='click'>ENVOYER</button><br/>\n
</form>";

// Variables temporaires pour les tests
$_SESSION['nom'] = 'Temp_Session_Name';
$_SESSION['passwd'] = 'Temp_Session_Password';

// Récupération des champs
$file=$_POST['file'];
$description=$_POST['description'];
$send_file=$_POST['send_file'];
$user = $_SESSION['nom'];
$pwd = $_SESSION['passwd'];
$date = date('Y/m/d');



// Lancement des actions
if ($send_file == 'click'){

    // Affichage résumé envoi
    control_remplissage_champ($file);
    echo('FILE : '.$file.'<br/>');
    control_remplissage_champ($description);
    echo('DESCRIPTION : '.$description.'<br/>');
    echo('SEND : '.$send_file.'<br/>');
    echo('USER : '.$user.'<br/>');
    echo('PWD : '.$pwd.'<br/>');
    echo('DATE : '.$date.'<br/>');
}

// Controle remplissage des champs
function control_remplissage_champ($champ){
    if (isset($champs)){
        echo "CONTROLE_REMPLISSAGE_CHAMP : ".$champ."<br/>";
        return true;
    }else{
        echo "CONTROLE_REMPLISSAGE_CHAMP : champ vide<br/>";
        return false;
    }
}

// Controle type de file
function control_type_file($file){
    if (preg_match('/(.+)\.(.+)$/i', $file, $reg)) {
        echo("EXTENSION FICHIER : $reg[2]<br/>");
        return $reg[2];
    }
}

// Répartition type de fichier
function check_type_extension($extension){
    switch($extension){
        case 'webm': $rangement = 'video';
        break;
        case 'gif':
        case 'jpeg':
        case 'jpg':
        case 'png' :
        case 'svg' : $rangement = 'image';
        break;
        case 'ogg' : $rangement = 'audio';
        break;
        default : echo "CECI n'est pas un fichier valide<br/>";
    }
    echo "RANGEMENT FILE DANS : $rangement<br/>";
    return $rangement;
}

check_type_extension(control_type_file($file));