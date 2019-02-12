<?php

echo "<form method='post' action=''><br/>\n
    <input type='text' name='nom' placeholder='Nom'><br/>\n
    <input type='password' name='passwd' placeholder='Password'><br/>\n
    <button type='submit' value='connexion'>Connection</button><br/>\n
</form>";

$connexionNom=$_POST['nom'];
$connexionPassword=$_POST['passwd'];

function control_champ_texte($text){
    if(isset($text)){
            echo "Champs valide<br/>\n";
            return true;
    }else{
        echo "Champs vide<br/>\n";
        return false;
    }
}

function send_alert_or_value($text){
    if(control_champ_texte($text)){
        return $text;
    }else{
        return "Champ vide ou incorrect<br/>\n";
    }
}

$control_connection_nom = send_alert_or_value($connexionNom);
$control_connection_passwd = send_alert_or_value($connexionPassword);
echo $control_connection_nom;
echo $control_connection_passwd;
