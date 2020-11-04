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
        //JWT::decode(TOKEN, SECRET_KEY, ALGO);

        //get json data
        $jsonData = json_decode(file_get_contents('php://input'));

         //sanitze json data
        $id = $sanitize->sanitize($jsonData->id);
        $exercise_id = $sanitize->sanitize($jsonData->exercise_id);

            
        //set data array
        $data['params'] = array(
            "id"=>$id,
            "exercise_id"=>$exercise_id
        );

        //delete reading screen
        $result = $dataElement->delete($data['params']);

        //check if create succesfull
        if(!is_null($result)){

            //check if record exits
            if($result != -1){

                if($result == 0){$result = 1;}
                //repsonse
                http_response_code(200);
                echo json_encode(array(
                    "msg"=>"success",
                    "code"=>http_response_code(200),
                    "exercise_id"=>$exercise_id,
                    "recordId"=> $id,
                    "response"=>"deleted ".$result." record  successfully"
                ));
            }
            else{
                include_once('../../../util/server-responses/notFound.php');
            }
        }
        else{
            include_once('../../../util/server-responses/readingScreenNotFound.php');
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
