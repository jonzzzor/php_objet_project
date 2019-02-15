<?php
 
class FormulaireDepot
{
 
  public function __construct() {
  }


    public function showForm()
    {
        echo "
        <form method='post' action='#' id='data_upload' enctype='multipart/form-data'><br/>
            <input type='file' name='file_upload'/><br/>
            <legend>Formats autorisés : .webm, .gif, .jpeg, .jpg, .png, .svg ou .ogg</legend><br/>
            <input type='textarea' name='description' placeholder='Description'/><br/>
            <button type='submit' name='send_file' value='click'>ENVOYER</button><br/>
        </form>";

    }

    public function getResponse()
    {
        $array = array();
        if(isset($_GET['idData']) && isset($_GET['idData']))
        { 
            //$array['idData'] = htmlspecialchars($_GET['idData'] ?? '');  
            $array['file_upload'] = $_FILES['file_upload'];
            $array['description'] = htmlspecialchars($_POST['description'] ?? '');
            
        }
        return $array;
    }

    // Contrôle remplissage des champs
private function control_remplissage_champ($champ)
{
    if ($champ !== '') {
        echo "CONTROLE_REMPLISSAGE_CHAMP : ".$champ."<br/>";
        return true;
    } else {
        echo "CONTROLE_REMPLISSAGE_CHAMP : champ vide<br/>";
        return false;
    }
}

// Contrôle type de file
private function control_type_file($file)
{
    if (preg_match('/(.+)\.(.+)$/i', $file['name'], $reg)) {
        // var_dump($reg);
        // echo("EXTENSION FICHIER : $reg[2]<br/>");
        return strtolower($reg[2]);
    }
}

// Répartition type de fichier
private function check_type_extension($extension)
{
    switch ($extension) {
        case 'webm': $rangement = 'video';
        break;
        case 'gif':
        case 'jpeg':
        case 'jpg':
        case 'png':
        case 'svg': $rangement = 'image';
        break;
        case 'ogg': $rangement = 'audio';
        break;
        default: $rangement = '';
    }
    // echo "RANGEMENT FILE DANS : $rangement<br/>";
    return $rangement;
}
    
     

}


 
//Session::killInstance();