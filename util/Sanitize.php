<?php

class Sanitize{


    //variables
    private $conn;

    //construct
    function __construct($db){
        $this->conn = $db;
    }

    //sanitize data
    public function sanitize($data){
        return htmlentities(strip_tags(mysqli_real_escape_string($this->conn, $data)));
    }

}