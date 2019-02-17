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
                <div class='offset-3 col-md-6'>
                    <div class='form-group'>
                        <fieldset>
                            <form method='get' action='#'>

                              <input class='form-control' type='hidden' name='etape' value='2'>

                              <label for='form_autor'>Auteur</label>
                              <input class='form-control' type='text' id='form_autor' name='form_autor' value=$this->autor><br>

                              <div class='input-group mb-3'>
                                <div class='input-group-prepend'>
                                  <div class='input-group-text'>
                                    <input name='audio_checkbox' type='checkbox' value='checked' id='customCheck1' $this->audioSelected>
                                  </div>
                                </div>
                                <label class='input-group-text' for='customCheck1'>Audio</label>
                              </div>

                              <div class='input-group mb-3'>
                                <div class='input-group-prepend'>
                                  <div class='input-group-text'>
                                    <input name='image_checkbox' type='checkbox' value='checked' id='customCheck1' $this->imageSelected>
                                  </div>
                                </div>
                                <label class='input-group-text' for='customCheck1'>Image</label>
                              </div>

                              <div class='input-group mb-3'>
                                <div class='input-group-prepend'>
                                  <div class='input-group-text'>
                                    <input name='video_checkbox' type='checkbox' value='checked' id='customCheck1' $this->videoSelected>
                                  </div>
                                </div>
                                <label class='input-group-text' for='customCheck1'>Video</label>
                              </div>


                              <label for='form_desc'>Description</label>
                              <input class='form-control' type='text' id='form_desc' name='form_desc' maxlength='50' value=$this->desc><br>

                              <input class='form-control btn btn-dark' type='submit' value='Rechercher'>

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
