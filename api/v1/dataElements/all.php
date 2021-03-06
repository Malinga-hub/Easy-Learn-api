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
$santize = new Sanitize($db);


//get all 
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //verify jwt 
    try{

        //verify jwt
        $decodedJWT =  JWT::decode(TOKEN, SECRET_KEY, ALGO);
        $user_id = $decodedJWT->data->id;

        //get json data
        $jsonData = json_decode(file_get_contents('php://input'));


        $data['params'] = array(
            "exercise_id"=>$santize->sanitize($jsonData->exercise_id),
            "user_id"=>$user_id
        );

        //set records array
        $data['records'] = array();

        //get all and return response
        $result = $dataElement->getAll($data['params']);

        if(!is_null($result)){

            while($record = $result->fetch_assoc()){
                //push data to array
                array_push($data['records'], array(
                    "id"=>$record['id'],
                    "exercise_id"=>$record['exercise_id'],
                    "value"=>$record['value'],
                    "createdAt"=>$record['createdAt']
                ));
            }
    
            //return response
            http_response_code(200);
            echo json_encode(array(
                "msg"=>"success",
                "code"=>http_response_code(200),
                "records"=>$result->num_rows,
                "response"=>$data['records']
            ));
         }
        else{
            include_once('../../../util/server-responses/readingScreenNotFound.php');
        }

    }
    catch(Exception $e){
        http_response_code(400);
        echo  json_encode(array(
            "msg"=>"failed",
            "code"=>http_response_code(400),
            "response"=>"Invalid Token. ".$e->getMessage()
        ));
       //echo  $e->getMessage();
    }

}
else{
    include_once('../../../util/server-responses/methodNotAllowed.php');
}