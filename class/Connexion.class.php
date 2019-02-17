<?php

class Connexion
{
    private $host = 'localhost';
    private $dbname = 'site_multimedia';
    private $user = 'root';
    private $mdp = 'root';
    private static $instance_db;
    private $dbh;

    private function __construct()
    {
        // echo '<br/>from constructeur : connexion à la base de donnée.<br/>';
    }

    public static function getInstance()
    {
        if (!self::$instance_db) {
            self::$instance_db = new self();
            self::$instance_db->connectToDb();
        }
        // echo '<br/>from getInstance : instanciation lancée.';
        return self::$instance_db;
    }

    private function connectToDb()
    {
        $this->dbh = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname, $this->user, $this->mdp); // connexion
        $this->dbh->exec("SET NAMES 'UTF-8MB4'");      // config du charset
        return $this->dbh;
    }

    public function getDb()
    {
        return $this->dbh;
    }
}

// var_dump(Connexion::getInstance()->getDb());