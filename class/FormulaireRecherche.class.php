<?php

class FormulaireRecherche
{
    private $autor;
    private $desc;
    private $audioSelected;
    private $imageSelected;
    private $videoSelected;


    public function __construct($p_autor = '', $p_desc = '', $p_audioSelected = 'checked', $p_imageSelected = 'checked', $p_videoSelected= 'checked')
    {
        $this->autor=$p_autor;
        $this->desc=$p_desc;
        $this->audioSelected=$p_audioSelected;
        $this->imageSelected=$p_imageSelected;
        $this->videoSelected=$p_videoSelected;
    }


    public function showForm()
    {
        echo "
        <div class='container'>
            <!-- Informations sortantes-->
                <div class='col-md-6'>
                    <div class='form-group'>
                        <fieldset>
                            <form method='get' action='#'>

                              <input type='hidden' name='etape' value='2'>

                              <label for='form_autor'>Auteur</label>
                              <input type='text' id='form_autor' name='form_autor' value=$this->autor><br>

                              <input type='checkbox' name='audio_checkbox' value='checked' $this->audioSelected>Audio<br>
                              <input type='checkbox' name='image_checkbox' value='checked' $this->imageSelected>Image<br>
                              <input type='checkbox' name='video_checkbox' value='checked' $this->videoSelected>Video<br>

                              <label for='form_desc'>Description</label>
                              <input type='text' id='form_desc' name='form_desc' maxlength='50' value=$this->desc><br>

                              <input type='submit' value='Rechercher'>

                            </form>
                        </fieldset>
                    </div>
                </div>
            </div>";
    }

    public function getResponse()
    {
        $array = array();
        if (isset($_GET['form_autor']) && isset($_GET['form_desc'])) {
            $this->autor = htmlspecialchars($_GET['form_autor'] ?? '');
            $this->desc = htmlspecialchars($_GET['form_desc'] ?? '');
            $this->audioSelected = htmlspecialchars($_GET['audio_checkbox'] ?? '');
            $this->videoSelected = htmlspecialchars($_GET['video_checkbox'] ?? '');
            $this->imageSelected = htmlspecialchars($_GET['image_checkbox'] ?? '');

            $array['form_autor'] = $this->autor;
            $array['form_desc'] = $this->desc;
            $array['audio_checkbox'] = $this->audioSelected;
            $array['video_checkbox'] = $this->videoSelected;
            $array['image_checkbox'] = $this->imageSelected;
        }
        return $array;
    }
}



//Session::killInstance();
