<?php
class Session {
   private static $instance; 
   private $user_id;
   private $user_nom;
   private $user_passwd;
 
   private function __construct($user_id,$user_nom,$user_passwd) {
     echo "<p>création de l'instance de Session ".$user_nom." / ".$user_passwd."</p>\n";
     $this->$user_id = $user_id;
     $this->user_nom = $user_nom;
     $this->user_passwd = $user_passwd;
   }
 
   private function __destruct() {
     echo "<p>destruction de l'instance de Session".$this->user_nom."</p>\n";
   }
 
    static function getInstance($user_id = 'defaut_id', $user_nom = 'defaut_nom', $user_passwd = 'defaut_passwd') {
     if (!self::$instance) self::$instance = new self($user_id,$user_nom,$user_passwd);
    // echo "<p>appel de l'instance de Sessio ".self::$instance->user_nom." / ".self::$instance->user_passwd."</p>\n";
     
     return self::$instance;
   }

  function getUserId() { 
     return $this->user_id;
   }
    
   function getUserNom() { 
     return $this->user_nom;
   }
   
    function getUserPasswd() {
     return $this->user_passwd;
   }
 
   static function killInstance() {
     self::$instance = null;
   }
}
/*
echo "<br/>Ligne1<br/>";
Session::getInstance('jon','password1');
//Singleton::getInstance('toi');
echo "<br/>Ligne2<br/>";
printf("nom : %s<br/>\n", Session::getInstance()->getUserNom());
printf("password : %s<br/>\n", Session::getInstance()->getUserPasswd());
//printf("passwd : %s<br/>\n", Singleton::getInstance()->getUserPasswd());
echo "<br/>Ligne3<br/>";
Session::killInstance();
echo "<br/>Ligne4<br/>";
Session::getInstance('adeline','password3');
echo "<br/>Ligne5<br/>";
Session::getInstance('christophe','password2');
echo "<br/>Ligne6<br/>";
printf("nom : %s<br/>\n", Session::getInstance('thierry','password4')->getUserNom());
echo "<br/>Ligne7<br/>";
Session::killInstance();*/