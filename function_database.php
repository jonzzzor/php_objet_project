<?php

require_once("connexion_database.php");
 

//count table
$result = $db->query("SELECT count(*) as count_pays from pays"); 
if ($result != false) 
{ 
    while ($row = $result->fetch()) 
    {
        echo "<br>Nombre de pays ajoutés à la table : " . $row['count_pays']."<br>";
    }  
} 

?>