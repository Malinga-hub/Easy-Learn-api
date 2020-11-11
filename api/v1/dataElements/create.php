<?php

//require pacakges  and classes
require_once('../../../vendor/autoload.php');
require_once('../../../util/includes/headers.php');
require_once('../../../util/includes/constants.php');
require_once('../../../server/Database.php');
require_once('../../../classes/DataElement.php');

include_once('../../../util/Sanitize.php');

//required header
header('Access-Control-Allow-Methods: POST');


//use php-jwt
use Firebase\JWT\JWT;

//db connection
$conn = new Database();
$db = $conn->connectDB();

//create objects 
$dataElement = new DataElement($db);
$sanitize = new Sanitize($db);

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //verify jwt
    try{

        //decode jwt
        $decodedJWT =  JWT::decode(TOKEN, SECRET_KEY, ALGO);
        $user_id = $decodedJWT->data->id;

        //get json data
        $jsonData = json_decode(file_get_contents('php://input'));

        //validate variables
        if(!empty($jsonData->value)){

                        //sanitze json data
            $value = $sanitize->sanitize($jsonData->value);
            $exercise_id = $sanitize->sanitize($jsonData->exercise_id);

                
            //set data array
            $data['params'] = array(
                "value"=>$value,
                "exercise_id"=>$exercise_id,
                "user_id"=>$user_id
            );

            //create reading screen
            $result = $dataElement->create($data['params']);

            //check if create succesfull
            if(!is_null($result)){

                //repsonse
                http_response_code(201);
                echo json_encode(array(
                    "msg"=>"success",
                    "code"=>http_response_code(201),
                    "exercise_id"=>$exercise_id,
                    "recordId"=> $result->insert_id,
                    "response"=>"created successfully"
                ));
            }
            else{
                include_once('../../../util/server-responses/readingScreenNotFound.php');
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
