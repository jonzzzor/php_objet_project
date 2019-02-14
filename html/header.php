<?php
    session_start();
    try {
        //Connexion à la base de données
        include('../php/connexion.php');
    } catch (Exception $exeption) {
        //En cas d'erreur, afficher le message d'erreur
        sprintf("Erreur de connexion : %s<br/>\n", $exeption->getMessage());
    }
?>

<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" lang="fr">

<head>
    <title>Mutimedia</title>
    <!-- meta http-equiv="Content-Type" content="text/html; charset=utf-8"/ -->
    <link rel="stylesheet" type="text/css" media="all" href="./css/style.css" />

    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css" integrity="sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA" crossorigin="anonymous">
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-light bg-light">
        <?php
        $bonjour = $_SESSION['nom'] ?? 'invité';
        echo 'Bonjour '.$bonjour.'     ';
        // var_dump($_SESSION['control']);
        if (isset($_SESSION['control']) && !$_SESSION['control']) {
            echo 'Champs de saisie incorrect, veuillez recommencer.';
        }
        ?>
        <form action="../php/analyse_form_connexion.php" class="form-inline ml-auto" method="POST">
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Login</span>
                </div>
                <input type="text" class="form-control" placeholder="username" name="nom" aria-describedby="basic-addon1">
            </div>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Password</span>
                </div>
                <input type="password" class="form-control" placeholder="password" name="passwd" aria-describedby="basic-addon1">
            </div>

            <input class="btn btn-primary" type="submit" value="Submit">
            <a href='../php/logout.php' class="btn btn-outline-danger">Sign out</a>

        </form>
    </nav>


    <div class="container">
      <div class="row">
        <!-- Informations entrantes-->
        <div class="col-md-6">
            <a href='../php/form_depot.php'>Ajouter medias</a>

        </div>
     </div>
   </div>
