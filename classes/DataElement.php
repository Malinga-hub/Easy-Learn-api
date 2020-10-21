<?php

class DataElement{

    //variables
    private $id;
    private $exercise_id;
    private $value;
    private $createdAt;

    private $conn;
    private $table_name;

    //constructor
    function __construct($db)
    {
        //set variables
        $this->table_name = "elements";
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
        $this->exercise_id = $data['exercise_id'];

        //check if reading screen exists
        if($readingScreen->getOne(array("id"=>$this->exercise_id))->num_rows != 0){
            //query
            $query = "SELECT * FROM ".$this->table_name." WHERE exercise_id=?";

            //preapre statement and return response
            $preparedStatement = $this->conn->prepare($query);
            $preparedStatement->bind_param("i", $this->exercise_id);
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
        $this->exercise_id = $data['exercise_id'];
        $this->id = $data['id'];

        //query
        $query = "SELECT * FROM ".$this->table_name." WHERE id=? AND exercise_id=?";

        //prepare statement
        $preparedStatement = $this->conn->prepare($query);
        $preparedStatement->bind_param("ii", $this->id, $this->exercise_id);
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
        $this->exercise_id = $data['exercise_id'];

        //check if screen id valid
        if($readingScreen->getOne(array("id"=>$this->exercise_id))->num_rows > 0){
            
            //query
            $query = "INSERT INTO ".$this->table_name."(exercise_id, value) VALUES(?,?)";

            //prapre statement
            $preparedStatement = $this->conn->prepare($query);
            $preparedStatement->bind_param("is", $this->exercise_id, $this->value);
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

        //include scrren class and create object
        include_once('ReadingScreen.php');
        $readingScreen = new ReadingScreen($this->conn);

        //set variables
        $this->id = $data['id'];
        $this->value = $data['value'];
        $this->exercise_id = $data['exercise_id'];

        //check if screen id valid
        if($readingScreen->getOne(array("id"=>$this->exercise_id))->num_rows > 0){

            //check if data element id exists
            if($this->getOne(array("id"=>$this->id, "exercise_id"=>$this->exercise_id))->num_rows > 0){

                //query
                $query = "UPDATE ".$this->table_name." SET value=? WHERE id=? AND exercise_id=?";

                //prapre statement
                $preparedStatement = $this->conn->prepare($query);
                $preparedStatement->bind_param("sii", $this->value, $this->id, $this->exercise_id);
                $preparedStatement->execute();

                //return result
                return $preparedStatement->affected_rows;
            }
            else{
                return -1; //record does not exist
            }

        }
        else{
            return null; //reading screen does no exist
        }
    }

        //udelete
    public function delete($data){

        //include scrren class and create object
        include_once('ReadingScreen.php');
        $readingScreen = new ReadingScreen($this->conn);

        //set variables
        $this->id = $data['id'];
        $this->exercise_id = $data['exercise_id'];

        //check if screen id valid
        if($readingScreen->getOne(array("id"=>$this->exercise_id))->num_rows > 0){

             //check if data element id exists
             if($this->getOne(array("id"=>$this->id, "exercise_id"=>$this->exercise_id))->num_rows > 0){
                //query
                $query  = "DELETE FROM ".$this->table_name."  WHERE id=? AND exercise_id=?";

                //prepare
                $preparedStatement = $this->conn->prepare($query);
                $preparedStatement->bind_param("ii", $this->id, $this->exercise_id);
                $preparedStatement->execute();

                //response
                return $preparedStatement->affected_rows; //returns 1 if successfull
             }
             else{
                 return -1; //record does not exist
             }
        }
        else{
            return null; //screen id does not exist
        }
    }

    //table name
    public function getTableName(){
        return $this->table_name;
    }
         
}