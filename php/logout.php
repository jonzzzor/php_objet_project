<?php
session_start();
//session_unset();
//session_destroy();

echo "log out called";
Authentification::getInstance()->disconnect();
header('location: ../html/header.php');
