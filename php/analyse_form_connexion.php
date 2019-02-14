<?php
session_start();
require_once('./connexion.php');

$grainDeSel = "pFXOmRFNO5FQw1nbrGFC";
$user = htmlspecialchars($_POST['nom']) ?? '';
$pwd = htmlspecialchars($_POST['passwd']) ?? '';

$pwd2 = md5($_POST['passwd']);
$pwd3 = md5($_POST['passwd'].$grainDeSel);

// echo '<br/>password hashé : '.$pwd2.'<br/>';
// echo '<br/>password hashé + grainDeSel : '.$pwd3.'<br/>';


function isAuth($user, $pwd, $dbh)
{
    if (checkUser($user, $pwd, $dbh)) {
        return true;
    } else {
        return false;
    }
}

function checkUser($user, $pwd, $dbh)
{
    if (isset($user) && isset($pwd)) {
        // echo "Champs valide<br/>\n";
        // user_connexion($dbh, $pwd, $user,
        if (userConnect($dbh, $pwd, $user)) {
            return true;
        } else {
            // echo "Champs vide<br/>\n";
            return false;
        }
    }
}

function userConnect($dbh, $pwd, $user)
{
    $query = $dbh->prepare("SELECT users.id FROM users WHERE users.nom=? AND users.passwd=?");
    // On vérifie le mot de passe ET le login.
    // Penser à rajouter le HASHING http://php.net/manual/fr/function.md5.php
    $query->execute(array($user, $pwd));
    $result_query = $query->fetch(PDO::FETCH_ASSOC);
    // var_dump($result_query);
    if (isset($result_query['id'])) { // rebelote : penser au hashing.
        // http://php.net/manual/fr/function.md5.php
        // On démarre la session sur les logins et mdp sont bons.
        $_SESSION['nom'] = $user;
        $_SESSION['passwd'] = $pwd;
        $_SESSION['user_id'] = $result_query['id'];
        return true;
    } else {
        return false;
    }
}

$_SESSION['control'] = isAuth($user, $pwd, $dbh);
header('location: ../html/header.php');
