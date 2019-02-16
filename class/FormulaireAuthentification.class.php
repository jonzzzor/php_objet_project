<?php
 
class FormulaireAuthentification
{
 
    public function __construct() {
  }


    public function showForm()
    {
        echo "
        <div class='container navbar_perso'>
        <nav class='navbar navbar-light bg-dark'>

            <form action='#' class='form-inline ml-auto' method='POST'>

                <div class='input-group col-md-4'>
                    <div class='input-group-prepend'>
                        <span class='input-group-text' id='basic-addon1'>Login</span>
                    </div>
                    <input type='text' class='form-control' placeholder='username' name='nom' aria-describedby='basic-addon1'>
                </div>
                <div class='input-group col-md-4'>
                    <div class='input-group-prepend'>
                        <span class='input-group-text' id='basic-addon1'>Password</span>
                    </div>
                    <input type='password' class='form-control' name='passwd' aria-describedby='basic-addon1'>
                </div>

                <div class='col-md-4'>
                    <input class='btn btn-primary' type='submit' value='Submit'>
                    <a href='' class='btn btn-outline-danger'>Sign out</a>
                </div>
            </form>
        </nav>
    </div>";

    }

    public function getResponse()
    {
        $array = array();
        $user = $_POST['nom'];
        $passwd = $_POST['passwd'];

        if (isset($user) && isset($passwd)) {
            $array['user'] = $user;
            $array['passwd'] = $passwd;
            return $array;
        }
        else {
            return false;
        }
    }
}