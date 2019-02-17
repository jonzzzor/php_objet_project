<?php

class FormulaireAffichageDocument
{
    public function __construct()
    {
    }


    public function showForm($array_document)
    {
        $mime_type=$array_document['mime_type'] ?? '';
        $chemin_relatif = $array_document['chemin_relatif'] ?? '';
        $description= $array_document['description'] ?? '';

        preg_match('/(.+)\.(.+)$/i', $chemin_relatif, $name);
        preg_match('/(.+)\/(.+)$/i', $mime_type, $reg);
        $documentLocation = './application/multimedia/'.$reg[1].'/'.$chemin_relatif;

        echo "<div class='container'>
                <div class='card text-center'>
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
                                    <div class='container'>
                                        <div class='alert alert-warning' role='alert'>Votre navigateur ne supporte pas le lecteur audio.</div>
                                    </div>
                                    </audio>";
                break;
                case 'video': echo "<video controls width='1000'>
                                    <source src=$documentLocation type=$mime_type />
                                    <div class='container'>
                                        <div class='alert alert-warning' role='alert'>Votre navigateur ne supporte pas le lecteur vidéo.</div>
                                    </div>
                                    </video>";
                break;
                default:   throw new Exception("Le format de fichier n'est pas reconnu.");
        }


        //Affichage de la description raccourcie + de ce qui permet de la déplier
        if (strlen($description)>=10) {
            echo "</div>
            <div class='card-footer text-muted'>".$this->shortenDescription($description)."</div></div></div></div>";
        } else {
            echo "<div class='card-footer text-muted'>".$description."</div></div></div></div></div>";
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
