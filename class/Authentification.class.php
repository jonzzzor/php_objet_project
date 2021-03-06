<?php

class Authentification
{
    private static $instance;
    private $grainDeSel = 'alloallo';

    private function __construct()
    {
        // echo "<p>création de l'instance d'authentification </p>\n";
    }

    public function __destruct()
    {
        // echo "<p>destruction de l'instance d'authentification</p>\n";
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        // echo "<p>appel de l'instance d'authentification</p>\n";

        return self::$instance;
    }

    public function hashing($string_pwd)
    {
        $passwd_clr = htmlspecialchars($string_pwd);
        $passHashed = md5($passwd_clr.$this->grainDeSel);
        return $passHashed;
    }

    public function checkUser($user = '', $pass = '')
    {
        $user = htmlspecialchars($user);
        $pass = htmlspecialchars($pass);

        $db = Connexion::getInstance()->getDb();
        $query = $db->prepare("SELECT users.id FROM users WHERE users.nom=? AND users.passwd=?");
        // On vérifie le mot de passe ET le login.
        // Penser à rajouter le HASHING http://php.net/manual/fr/function.md5.php
        $query->execute(array($user, $pass));
        $result_query = $query->fetch(PDO::FETCH_ASSOC);
        // var_dump($result_query);
        if (isset($result_query['id'])) {
            $this->disconnect();
            Session::getInstance($result_query['id'], $user, $pass);
            return true;
        } else {
            return false;
        }
    }

    public function isAuth()
    {
        if ($this->checkUser(Session::getInstance()->getUserNom(), Session::getInstance()->getUserPasswd())) {
            return true;
        } else {
            return false;
        }
    }

    public function disconnect()
    {
        Session::getInstance()->killInstance();
    }


    public static function killInstance()
    {
        self::$instance = null;
    }
}


// $resultat = Authentification::getInstance()->checkUser('jon', 'password1');
// echo "résultat de l'authentification : $resultat <br/>";
// echo "résultat de l'authentification avec isAuth : ".Authentification::getInstance()->isAuth()."<br/>";
// printf("id : %s<br/>\n", Session::getInstance()->getUserId());
// printf("nom : %s<br/>\n", Session::getInstance()->getUserNom());
// printf("password : %s<br/>\n", Session::getInstance()->getUserPasswd());
//
// Authentification::getInstance()->disconnect();
// echo "résultat de l'authentification avec isAuth apres déconnexion : ".Authentification::getInstance()->isAuth()."<br/>";
// printf("id : %s<br/>\n", Session::getInstance()->getUserId());
// printf("nom : %s<br/>\n", Session::getInstance()->getUserNom());
// printf("password : %s<br/>\n", Session::getInstance()->getUserPasswd());


//Session::killInstance();
