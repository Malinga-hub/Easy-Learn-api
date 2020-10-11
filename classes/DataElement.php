<?php

class DataElement{

    //variables
    private $id;
    private $reading_screen_id;
    private $value;
    private $createdAt;

    private $conn;
    private $table_name;

    //constructor
    function __construct($db)
    {
        //set variables
        $this->table_name = "data_elements";
        $this->conn =$db;
    }

    //methods

    //get all
    public function getAll($data){

        //get reading screen 
        include_once('ReadingScreen.php');

        //creae screen object
        $readingScreen = new ReadingScreen($this->conn);

        //set variables
        $this->reading_screen_id = $data['reading_screen_id'];

        //check if reading screen exists
        if($readingScreen->getOne(array("id"=>$this->reading_screen_id))->num_rows != 0){
            //query
            $query = "SELECT * FROM ".$this->table_name." WHERE reading_screen_id=?";

            //preapre statement and return response
            $preparedStatement = $this->conn->prepare($query);
            $preparedStatement->bind_param("i", $this->reading_screen_id);
            $preparedStatement->execute();

            return $preparedStatement->get_result();
        }
        else{
            return null; //readin screen does not exist
        }
    }

    //get one
    public function getOne($data){

        //set variables
        $this->reading_screen_id = $data['reading_screen_id'];
        $this->id = $data['id'];

        //query
        $query = "SELECT * FROM ".$this->table_name." WHERE id=? AND reading_screen_id=?";

        //prepare statement
        $preparedStatement = $this->conn->prepare($query);
        $preparedStatement->bind_param("ii", $this->id, $this->reading_screen_id);
        $preparedStatement->execute();

        return $preparedStatement->get_result();

    }

    //create one
    public function create($data){

        //include scrren class and create object
        include_once('ReadingScreen.php');
        $readingScreen = new ReadingScreen($this->conn);

        //set variables
        $this->value = $data['value'];
        $this->reading_screen_id = $data['reading_screen_id'];

        //check if screen id valid
        if($readingScreen->getOne(array("id"=>$this->reading_screen_id))->num_rows > 0){
            
            //query
            $query = "INSERT INTO ".$this->table_name."(reading_screen_id, value) VALUES(?,?)";

            //prapre statement
            $preparedStatement = $this->conn->prepare($query);
            $preparedStatement->bind_param("ss", $this->reading_screen_id, $this->value);
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
}