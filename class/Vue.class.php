<?php


class Vue
{
    public function showHeader()
    {
        $header = "<!DOCTYPE html>

                    <html xmlns='http://www.w3.org/1999/xhtml' lang='fr'>

                    <head>
                        <title>Mutimedia</title>
                        <!-- meta http-equiv='Content-Type' content='application/xhtml+xml; charset=utf-8'/ -->

                        <!-- Required meta tags -->
                        <meta charset='utf-8'>
                        <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>

                        <!-- Bootstrap CSS -->
                        <link rel='stylesheet' href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.0/css/bootstrap.min.css' integrity='sha384-PDle/QlgIONtM1aqA2Qemk5gPOE7wFq8+Em+G/hmo5Iq0CCmYZLv3fVRDJ4MMwEA'
                            crossorigin='anonymous'>

                        <link rel='stylesheet' type='text/css' media='all' href='./css/style.css' />

                    </head>

                    <body>

                        <!--HEADER-->
                        <header class='container-fluid' id='header'>
                            <div class='container'>
                                <div class='row'>
                                    <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
                                        <!--<a href='#' target='blank'>
                                            <div id='imgTop'> </div>
                                        </a>-->
                                        <h1>GENERATEUR MULTIMEDIA</h1>
                                    </div>
                                </div>
                            </div>
                        </header>";
        printf("%s", $header);
    }


    public function showFormAuth()
    {

        /*********************************/
        /*      AUTHENTIFICATION         */
        /*********************************/

        //ON RECUPERE LA SESSION SI ELLE EXISTE
        /*
        if(isset($_SESSION["SessionUser"]) && $_SESSION["SessionUser"] instanceof SESSION){
            $session = $_SESSION["SessionUser"];
            SESSION::setInstance($session);
        }
        */


        //ON RECUPERE LA REPONSE DU FORMULAIRE DE CONNEXION
        $form_auth = new FormulaireAuthentification();
        $array_auth = $form_auth->getResponse();

        //SI USER && MDP EXISTE _ ON VERIFIE L'AUTHENTIFICATION
        if ($array_auth && isset($array_auth['user']) && isset($array_auth['passwd'])) {
            $resultat_auth = Authentification::getInstance()->checkUser($array_auth['user'], $array_auth['passwd']);
            if ($resultat_auth) {
                // echo "Bienvenue ". SESSION::getInstance()->getUserNom()." <br/>";
                // echo "Vous êtes connecté ! <br/>";
            } else {
                echo "login/mdp invalide <br/>";
            }
        }
        //SINON SI DEMANDE DE DECONNEXION
        elseif ($array_auth && isset($array_auth['session_destroy'])) {
            Authentification::getInstance()->disconnect();
        }

        //ON AFFICHE LE FORMULAIRE DE CONNEXION EN CONSEQUENCE
        $form_auth->showForm();
    }

    public function showFormSrch()
    {
        /*********************************/
        /*      FORMULAIRE RECHERCHE     */
        /*********************************/


        //AFFICHAGE DU FORMULAIRE DE RECHERCHE
        //on crée l'instance
        $form_recherche = new FormulaireRecherche();
        //si formulaire déja rempli, on recupèere les infos du dernier formulaire
        $array_response = $form_recherche->getResponse();
        //on affiche le formulaire
        $form_recherche->showForm();
        return $array_response;
    }

    public function showFormSrchBtn($param_result_srch)
    {
        $form_recherche_radioButton = new FormulaireRechercheRadioButton();
        $form_recherche_radioButton->showForm($param_result_srch);
    }

    public function showMediaContent()
    {
        //on crée l'instance
        $form_recherche_radioButton = new FormulaireRechercheRadioButton();
        //si formulaire déja rempli, on recuprere les info du derniers formulaire
        $array_response = $form_recherche_radioButton->getResponse();
        $idData = '';

        //SI RESULTAT UNIQUE
        if (count($array_response)==0 && count($_SESSION['resultatRecherche'] ?? array())==1) {
            $idData=$_SESSION['resultatRecherche'][0]['idData'];
        }
        //SI RESULTAT MULTIPLE
        elseif (count($array_response)>0 && count($_SESSION['resultatRecherche'] ?? array())>0) {
            $idData = $array_response['idData'] ?? '';
        }

        if ($idData != '') {
            foreach ($_SESSION['resultatRecherche'] as $array_document) {
                if ($idData === $array_document['idData']) {
                    //on creer l'instance
                    $form_affichage = new FormulaireAffichageDocument();
                    //si affiche le formulaire
                    $form_affichage = $form_affichage->showForm($array_document);
                }
            }
        } else {
            echo "Le document n'existe pas";
        }
    }

    public function showFormDepot()
    {

        /*********************************/
        /*      FORMULAIRE DEPOT     */
        /*********************************/

        //AFFICHAGE DU FORMULAIRE DE DEPOT
        //on crée l'instance
        $form_depot = new FormulaireDepot();
        //si formulaire déja rempli, on recupèere les infos du dernier formulaire
        $array_depot = $form_depot->getResponse();
        //on affiche le formulaire
        //
        $form_depot->showForm();
        if ($array_depot) {
            $file = $array_depot['file_upload'];
            $description = $array_depot['description'];
            $user_id = 1; // A RECUP DANS FORM JONHATHAN
            $manager_fichier = new ManagerFichier();
            $recup_adress = $manager_fichier->write_data($file, $description, $user_id);
            $manager_db = new DbSearch();
            $manager_db->write_table($recup_adress);
        }
    }

    public function showFooter()
    {
        $footer = "<!-- FOOTER START-->
      <footer class='text-center'>
          <div class='container'>
              <hr>
              <p>Adeline, Christophe, Jonathan et Thierry</p>
          </div>
      </footer>
      <!-- FOOTER END-->

      </body>

      </html>";
        printf("%s", $footer);
    }
}
