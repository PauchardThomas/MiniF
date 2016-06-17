<?php 

class Sql {

##Host##
	private $db_host = "localhost";

##User##
	private $db_user = "root";

##Password##
	private $db_pass = "";

##DataBase##
	private $db_db = "mydb";

##Driver##
	private $db_type = "mysql";

    function __construct()
    {
		
        if (self::$db === false) {
            $this->connect();
        }
    }

    private function connect()
    {
		
        $dsn = $this->database_type . ':dbname=' . $this->database_db . ';host=' . $this->database_host;
        try {
            self::$db = new PDO($dsn, $this->database_user, $this->database_pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {   
            echo 'Échec lors de la connexion : ' . $e->getMessage();
        }
    }
}