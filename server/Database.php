<?php

class Database {

    //variables
    private $host;
    private $username;
    private $password;
    private $db;

    private $conn;

    //connect to db and return db or response
    public function connectDB(){
        // $this->host = "localhost";
        // $this->username = "root";
        // $this->password ="";
        // $this->db="easy_learn";

        $this->host = "fdb30.awardspace.net";
        $this->username = "3629486_easylearn";
        $this->password ="*PcpugMt8oP#A!Op";
        $this->db="3629486_easylearn";

        $this->conn = mysqli_connect($this->host, $this->username, $this->password, $this->db);

        if($this->conn->connect_errno){
            echo $this->conn->connect_error;
            exit(0);
        }

        //return connection
        return $this->conn;
    }
}

//test connection
 $test = new Database();
 print_r($test->connectDB());