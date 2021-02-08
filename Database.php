<?php
/*
* Mysql database class - only one connection alowed
*/
class Database{
      private $connection;
      private static $_instance;

      private $dbhost = "127.0.0.1"; // Ip Address of database if external connection.
      private $dbuser = "postgres"; // Username for DB
      private $dbpass = "8811181938"; // Password for DB
      private $port = "5433"; // Password for DB
      private $dbname = "books_db"; // DB Name

      /*
      Get an instance of the Database
      @return Instance
      */	
      public static function getInstance(){
        if(!self::$_instance) {
              self::$_instance = new self();
           }
          return self::$_instance;
        }

      // Constructor
      private function __construct() {
        try{
        $this->connection = new PDO('pgsql:host='.$this->dbhost.';port='.$this->port.';dbname='.$this->dbname, $this->dbuser, $this->dbpass);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 	
	// Error handling
        }catch(PDOException $e){
          die("Failed to connect to DB: ". $e->getMessage());
        }
      }

      // Magic method clone is empty to prevent duplication of connection
      private function __clone(){}
      
      // Get the connection	
      public function getConnection(){
        return $this->connection;
      }
}
