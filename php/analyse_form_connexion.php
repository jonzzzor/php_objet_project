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


function isAuth($user, $pwd, $dbh, $table_users, $col_username, $col_password)
{
    if (checkUser($user, $pwd, $dbh, $table_users, $col_username, $col_password)) {
        return true;
    } else {
        return false;
    }
}

function checkUser($user, $pwd, $dbh, $table_users, $col_username, $col_password)
{
    if (isset($user) && isset($pwd)) {
        // echo "Champs valide<br/>\n";
        // user_connexion($dbh, $pwd, $user, $table_users);
        if (userConnect($dbh, $pwd, $user, $table_users, $col_username, $col_password)) {
            return true;
        } else {
            // echo "Champs vide<br/>\n";
            return false;
        }
    }
}

function userConnect($dbh, $pwd, $user, $table_users, $col_username, $col_password)
{
    $query = $dbh->prepare("SELECT $col_password FROM $table_users WHERE $col_username=?");
    // On vérifie le mot de passe ET le login.
    // Penser à rajouter le HASHING http://php.net/manual/fr/function.md5.php
    $query->execute(array($user));

    if (($query->fetchColumn() === $pwd)) { // rebelote : penser au hashing.
        // http://php.net/manual/fr/function.md5.php

        // On démarre la session sur les logins et mdp sont bons.
        $_SESSION['nom'] = $user;
        $_SESSION['passwd'] = $pwd;
        
        return true;
    } else {
        return false;
    }
}

$_SESSION['control'] = isAuth($user, $pwd, $dbh, $table_users, $col_username, $col_password);

header('location: ../html/header.php');
