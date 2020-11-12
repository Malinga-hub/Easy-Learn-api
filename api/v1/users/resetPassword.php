<?php 

//require pacakges  and classes
require_once('../../../vendor/autoload.php');
require_once('../../../util/includes/headers.php');
require_once('../../../util/includes/constants.php');
require_once('../../../server/Database.php');
require_once('../../../classes/User.php');

include_once('../../../util/Sanitize.php');

//required header
header('Access-Control-Allow-Methods: POST');

//use php-jwt
use Firebase\JWT\JWT;

/* get db */
$conn = new Database();
$db = $conn->connectDB();

/* user class */
$user = new User($db);
$sanitize = new Sanitize($db);

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    /* get json data */
    $jsonData = json_decode(file_get_contents('php://input'));

    /* sanitize data */
    $id = $sanitize->sanitize($jsonData->id);
    $password1 = $sanitize->sanitize($jsonData->newPassword);
    $password2 = $sanitize->sanitize($jsonData->confirmPassword);

    switch($password1 == $password2){

        case true:
            $data['params']=array(
                "id"=>$id,
                "password"=>password_hash($password1, PASSWORD_BCRYPT)
            );
            $result = $user->changePassword($data['params']);
            
            switch($result->affected_rows == 1 || $result->affected_rows == 0){
                case true: 
                    http_response_code(200);
                    echo json_encode(array(
                        "msg"=> "success",
                        "code"=>http_response_code(200),
                        "response"=>"successfully changed password" 
                    ));
                    break;
                case false:
                    include_once('../../../util/server-responses/internalServerError.php');
                    break;
            }
            break;
        
        case false:
            http_response_code(404);
            echo json_encode(array(
                "msg"=> "failed",
                "code"=>http_response_code(404),
                "reponse"=>"passwords do not match"
            ));
            break;
    }

}
else{
    include_once('../../../util/server-responses/methodNotAllowed.php');
}