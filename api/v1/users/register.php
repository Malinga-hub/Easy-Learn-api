<?php

//required packages and include classes and files
require_once('../../../vendor/autoload.php');
require_once('../../../util/includes/headers.php');
require_once('../../../server/Database.php');
require_once('../../../classes/User.php');

include_once('../../../util/Sanitize.php');

//header
header('Access-Control-Allow-Methods: POST');


//get db connection
$conn = new Database();
$db = $conn->connectDB();

//create objects
$user = new User($db);
$sanitize = new Sanitize($db);

//register user
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //get json body
    $jsonData = json_decode(file_get_contents('php://input'));

    //sanitize data
    $username = $sanitize->sanitize($jsonData->username);
    $email = $sanitize->sanitize($jsonData->email);
    $password = $sanitize->sanitize($jsonData->password);

    //check if email valid
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
    //encrypt password
    $password = password_hash($password, PASSWORD_BCRYPT);

    //create set data array
    $data['user'] = array(
        "username"=>$username,
        "email"=>$email,
        "password"=>$password
    );

    //register user and return response
    $result = $user->register($data['user']);

    //response
    if($result){

    http_response_code(200);
    echo json_encode(array(
        "msg"=>"success",
        "code"=>http_response_code(200),
        "response"=> "user registered.",
    ));


    }
    else{
        include_once('../../../util/server-responses/internalServerError.php');
    }

    }
    else{
        include_once('../../../util/server-responses/badRequest.php');
    }
}
else{
    include_once('../../../util/server-responses/methodNotAllowed.php');
}