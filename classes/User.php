 <?php

class User{

    //variables
    private $id;
    private $role_id;
    private $username;
    private $email;
    private $password;
    private $createdAt;

    private $table_name;
    private $conn;

    //constructor
    function  __construct($db)
    {
        //set variables
        $this->table_name = 'users';
        $this->conn = $db;
    }


    //methods

    //register
    public function register($data){

        //set variables
        $this->username = $data['username'];
        $this->role_id = $data['role_id'];
        $this->email = $data['email'];
        $this->password = $data['password'];


        if($this->getUserByEmail()->num_rows == 0){
            //query
            $query = "INSERT INTO ".$this->table_name."(role_id,username, email, password) VALUES(?,?,?,?)";

            //prepare and execute query
            $preparedStatement = $this->conn->prepare($query);
            $preparedStatement->bind_param("isss", $this->role_id,$this->username, $this->email, $this->password);
            $preparedStatement->execute();

            return $preparedStatement;
        }
        else{
            return null;
        }
        
    }

    //login
    public function login($data){
        //set variables
        $this->email = $data['email'];
        $this->password = $data['password'];

        //current user
        $currentUser = $this->getUserByEmail()->fetch_assoc();


        //return response
        if($currentUser != null){
            if(password_verify($this->password, $currentUser['password'])){
                return $currentUser;
            }
            else{
                return null;
            }
        }
        else{
            return null;
        }

    }

    //get user by email
    public function getUserByEmail(){
        
        //querry
        $query = "SELECT * FROM  ".$this->table_name." WHERE email=?";

        //prepare
        $preparedStatement = $this->conn->prepare($query);
        $preparedStatement->bind_param("s", $this->email);
        $preparedStatement->execute();
        
         //return result
        return $preparedStatement->get_result();
    }

    //change password
    public function changePassword($data){

        /* change password */
        $this->id = $data['id'];
        $this->password = $data['password'];
        
        /* query */
        $query = "UPDATE ".$this->table_name." SET password=? WHERE id=?";

        /* prepare query */
        $preparedStatement = $this->conn->prepare($query);
        $preparedStatement->bind_param("si", $this->password, $this->id);
        $preparedStatement->execute();

        // print_r($preparedStatement);

        return $preparedStatement;
    }

    /* delete user */
    public function deleteAccount($data){

        /* set variables */
        $this->id = $data['id'];

        $result = $this->getById();

        if($result->num_rows > 0){

            include_once ('ReadingScreen.php');
            $readingScreen = new ReadingScreen($this->conn);

            $readingScreen->deleteByUserId(array("user_id"=>$this->id));

            /* delete user */
            $query="DELETE FROM ".$this->table_name." WHERE id=?";
            $preparedStatement=$this->conn->prepare($query);
            $preparedStatement->bind_param("i", $this->id);
            $preparedStatement->execute();

            return $preparedStatement;

        }
        else{
            return null;
        }
    }

    /* set email */
    public function setEmail($data){
        $this->email = $data['email'];
    }

    /* get by id */
    private function getById(){

        /* query */
        $query = "SELECT * FROM users WHERE id=?";
        $preparedStatement = $this->conn->prepare($query);
        $preparedStatement->bind_param("i", $this->id);
        $preparedStatement->execute();

        return $preparedStatement->get_result();
    }

}