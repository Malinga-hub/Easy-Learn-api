 <?php

class User{

    //variables
    private $id;
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
        $this->email = $data['email'];
        $this->password = $data['password'];
        
        //query
        $query = "INSERT INTO ".$this->table_name."(username, email, password) VALUES(?,?,?)";

        //prepare and execute query
        $preparedStatement = $this->conn->prepare($query);
        $preparedStatement->bind_param("sss", $this->username, $this->email, $this->password);

        //return response
        return $preparedStatement->execute();
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
    private function getUserByEmail(){
        
        //querry
        $query = "SELECT * FROM  ".$this->table_name." WHERE email=?";

        //prepare
        $preparedStatement = $this->conn->prepare($query);
        $preparedStatement->bind_param("s", $this->email);
        $preparedStatement->execute();
        
         //return result
        return $preparedStatement->get_result();
    }

}