<?php

class Connexion
{
    private $host = 'localhost';
    private $dbname = 'site_multimedia';
    private $user = 'root';
    private $mdp = '1234512345';
    private static $instance_db;
    private $dbh;

    private function __construct()
    {
    }

    public static function getInstance()
    {
        if (!self::$instance_db) {
            self::$instance_db = new self();
            self::$instance_db->connectToDb();
        }
        return self::$instance_db;
    }

    private function connectToDb()
    {
        try {
            $this->dbh = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname, $this->user, $this->mdp); // connexion
        $this->dbh->exec("SET NAMES 'UTF-8MB4'");      // config du charset
        return $this->dbh;
        } catch (Exception $e) {
            throw new Exception("Impossible de se connecter à la base de donnée.");
        }
    }

    public function getDb()
    {
        return $this->dbh;
    }
}
