<?php

require_once("connexion_database.php");

 function filtreDonneesDeUtilisateur($data)
 {
     $data = filter_var($data, FILTER_SANITIZE_SPECIAL_CHARS);
     return $data;
 }

 function rechercheDocument($p_autor, $p_desc, $p_audioSelected, $p_videoSelected, $p_imageSelected)
 {
     global $db;

     //ON RECUPERE ET FILTRE LES PARAMETRES D'ENTREES
     $nomRecherche = '%'.filtreDonneesDeUtilisateur($p_autor).'%';
     $description = '%'.filtreDonneesDeUtilisateur($p_desc).'%';
     $audioSelected = filtreDonneesDeUtilisateur($p_audioSelected);
     $videoSelected = filtreDonneesDeUtilisateur($p_videoSelected);
     $imageSelected = filtreDonneesDeUtilisateur($p_imageSelected);


     //ON CREER LA PARTIE DE LA REQUETE COCNERNANT LA CHECKBOX
     $request_checkbox = ' AND (';
     $isFirstSelected = true;
     if (isset($audioSelected) && $audioSelected === 'checked') {
         $request_checkbox .=  "datas.mime_type LIKE 'audio%'";
         $isFirstSelected = false;
     }
     if (isset($videoSelected) && $videoSelected === 'checked') {
         if (!$isFirstSelected) {
             $request_checkbox .=  " OR ";
         }
         $request_checkbox .=  "datas.mime_type LIKE 'video%'";
         $isFirstSelected = false;
     }
     if (isset($imageSelected) && $imageSelected === 'checked') {
         if (!$isFirstSelected) {
             $request_checkbox .=  " OR ";
         }
         $request_checkbox .=  "datas.mime_type LIKE 'image%'";
         $isFirstSelected = false;
     }
     $request_checkbox .= ') ';

     if ($isFirstSelected) {
         $request_checkbox =  "";
     }
     //REQUETE PREPAREE SQL
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
                            $request_checkbox
                            ");
     $result->execute(array($nomRecherche, $description));

     $resultArray = array();
     //TRAITEMENT DE LA REQUETE
     if ($result != false) {
            while ($row = $result->fetch()) {
            array_push($resultArray, $row);
            
            
            /*
            $tempArray = array();
             $tempArray['idData']=$row['idData'];
            $tempArray['chemin_relatif']=$row['chemin_relatif'];
            
             echo "<br>Chemin relatif : " . $row['chemin_relatif']."<br>";
             echo "<br>Mime-type : " . $row['mime_type']."<br>";
             echo "<br>Description : " . $row['description']."<br>";
             echo "<br>Date : " . $row['date']."<br>";
             echo "<br> Nom de l'utilisateur : " .$row['nom']."<br>";
             echo "<br/>";
             */
         }
     }
     return $resultArray;
 }