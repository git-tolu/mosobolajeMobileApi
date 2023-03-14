<?php

class Database {
    private $duser = "root";
    // private $dsn = "mysql:host=localhost;  dbname=mosoMobileDatabase";
    private $dsn = "mysql:host=localhost;  dbname=mosobolaje";
    private $pass = "";

    public function __construct()
    {
        try {
            $this->conn = new PDO($this->dsn, $this->duser, $this->pass);
            // echo "DB connected successfully";
        } catch (PDOException $e) {
            echo "ERROR:" . $e->getMessage();
        }
    }

    
    public function test_input($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

}
