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
    $jsonData = json_decode(file_get_contents("php://input"));

    $email = $sanitize->sanitize($jsonData->email);

    $data['params'] = array(
        "email"=>$email
    );

    $user->setEmail($data['params']);
    $result = $user->getUserByEmail();

    if($result->num_rows > 0){
        $userData = $result->fetch_assoc();
        unset($userData['password']);
        http_response_code(200);
        echo json_encode(array(
            "msg"=>"success",
            "code"=>http_response_code(200),
            "response"=>$userData
        ));
    }
    else{
        include_once('../../../util/server-responses/notFound.php');
    }
}
else{
    include_once('../../../util/server-responses/methodNotAllowed.php');
}