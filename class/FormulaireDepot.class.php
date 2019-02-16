<?php
 
class FormulaireDepot
{
 
  public function __construct() {
  }


    public function showForm()
    {
        echo "
        <div class='container'>
            <form method='post' action='#' id='data_upload' enctype='multipart/form-data'><br/>
                <div class='col-md-6-'>
                    <div class='form-group'>
                        <input type='file' name='file_upload' class='form-control-file'/><br/>
                        <legend class='form-text text-muted'>Formats autorisés : .webm, .gif, .jpeg, .jpg, .png, .svg ou .ogg</legend><br/>
                    </div>
                    <div class='form-group'>
                        <input type='textarea' name='description' placeholder='Description' class='form-control'/><br/>
                    </div>
                    <button type='submit' name='send_file' value='click' class='btn btn-primary'>ENVOYER</button><br/>
                </div>
            </form>
        </div>";

    }

    public function getResponse()
    {
        $array = array();
        $send_file = htmlspecialchars($_POST['send_file'] ?? '');
        if ($send_file == 'click') {
            if(isset($_FILES['file_upload']) && $_FILES['file_upload']['name'] != ''){
                $array['file_upload'] = $_FILES['file_upload'];
            }else{
                echo "FICHIER MANQUANT<br/>";
                return false;
            }
            if(isset($_POST['description']) && $_POST['description'] != ''){
                $array['description'] = htmlspecialchars($_POST['description'] ?? '');
            }else{
                echo "DESCRIPTION MANQUANTE<br/>";
                
            }
        }
        return $array;
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