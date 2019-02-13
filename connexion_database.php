<?php

$hostname = 'localhost';
$dbname = 'site_multimedia';
$username = 'root'; 
$password = 'root';

try 
{
    /*** echo a message saying we have connected ***/
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
    echo 'Connected to database <br><br>';
    
    $db->exec("SET NAMES 'UTF-8'");      // config du charset 
	
}
catch(PDOException $e)
{
	echo $e->getMessage();
}
     



?>