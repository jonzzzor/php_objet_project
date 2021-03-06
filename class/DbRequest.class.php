<?php

class DbRequest
{
    public function __construct()
    {
    }

    public function rechercheDocument($autor, $desc, $p_audioSelected, $p_videoSelected, $p_imageSelected)
    {
        $dbh = Connexion::getInstance()->getDb();

        //ON RECUPERE ET FILTRE LES PARAMETRES D'ENTREES
        $nomRecherche = '%'.htmlspecialchars($autor).'%';
        $description = '%'.htmlspecialchars($desc).'%';
        $audioSelected = htmlspecialchars($p_audioSelected);
        $videoSelected = htmlspecialchars($p_videoSelected);
        $imageSelected = htmlspecialchars($p_imageSelected);


        //ON CREER LA PARTIE DE LA REQUETE CONCERNANT LA CHECKBOX
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
        $result = $dbh->prepare("SELECT datas.id AS idData,
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
            }
        }
        return $resultArray;
    }

    public function write_table($result_tab_write)
    {
        $chemin_relatif = htmlspecialchars($result_tab_write['chemin_relatif']);
        $mime_type = htmlspecialchars($result_tab_write['mime_type']);
        $description = htmlspecialchars($result_tab_write['description']);
        $auteur_id = htmlspecialchars($result_tab_write['auteur_id']);

        $dbh = Connexion::getInstance()->getDb();

        $query_insert = $dbh->prepare("INSERT INTO datas (chemin_relatif, mime_type, description, auteur_id) VALUES (?, ?, ?, ?)");
        $result = $query_insert->execute(array($chemin_relatif, $mime_type, $description, $auteur_id));

        if (!$result) {
            throw new Exception("L'insertion dans la table a échoué.");
            return false;
        } else {
            echo '<div class="container"><div class="alert alert-success" role="alert">Fichier ajouté avec succès !</div></div>';
            return true;
        }
    }
}
