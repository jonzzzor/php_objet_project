<?php
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
}

$vue->showFooter();
