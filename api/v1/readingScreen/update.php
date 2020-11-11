<?php

//require pacakges  and classes
require_once('../../../vendor/autoload.php');
require_once('../../../util/includes/headers.php');
require_once('../../../util/includes/constants.php');
require_once('../../../server/Database.php');
require_once('../../../classes/ReadingScreen.php');

include_once('../../../util/Sanitize.php');

//required header
header('Access-Control-Allow-Methods: POST');


//use php-jwt
use Firebase\JWT\JWT;

//db connection
$conn = new Database();
$db = $conn->connectDB();

//create objects 
$readingScreen = new ReadingScreen($db);
$sanitize = new Sanitize($db);

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //verify jwt
    try{

        //decode jwt
        $decodedJWT = JWT::decode(TOKEN, SECRET_KEY, ALGO);
        $user_id = $decodedJWT->data->id;

        //get json data
        $jsonData = json_decode(file_get_contents('php://input'));

        //validate variables
        if(!empty($jsonData->title)){

             //sanitze json data
             $id = $sanitize->sanitize($jsonData->id);
            $title = $sanitize->sanitize($jsonData->title);
            $description = $sanitize->sanitize($jsonData->description);
            $type_id = $sanitize->sanitize($jsonData->type_id);

                
            //set data array
            $data['record'] = array(
                "id"=>$id,
                "user_id"=>$user_id,
                "title"=>$title,
                "description" => $description,
                "type_id"=>$type_id
            );

            //update reading screen
            $result = $readingScreen->update($data['record']);

            //check if create succesfull
            if(!is_null($result)){

                if($result != -1){ 
                    //repsonse
                    if($result == 0){$result = 1;}
                    http_response_code(200);
                    echo json_encode(array(
                        "msg"=>"success",
                        "code"=>http_response_code(200),
                        "recordId"=> $id,
                        "response"=>"updated ".$result." record successfully"
                    ));
                }
                else{
                    include_once('../../../util/server-responses/notFound.php');
                }
            }
            else{
                include_once('../../../util/server-responses/alreadyExists.php');
            }

        }
        else{
            include_once('../../../util/server-responses/badRequest.php');
        }

    }
    catch(Exception $e){
        http_response_code(400);
        echo json_encode(array(
            "msg"=>"failed",
            "code"=>http_response_code(400),
            "response"=>"Invalid Token. ".$e->getMessage()
        ));
    }

}
else{
    include_once('../../../util/server-responses/methodNotAllowed.php');
}