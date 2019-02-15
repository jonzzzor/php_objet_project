<?php
require_once('Session.class.php');
require_once('Connexion.class.php');
class Authentification
{
    private static $instance;
    protected $db;

    private function __construct()
    {
        echo "<p>création de l'instance d'authentification </p>\n";
    }

    private function __destruct()
    {
        echo "<p>destruction de l'instance d'authentification</p>\n";
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
            self::$instance->connexionDB();
        }
        // echo "<p>appel de l'instance d'authentification</p>\n";

        return self::$instance;
    }

    public function connexionDB()
    {
        $hostname = 'localhost';
        $dbname = 'site_multimedia';
        $username = 'root';
        $password = 'root';

        try {
            /*** echo a message saying we have connected ***/
            $this->db = new PDO("mysql:host=$hostname;dbname=$dbname", $username, $password);
            echo 'Connected to database <br><br>';

            $this->db->exec("SET NAMES 'UTF-8'");      // config du charset
            var_dump($this->db);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }


    public function checkUser($user, $pass)
    {
        $db = Connexion::getInstance()->getDb();
        $query = $db->prepare("SELECT users.id FROM users WHERE users.nom=? AND users.passwd=?");
        // On vérifie le mot de passe ET le login.
        // Penser à rajouter le HASHING http://php.net/manual/fr/function.md5.php
        $query->execute(array($user, $pass));
        $result_query = $query->fetch(PDO::FETCH_ASSOC);
        // var_dump($result_query);
        if (isset($result_query['id'])) {
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
        Session::killInstance();
    }


    public static function killInstance()
    {
        self::$instance = null;
    }
}


$resultat = Authentification::getInstance()->checkUser('jon', 'password1');
echo "résultat de l'authentification : $resultat <br/>";
echo "résultat de l'authentification avec isAuth : ".Authentification::getInstance()->isAuth()."<br/>";
printf("id : %s<br/>\n", Session::getInstance()->getUserId());
printf("nom : %s<br/>\n", Session::getInstance()->getUserNom());
printf("password : %s<br/>\n", Session::getInstance()->getUserPasswd());

Authentification::getInstance()->disconnect();
echo "résultat de l'authentification avec isAuth apres déconnexion : ".Authentification::getInstance()->isAuth()."<br/>";
printf("id : %s<br/>\n", Session::getInstance()->getUserId());
printf("nom : %s<br/>\n", Session::getInstance()->getUserNom());
printf("password : %s<br/>\n", Session::getInstance()->getUserPasswd());


//Session::killInstance();
