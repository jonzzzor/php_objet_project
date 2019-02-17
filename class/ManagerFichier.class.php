<?php

class ManagerFichier
{
    public function write_data($file, $description, $user_id)
    {
        $dest_dir = './application/multimedia';
        $new_folder_extension = $this->getFolderName($this->getExtension($file['name']));
        if ($new_folder_extension == '') {
            throw new Exception('Type de fichier incorrect.');
            return false;
        }
        $new_name= $new_folder_extension.microtime().'.'.$this->getExtension($file['name']);
        $new_name_nospace = preg_replace('/\s+/', '', $new_name);
        $new_location = $dest_dir.'/'.$new_folder_extension.'/'.$new_name_nospace;
        if (isset($file['error']) && UPLOAD_ERR_OK === $file['error']) {
            if (@move_uploaded_file($file['tmp_name'], $new_location)) {
                $tab_assoc = array();
                $tab_assoc['chemin_relatif'] = $new_name_nospace;
                $tab_assoc['mime_type'] = $file['type'];
                $tab_assoc['description'] = $description;
                $tab_assoc['auteur_id'] = $user_id;
                return $tab_assoc;
            } else {
                throw new Exception("Erreur lors de l'écriture du fichier, vérifiez les droits d'accès.");
                // $message = sprintf(
                //             "Une erreur interne est survenue lors de la récupération du fichier <samp>%s</samp> (<em>%s</em>).<br/>".
                //             "<p>message : <code>%s</code><br/>",
                //             $file['tmp_name'],
                //             $new_name,
                //             join("<br/>\n", error_get_last())
                //             );
                // echo $message;
                return false;
            }
        } else {
            throw new Exception("Erreur survenue lors de la récupération du fichier.");
            // $message = 'Une erreur interne a empêché l\'upload de l\'image : '. $file['error'];
            // printf('message : %s', $message);
            return false;
        }
    }

    // Controle type de file
    private function getExtension($filename)
    {
        if (preg_match('/(.+)\.(.+)$/i', $filename, $reg)) {
            return strtolower($reg[2]);
        }
    }

    // Répartition type de fichier
    private function getFolderName($extension)
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
  
        return $rangement;
    }
}
