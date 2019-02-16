<?php
$host = 'localhost';
$dbname = 'site_multimedia';
$user = 'root';
$mdp = '1234512345';
$col_username = 'nom';
$col_password = 'passwd';
$table_users = 'users';
$table_datas = 'datas';


try {
    $dbh = new PDO("mysql:host=".$host.";dbname=".$dbname, "$user", "$mdp"); // connexion
    $dbh->exec("SET NAMES 'UTF-8MB4'");      // config du charset
} catch (PDOException $myexep) {
    die(sprintf('<p class="error">la connection à la base de données à été refusée <em>%s</em></p>'.
          "\n", $myexep->getMessage()));
}
