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

    /* jwt */
    try{

        $decodedJWT = JWT::decode(TOKEN, SECRET_KEY, ALGO);
        $user_id=$decodedJWT->data->id;

        $data['params'] = array(
            "id"=>$user_id
        );

        $result = $user->deleteAccount($data['params']);

        if($result != null){

            http_response_code(200);
            echo json_encode(array(
                "msg"=>"success",
                "code"=>http_response_code(200),
                "userId"=>$user_id,
                "response"=>"Successfully deleted user account"
            ));
        }
        else{
            include_once('../../../util/server-responses/notFound.php');
        }
    }
    catch(Exception $e){
        include_once('../../../util/server-responses/unauthorized.php');
    }
}
else{
    include_once('../../../util/server-responses/methodNotAllowed.php');
}