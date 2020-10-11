<?php

class ReadingScreen{

    //variables
    private $id;
    private $title;

    private $conn;
    private $table_name;

    //constructor
    function __construct($db)
    {
        //set variables
        $this->table_name = "reading_screen";
        $this->conn =$db;
    }

    //methods

    //get all
    public function getAll(){

        //query
        $query = "SELECT * FROM ".$this->table_name;

        //preapre statement and return response
        $preparedStatement = $this->conn->prepare($query);
        $preparedStatement->execute();

        return $preparedStatement->get_result();
    }

    //get one
    public function getOne($data){

        //set variables
        $this->id = $data['id'];

        //query
        $query = "SELECT * FROM ".$this->table_name." WHERE id=?";

        //prepare statement
        $preparedStatement = $this->conn->prepare($query);
        $preparedStatement->bind_param("i", $this->id);
        $preparedStatement->execute();

        return $preparedStatement->get_result();

    }

    //create one
    public function create($data){

        //set variables
        $this->title = $data['title'];

        if($this->getOneByTitle() ==  0){
                    //query
        $query = "INSERT INTO ".$this->table_name."(title) VALUES(?)";

        //prapre statement
        $preparedStatement = $this->conn->prepare($query);
        $preparedStatement->bind_param("s", $this->title);
        $preparedStatement->execute();

        //return result
        return $preparedStatement;
        }
        else{
            return null;
        }
    
    }

    //update 
    public function update($data){

       //set variables
        $this->id = $data['id'];
        $this->title = $data['title'];

        //check if title exists
        if($this->getOneByTitle() == 0 ){

            //check if record exists
            if($this->getOne(array("id"=>$this->id))->num_rows != 0){
                //query
                $query  = "UPDATE ".$this->table_name." SET title=? WHERE id=?";

                //prepare
                $preparedStatement = $this->conn->prepare($query);
                $preparedStatement->bind_param("si", $this->title, $this->id);
                $preparedStatement->execute();

                //response
                return $preparedStatement->affected_rows; //returns 1 if successfull
            }
            else{
                return 0; //record dose not exist
            }

        }
        else{
            return null; //title alreadly exists
        }
    }

        //update 
        public function delete($data){

            //set variables
             $this->id = $data['id'];

            //check if record exists
            if($this->getOne(array("id"=>$this->id))->num_rows != 0){
                //query
                $query  = "DELETE FROM ".$this->table_name."  WHERE id=?";

                //prepare
                $preparedStatement = $this->conn->prepare($query);
                $preparedStatement->bind_param("i", $this->id);
                $preparedStatement->execute();

                //response
                return $preparedStatement->affected_rows; //returns 1 if successfull
            }
            else{
                return 0; //record dose not exist
            }
     
    }
         
     
    //get record by title
    public function getOneByTitle(){

        //query
        $query = "SELECT * FROM ".$this->table_name." WHERE title=?";

        //prepare statement
        $preparedStatement = $this->conn->prepare($query);
        $preparedStatement->bind_param("s", $this->title);
        $preparedStatement->execute();

        //return result
        return $preparedStatement->get_result()->num_rows;
    }
    

    //delete data elemets attached to reading screen
    public function deleteReadingScreenDataElermets(){

        //query
        

        //prepare

        //response
    }


}