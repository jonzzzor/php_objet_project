<?php

class DbSearch
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
}
