<?php
session_start();
require('./connexion.php');

$user = $_POST['nom'] ?? '';
$pwd = $_POST['passwd'] ?? '';

// echo "<form method='post' action=''><br/>\n
//     <input type='text' name='nom' placeholder='Nom'><br/>\n
//     <input type='password' name='passwd' placeholder='Password'><br/>\n
//     <button type='submit' value='connexion'>Connection</button><br/>\n
// </form>";

// $connexionNom=$_POST['nom'];
// $connexionPassword=$_POST['passwd'];

function control_champ_texte($text)
{
    if (isset($text)) {
        echo "Champs valide<br/>\n";
        return true;
    } else {
        echo "Champs vide<br/>\n";
        return false;
    }
}

function send_alert_or_value($text)
{
    if (control_champ_texte($text)) {
        return $text;
    } else {
        return "Champ vide ou incorrect<br/>\n";
    }
}


// // T O D O : ajouter function de hash pour décoder le grain de sel et le md5, et utiliser password_hash() à l'écriture d'un mdp
// function user_connexion($dbh)
// {
//     // $sql_request_user = "SELECT * FROM $table_users WHERE $col_username=$user";
//     // $sql_request_password = "SELECT * FROM $table_users WHERE $col_password=$pwd";
//     $query_user = $dbh->prepare("SELECT * FROM login WHERE nom=?");
//     $query_password = $dbh->prepare("SELECT * FROM login WHERE passwd=?");
//     $query_user->execute(array($user));
//     $query_password->execute(array($pwd));
//     if ($query_user->fetchColumn() === $_POST['nom'] && $query_password->fetchColumn() === $_POST['passwd']) { // ne pas oublier le hashing
//         // starts the session created if login info is correct
//         session_start();
//         $_SESSION['username'] = $_POST['username'];
//        // exit;
//     }
// }
//

// print_r(array($user));
// print_r(array($pwd));

echo $pwd.'<br/>';


    if (isset($user));
    {
    $query = $dbh->prepare("SELECT ? FROM $table_users WHERE nom=?");

    // On vérifie le mot de passe ET le login.
    // Penser à rajouter le HASHING
    $query->execute(array($pwd, $user));

    if (($query->fetchColumn() === $pwd)) { // rebelote : penser au hashing.

        // On démarre la session sur les logins et mdp sont bons.
        session_start();
        $_SESSION['nom'] = $user;
        $_SESSION['passwd'] = $pwd;
        echo '<br/><em>Connexion OK!</em></br>';
        exit;
    } else {
        echo '<br/><em>WRONG!</em><br/><br/>';
    }
}


// user_connexion($dbh);

$control_connection_nom = send_alert_or_value($user);
$control_connection_passwd = send_alert_or_value($pwd);
echo $control_connection_nom;
echo $control_connection_passwd;

// header('location: ../html/header.html');
