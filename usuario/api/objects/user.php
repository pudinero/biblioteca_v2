<?php
    class User{
     
        // database connection and table name
        private $conn;
        private $table_name = "Clientes";
     
        // object properties
        public $id;
        public $username;
        public $password;
        public $created;
     
        // constructor with $db as database connection
        public function __construct($db){
            $this->conn = $db;
        }
        // signup user
        function signup(){
        
            if($this->isAlreadyExist()){
                return false;
            }
            // query to insert record
            $query = "INSERT INTO
                        " . $this->table_name . "
                    SET
                        Usuario=:username, Clave=:password, Fecha_Alta=:created";
        
            // prepare query
            $stmt = $this->conn->prepare($query);
        
            // sanitize
            $this->username=htmlspecialchars(strip_tags($this->username));
            $this->password=htmlspecialchars(strip_tags($this->password));
            $this->created=htmlspecialchars(strip_tags($this->created));
        
            // bind values
            $stmt->bindParam(":username", $this->username);
            $stmt->bindParam(":password", $this->password);
            $stmt->bindParam(":created", $this->created);
        
            // execute query
            if($stmt->execute()){
                $this->id = $this->conn->lastInsertId();
                return true;
            }
        
            return false;
            
        }
        // login user
        function login(){
            // select all query
            $query = "SELECT
                        `ID_Cliente`, `Usuario`, `Clave`, `Fecha_Alta`
                    FROM
                        " . $this->table_name . " 
                    WHERE
                        Usuario='".$this->username."' AND Clave='".$this->password."'";
            // prepare query statement
            $stmt = $this->conn->prepare($query);
            // execute query
            $stmt->execute();
            return $stmt;
        }
        function isAlreadyExist(){
            $query = "SELECT *
                FROM
                    " . $this->table_name . " 
                WHERE
                    Usuario='".$this->username."'";
            // prepare query statement
            $stmt = $this->conn->prepare($query);
            // execute query
            $stmt->execute();
            if($stmt->rowCount() > 0){
                return true;
            }
            else{
                return false;
            }
        }
    }