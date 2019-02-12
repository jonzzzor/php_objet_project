<?php

require_once("connexion_database.php");
 

//count table
$result = $db->query("SELECT nom as nomUser, passwd as passUser from users"); 
if ($result != false) 
{ 
    
    while ($row = $result->fetch()) 
    {
              echo "<br>Nom de l'utilisateur : " . $row['nomUser']."<br>";
              echo "<br>Mot de passe de l'utilisateur : " . $row['passUser']."<br>";
    }  
} 

//
$nomRecherche='adeline';
$description='%image%';

//count table
$result = $db->prepare("SELECT datas.id AS idData,
                        datas.chemin_relatif AS chemin_relatif,
                        datas.mime_type AS mime_type,
                        datas.description AS description,
                        datas.date AS date,
                        users.nom AS nom
                        FROM datas,users
                        WHERE datas.auteur_id = users.id
                        AND users.nom LIKE ?
                        AND datas.description LIKE ?
                        "); 

$result->execute(array($nomRecherche, $description));

if ($result != false) 
{ 
    
    while ($row = $result->fetch()) 
    {

              echo "<br>Id : " . $row['idData']."<br>";
              echo "<br>Chemin relatif : " . $row['chemin_relatif']."<br>";
              echo "<br>Mime-type : " . $row['mime_type']."<br>";
              echo "<br>Description : " . $row['description']."<br>";
              echo "<br>Date : " . $row['date']."<br>";
              echo "<br> Nom de l'utilisateur : " .$row['nom']."<br>";
              echo "<br/>";
    }  
} 

?>