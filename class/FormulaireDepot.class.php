<?php

class FormulaireDepot
{
    public function __construct()
    {
    }


    public function showForm()
    {
        echo "
        <div class='container'>
            <fieldset class='form-group'>
                <div class='offset-3 col-md-6'>
                    <div class='form-group'>
                    <form method='post' action='#' id='data_upload' enctype='multipart/form-data'><br/>
                        <input type='file' name='file_upload' class='form-control-file'/><br/>
                        <legend class='form-text text-muted'>Formats autorisés : .webm, .gif, .jpeg, .jpg, .png, .svg ou .ogg</legend><br/>
                    </div>
                    <div class='form-group'>
                        <input type='textarea' name='description' placeholder='Description' class='form-control'/><br/>
                    </div>
                    <button type='submit' name='send_file' value='click' class='btn btn-primary'>ENVOYER</button><br/>
                    </form>
                </div>
            </fieldset>
        </div>";
    }

    public function getResponse()
    {
        $array = array();

        $send_file = htmlspecialchars($_POST['send_file'] ?? '');
        if ($send_file == 'click') {
            if (isset($_FILES['file_upload']) && $_FILES['file_upload']['name'] != '') {
                $array['file_upload'] = $_FILES['file_upload'];
            } else {
                throw new Exception("Fichier manquant.");
                return false;
            }
            if (isset($_POST['description']) && $_POST['description'] != '') {
                $array['description'] = htmlspecialchars($_POST['description'] ?? '');
            } else {
                throw new Exception("Description manquante.");
                return false;
            }
        }
        return $array;
    }
}
