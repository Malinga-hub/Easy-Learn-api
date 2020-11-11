<?php

//require pacakges  and classes
require_once('../../../vendor/autoload.php');
require_once('../../../util/includes/headers.php');
require_once('../../../util/includes/constants.php');
require_once('../../../server/Database.php');
require_once('../../../classes/ReadingScreen.php');

include_once('../../../util/Sanitize.php');

//required header
header('Access-Control-Allow-Methods: GET');


//use php-jwt
use Firebase\JWT\JWT;

//db connection
$conn = new Database();
$db = $conn->connectDB();

//create objects 
$readingScreen = new ReadingScreen($db);
$sanitize = new Sanitize($db);

//get one
if($_SERVER['REQUEST_METHOD'] == 'POST'){

    //verify jwt token
    try{

        //decode jwt token
        $decodedJWT = JWT::decode(TOKEN, SECRET_KEY, ALGO);
        $user_id = $decodedJWT->data->id;

        //json data
        $jsonData = json_decode(file_get_contents('php://input'));
        $id = $sanitize->sanitize($jsonData->id);
        

        //set data array
        $data['record'] = array(
            "id"=>$id,
            "user_id"=>$user_id
        );

        $data['record_result'] = array();

        //get the record
        $record = $readingScreen->getOne($data['record']);

        //return response
        if($record->num_rows > 0){

            $recordResult = $record->fetch_assoc();
            
            //push record data into array
            array_push($data['record_result'], array(
                "id"=>$recordResult['id'],
                "user_id"=>$recordResult['user_id'],
                "type_id"=>$recordResult['type_id'],
                "title"=>$recordResult['title'],
                "description"=>$recordResult['description'],
                "createdAt"=>$recordResult['createdAt']
            ));

            //reponse
            http_response_code(200);
            echo json_encode(array(
                "msg"=>"success",
                "code"=>http_response_code(200),
                "records"=>$record->num_rows,
                "response"=>$data['record_result']
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