<?php

class UserRole{

    private $id;
    private $role;
    private $createdAt;

    private $tableName;
    private $conn;

    function __construct($db){
        $this->tableName = "user_roles";
        $this->conn = $db;
    }

    public function getAllRoles(){

        $query = "SELECT * FROM ".$this->tableName."";
        $preparedStatement = $this->conn->prepare($query);
        $preparedStatement->execute();

        return $preparedStatement->get_result();
    }
}
?>