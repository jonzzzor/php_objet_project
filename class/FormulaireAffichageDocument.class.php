<?php

class FormulaireAffichageDocument
{
    public function __construct()
    {
    }


    public function showForm($array_document)
    {
        //echo '<pre>'; print_r($document); echo '</pre>';

        $mime_type=$array_document['mime_type'] ?? '';
        $chemin_relatif = $array_document['chemin_relatif'] ?? '';
        $description= $array_document['description'] ?? '';

        preg_match('/(.+)\.(.+)$/i', $chemin_relatif, $name);
        preg_match('/(.+)\/(.+)$/i', $mime_type, $reg);
        $documentLocation = './application/multimedia/'.$reg[1].'/'.$chemin_relatif;

        echo "<div class='card text-center'>
                  <div class='card-header'>
                      $name[1]
                        </div>
                          <div class='card-body'>";

        //echo '<pre>'; print_r($reg); echo '</pre>';
        switch ($reg[1]) {
                case 'image': echo "<img src='$documentLocation' alt='Image sélectionnée' />";
                break;
                case 'audio': echo "<audio controls='controls'>
                        <source src=$documentLocation type=$mime_type />
                        Votre navigateur ne supporte pas le lecteur audio.
                      </audio>";
                break;
                case 'video': echo "<video controls width='1000'>
                        <source src=$documentLocation type=$mime_type>
                        Votre navigateur ne supporte pas le lecteur vidéo.
                    </video>";
                break;
                default: echo 'erreur format inconnu';
        }


        //Affichage de la description raccourcie + de ce qui permet de la déplier
        if (strlen($description)>=10) {
            echo "</div>
            <div class='card-footer text-muted'>".self::shortenDescription($description)."</div></div></div></div>";
        } else {
            echo "<div class='card-footer text-muted'>".$description."</div></div></div></div>";
        }
    }

    //Création d'une fonction pour raccourcir la description à 6 mots
    private function shortenDescription($description)
    {
        $description_array = explode(' ', $description);
        if (count($description_array) > 6) {
            $description = implode(' ', array_slice($description_array, 1, 6)).'...';
        }
        return $description;
    }
}



//Session::killInstance();
