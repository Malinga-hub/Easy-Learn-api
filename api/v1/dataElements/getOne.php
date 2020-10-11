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

//get one
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //verify jwt token
    try{

        //decode jwt token
        JWT::decode(TOKEN, SECRET_KEY, ALGO);

        //get json data
        $jsonData = json_decode(file_get_contents('php://input'));

        //get and sanitize the id
        $readingScreanId =$sanitize->sanitize($jsonData->readingScreenId); 
        $id = $sanitize->sanitize($jsonData->id);

        //set data array
        $data['params'] = array(
            "id"=>$id,
            "reading_screen_id"=>$readingScreanId
        );

        $data['record'] = array();

        //get the record
        $record = $dataElement->getOne($data['params']);

        //return response
        if($record->num_rows > 0){

            $recordResult = $record->fetch_assoc();
            
            //push record data into array
            array_push($data['record'], array(
                "id"=>$recordResult['id'],
                "readinsScreenId"=>$recordResult['reading_screen_id'],
                "value"=>$recordResult['value'],
                "createdAt"=>date('d-m-y', strtotime($recordResult['createdAt']))
            ));

            //reponse
            http_response_code(200);
            echo json_encode(array(
                "msg"=>"success",
                "code"=>http_response_code(200),
                "records"=>$record->num_rows,
                "response"=>$data['record']
            ));

        }
        else{
            include_once('../../../util/server-responses/notFound.php');
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