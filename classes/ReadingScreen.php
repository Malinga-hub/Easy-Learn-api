<?php

class ReadingScreen{

    //variables
    private $id;
    private $type_id;
    private $title;
    private $description;

    private $conn;
    private $table_name;

    //constructor
    function __construct($db)
    {
        //set variables
        $this->table_name = "exercises";
        $this->conn =$db;
    }

    //methods

    //get all
    public function getAll(){

        //query
        $query = "SELECT * FROM ".$this->table_name." ORDER BY createdAt DESC";

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
        $this->description = $data['description'];
        $this->type_id = $data['type_id'];

        if($this->getOneByTitle() ==  0){
        //query
        if($this->description != null){
            /* query */
            $query = "INSERT INTO ".$this->table_name."(type_id,title, description) VALUES(?,?,?)";
            //prapre statement
            $preparedStatement = $this->conn->prepare($query);
            $preparedStatement->bind_param("iss",$this->type_id, $this->title, $this->description);
        }
        else{
            /* query */
            $query = "INSERT INTO ".$this->table_name."(type_id,title ) VALUES(?, ?)";
            //prapre statement
            $preparedStatement = $this->conn->prepare($query);
            $preparedStatement->bind_param("is",$this->type_id, $this->title );
        }
        /* execute */
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
        $this->type_id = $data['type_id'];
        $this->description = $data['description'];

        //check if title exists
        if($this->getOneByTitle() == 0 ){

            //check if record exists
            if($this->getOne(array("id"=>$this->id))->num_rows != 0){

                if($this->description != null){
                     //query
                    $query  = "UPDATE ".$this->table_name." SET title=?, type_id=?, description=? WHERE id=?";

                    //prepare
                    $preparedStatement = $this->conn->prepare($query);
                    $preparedStatement->bind_param("sisi", $this->title,$this->type_id, $this->description, $this->id);
                }
                else{
                    //query
                    $query  = "UPDATE ".$this->table_name." SET title=?, type_id=?  WHERE id=?";

                    //prepare
                    $preparedStatement = $this->conn->prepare($query);
                    $preparedStatement->bind_param("sii", $this->title,$this->type_id, $this->id);
                }

                /* execute */
                $preparedStatement->execute();
                //response
                return $preparedStatement->affected_rows; //returns 1 if successfull
            }
            else{
                return -1; //record dose not exist
            }

        }
        /* change description on exisiting record */
        else if($this->getOneByTitle() > 0  && $this->description != ''){
            //query
            $query  = "UPDATE ".$this->table_name." SET description=?,type_id=?   WHERE id=?";

            //prepare
            $preparedStatement = $this->conn->prepare($query);
            $preparedStatement->bind_param("sii", $this->description,$this->type_id,$this->id);
            $preparedStatement->execute();

             //response
             return $preparedStatement->affected_rows; //returns 1 if successfull
         }
        else{
            return null; //title alreadly exists
        }
    }

    //delete
    public function delete($data){

            //set variables
             $this->id = $data['id'];

            //check if record exists
            if($this->getOne(array("id"=>$this->id))->num_rows != 0){

                //delete all data elements attached to the reading screen
                $this->deleteReadingScreenDataElermets();

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

        //data element class 
        include_once('DataElement.php');
        $dataElement = new DataElement($this->conn);
        
        //get all elements
        $elements = $dataElement->getAll(array("exercise_id"=>$this->id));
        
        //delete elments
        while($element = $elements->fetch_assoc()){
            $query = "DELETE FROM ".$dataElement->getTableName()." WHERE id=? AND exercise_id=?";
            $preparedStatement = $this->conn->prepare($query);
            $preparedStatement->bind_param("ii", $element['id'], $this->id);
            $preparedStatement->execute();
        }
    }
}