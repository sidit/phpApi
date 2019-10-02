<?php
    class Database{
        // Data base Parameter
        private $host = "localhost";
        private $dbname = "phpapi";
        private $user = "root";
        private $password = "";
        private $conn;

    /*   Provides (returns) Connection to database when caled by an another obj of this class .
    Used within the class of 'models' folder.
     */
    public function connect(){
        $this->conn=null;
        try{
            $this->conn=new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->user, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE ,PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            echo "Could not connect to the database: " . $e->getMessage();
        }
        return $this->conn;
    }
}
