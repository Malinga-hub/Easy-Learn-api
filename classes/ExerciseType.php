<?php

class ExerciseType{

    /* vaariables */
    private $id;
    private $title;
    private $description;
    private $isQuestions;
    private $createdAt;

    private $conn;
    private $table_name;

    /* constructor */
    function __construct($db)
    {
        $this->conn = $db;
        $this->table_name = "exercise_type";
    }

    /* get all */
    public function getAll(){

        $query = "SELECT * FROM ".$this->table_name." ORDER BY createdAt DESC";
        $preparedStatement = $this->conn->prepare($query);
        $preparedStatement->execute();

        return $preparedStatement->get_result();
    }

    /* create one */
    public function create($data){

        /* set values */
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->isQuestions = $data['isQuestions'];
        
        if($this->getByTitle() == 0){
            /* query */
            $query = "INSERT INTO ".$this->table_name."(title, description, isQuestions) VALUES(?,?,?)";
            $preparedStatement = $this->conn->prepare($query);
            $preparedStatement->bind_param("ssi", $this->title, $this->description, $this->isQuestions);
            $preparedStatement->execute();

            return $preparedStatement;
        }
        else{
            return null; //record exists
        }



    }

    /* update  */
    public function update($data){

        /* set values */
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->isQuestions = $data['isQuestions'];
        
        if($this->getById() != 0){
            /* query */
            $query = "UPDATE ".$this->table_name." SET title=?, description=?, isQuestions=? WHERE id=?";
            $preparedStatement = $this->conn->prepare($query);
            $preparedStatement->bind_param("ssii", $this->title, $this->description, $this->isQuestions, $this->id);
            $preparedStatement->execute();

            return $preparedStatement;
        }
        else{
            return null; //record exists
        }
    }

    /* get type by title */
    private function getByTitle(){

        /* query */
        $query = "SELECT * FROM ".$this->table_name." WHERE title=?";
        $preparedStatement = $this->conn->prepare($query);
        $preparedStatement->bind_param("s", $this->title);
        $preparedStatement->execute();

        /* return response */
        return $preparedStatement->get_result()->num_rows;
    }

    /* get type by title */
    private function getById(){

        /* query */
        $query = "SELECT * FROM ".$this->table_name." WHERE id=?";
        $preparedStatement = $this->conn->prepare($query);
        $preparedStatement->bind_param("i", $this->id);
        $preparedStatement->execute();

        /* return response */
        return $preparedStatement->get_result()->num_rows;
    }


}