<?php

//required packages and include classes and files
require_once('../../../vendor/autoload.php');
require_once('../../../util/includes/headers.php');
require_once('../../../server/Database.php');
require_once('../../../classes/User.php');
require_once('../../../util/includes/constants.php');
include_once('../../../util/Sanitize.php');

//use firebase jwt
use Firebase\JWT\JWT;

//headers
header('Access-Control-Allow-Methods: POST');

//db connection
$conn = new Database();
$db = $conn->connectDB();

//create pbjects
$user = new User($db);
$sanitize = new Sanitize($db);

//login user
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //get json data
    $jsonData = json_decode(file_get_contents('php://input'));

    //sanize the data
    $email = $sanitize->sanitize($jsonData->email);
    $password = $sanitize->sanitize($jsonData->password);

    //validate email
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
        //login user, sign jwt and return response
        $data['user'] = array(
            "email"=>$email,
            "password"=>$password
        );

        $loginUser = $user->login($data['user']);

        if($loginUser != null){

            //set jwt variabes
            $issuedAt = time();
            $expiresAt = $issuedAt + (60*60) *60; //for a day
            $data['user_data'] = array(
                "id"=>$loginUser['id'],
                "email"=>$loginUser['email'],
                "createdAt"=>date('d-m-y', strtotime($loginUser['createdAt']))
            );

            //jwt payload
            $payload = array(
                "iat"=>$issuedAt,
                "exp"=>$expiresAt,
                "token_type"=>"Bearer",
                "data"=>$data['user_data']
            );

            //create jwt token
            $token = JWT::encode($payload, SECRET_KEY);

            //return reponse
            http_response_code(200);
            echo json_encode(array(
                "msg"=>"success",
                "code"=>http_response_code(200),
                "token"=>$token,
                "response"=>"login successfull"
            ));


        }
        else{
            include_once('../../../util/server-responses/unauthorized.php');
        }
    }
    else{
        include_once('../../../util/server-responses/badRequest.php');
    }

}
else{
    include_once('../../../util/server-responses/methodNotAllowed.php');
}