<?php

class FormulaireRechercheRadioButton
{
    public function __construct()
    {
    }
    public function showForm($resultRecherche)
    {
        $countResult = count($resultRecherche);
        if ($countResult == 0) {
            return false;
        }


        echo "<div class='container'>
                  <!-- Informations entrantes-->
                      <div class='offset-3 col-md-6'>
                          <div class='alert alert-info' role='alert'>Veuillez sélectionner un résultat :</div>
                              <div class='form-group'>
                                  <fieldset class='form-group'><form method='get' action='#'>
                                        <input class='form-control' id='form_multimedia' type='hidden' name='etape' value='3'>";

        for ($i=0; $i<$countResult; $i++) {
            $tempArray = $resultRecherche[$i];
            $tempNomAuteur = $tempArray['nom'];
            $tempDescription = $tempArray['description'];
            $tempIdData = $tempArray['idData'];
            $tempTypeMime = $tempArray['mime_type'];

            echo "  <div class='input-group mb-3'>
                        <div class='input-group-prepend'>
                            <div class='input-group-text'>
                            <input type='radio' id='radioresult'.$i name='idData' value=$tempIdData>
                            </div>
                            <label for='radioresult' class='input-group-text'><span><em>$tempTypeMime</em> (<strong>$tempNomAuteur</strong>) : <em>$tempDescription</em><span></label>
                        </div>
                    </div>";
        }
        echo "
                                    <div>
                                      <button class='btn btn-primary' type='submit'>Envoyer</button>
                                    </div>
                                </form>
                          </fieldset>
                      </div>
                  </div>
              </div>";
    }

    public function getResponse()
    {
        $array = array();
        if (isset($_GET['idData']) && isset($_GET['idData'])) {
            $array['idData'] = htmlspecialchars($_GET['idData'] ?? '');
        }
        return $array;
    }
}
