<?php
 
class FormulaireAuthentification
{
 
    public function __construct() {
  }


    public function showForm()
    {
        $button_connect_disconnect ="";
        if (Authentification::getInstance()->isAuth()) { 

            //echo "<p>Bienvenue ". SESSION::getInstance()->getUserNom()."</p>";
            
            $accueil = "<div class='col-md-3'>
            <a href='index.php'><input class='btn btn-secondary' type='button' value='Accueil'></a>       
            </div>
            <div class='col-md-3'>
            <a href='depot.php'><input class='btn btn-outline-secondary' type='button' value='Dépôt'></a>                             
            </div>";
            $depot = "<div class='col-md-3'>
            <a href='index.php'><input class='btn btn-outline-secondary' type='button' value='Accueil'></a>       
            </div>
            <div class='col-md-3'>
            <a href='depot.php'><input class='btn btn-secondary' type='button' value='Dépôt'></a>                             
            </div>";
            $adress = $_SERVER['PHP_SELF'];
            preg_match('/(.+)\/(.+\.php)$/', $adress, $page);
            echo " 
            <div class='container navbar_perso'>
                <nav class='navbar navbar-light bg-dark'>
                    <p class='text_welcome_user'>Bienvenue ". SESSION::getInstance()->getUserNom()."</p>
                    <form action='#' class='form-inline ml-auto' method='POST'>";
                        if($page[2] == 'index.php'){
                            echo $accueil;
                        }else{
                            echo $depot;
                        }
                        echo "<div class='col-md-4'>
                            <input type='hidden' name='session_destroy' value='1'>
                            <input class='btn btn-primary' type='submit' value='Se déconnecter'> 
                        </div>
                    </form>
                </nav>
            </div>
            
        ";
        }
        else {  
            echo "
            <div class='container navbar_perso'>
            <nav class='navbar navbar-light bg-dark'>
    
                <form action='#' class='form-inline ml-auto' method='POST'>
    
                    <div class='input-group col-md-4'> 
                        <input type='text' class='form-control' placeholder='Login' name='nom' aria-describedby='basic-addon1' required>
                    </div>
                    <div class='input-group col-md-4'> 
                        <input type='password' class='form-control' name='passwd' placeholder='Password' aria-describedby='basic-addon1'  required>
                    </div>
    
                    <div class='col-md-4'>
                        <input class='btn btn-primary' type='submit' value='Se connecter'> 
                    </div>
                </form>
            </nav>
        </div>";
        }

       

    }

    public function getResponse()
    {
        $array = array(); 

        if (isset($_POST['passwd']) && isset($_POST['nom'])) {
            $array['user'] = $_POST['nom'];
            $array['passwd'] = $_POST['passwd'];
            return $array;
        }
        else if(isset($_POST['session_destroy'])){
            $array['session_destroy'] = $_POST['session_destroy'];
            return $array;
        }
        else {
            return false;
        }
    }
}