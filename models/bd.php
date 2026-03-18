<?php

//models\bd.php

Class MyDB {

    private static ?PDO $sharedConn = null;
    private ?PDO $conn;

    public function __construct() {
      if(self::$sharedConn === null) {
        self::$sharedConn = $this->getConn();
      }
      $this->conn = self::$sharedConn;
    }

    private function getConn() {

      require_once 'config.bd.inc.php';

      $connString = "mysql:host=".DBHOST.":".DBPORT.";";
      $connString .= "dbname=".DBNAME."; charset=".DBCHARSET;

      try { 
        $this->conn = new PDO($connString, DBUSER, DBPASS);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (PDOException $error) { 
        echo "ERROR: ".$error->getMessage(); 
        die();            
      }      

      return $this->conn;
    }

    function close() { 
      $this->conn = null; 
      self::$sharedConn = null;
    }

    public function beginTransaction() {
      $this->conn->beginTransaction();
    }

    public function commit() {
      $this->conn->commit();
    }

    public function myPrepQuery(string $q, $data=[]) {

      try {
        $stmt = $this->conn->prepare($q);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        if(!empty($data)) {
          $stmt->execute($data);
        } else {
          $stmt->execute();
        }
        
        $items = $stmt->fetchAll();

      } catch (PDOException $error) { 
        echo "ERROR: ".$error->getMessage();
        $this->close();
        die();            
      } finally {
        $stmt = null;
      } 
      
      return $items;
    }

    public function getLastInsertId() {
      return $this->conn->lastInsertId();
    }

}//class
 