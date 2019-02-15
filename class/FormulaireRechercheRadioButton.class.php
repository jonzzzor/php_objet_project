<?php
 
class FormulaireRechercheRadioButton
{

    
  public function __construct() {
  }


    public function showForm($resultRecherche)
    {
        $countResult = count($resultRecherche);
        if($countResult == 0)
        {
            return false;
        }
        
        
        echo "<form method='get' action='#'>
                <input type='hidden' name='etape' value='3'>";
            for ($i=0; $i<$countResult; $i++) {
                $tempArray = $resultRecherche[$i];
                $tempNomAuteur = $tempArray['nom'];
                $tempDescription = $tempArray['description'];
                $tempIdData = $tempArray['idData'];
                $tempTypeMime = $tempArray['mime_type'];
                echo "
                <div> 
                    <input type='radio' id='radioresult'.$i name='idData' value=$tempIdData>
                    <label for='radioresult'>[Auteur : $tempNomAuteur] / [Description : $tempDescription] / [Type : $tempTypeMime]</label>
                </div>";
            }

            echo "
            <div>
                <button type='submit'>Envoyer</button>
            </div>
        </form>";

    }
    
     public function getResponse()
    {
        $array = array();
        if(isset($_GET['idData']) && isset($_GET['idData']))
        { 
            $array['idData'] = htmlspecialchars($_GET['idData'] ?? '');  
        }
        return $array;
    }

}


 
//Session::killInstance();
