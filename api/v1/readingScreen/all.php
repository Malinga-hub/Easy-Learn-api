<?php

//require pacakges  and classes
include_once('../../../util/includes/headers.php');
//required header
header('Access-Control-Allow-Methods: GET');

require_once('../../../vendor/autoload.php');
require_once('../../../util/includes/constants.php');
require_once('../../../server/Database.php');
require_once('../../../classes/ReadingScreen.php');

include_once('../../../util/Sanitize.php');



//use php-jwt
use Firebase\JWT\JWT;

//db connection
$conn = new Database();
$db = $conn->connectDB();

//create objects
$readingScreen = new ReadingScreen($db);
$santize = new Sanitize($db);


//get all 
if($_SERVER['REQUEST_METHOD'] == 'GET'){

    //verify jwt 
    try{

        //verify jwt
        JWT::decode(TOKEN, SECRET_KEY, ALGO);

        //set records array
        $data['records'] = array();

        //get all and return response
        $result = $readingScreen->getAll();

        while($record = $result->fetch_assoc()){
            //push data to array
            array_push($data['records'], array(
                "id"=>$record['id'],
                "title"=>$record['title'],
                "description"=>$record['description']
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