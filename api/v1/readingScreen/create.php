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
        JWT::decode(TOKEN, SECRET_KEY, ALGO);

        //get json data
        $jsonData = json_decode(file_get_contents('php://input'));

        //validate variables
        if(!empty($jsonData->title)){

                        //sanitze json data
            $title = $sanitize->sanitize($jsonData->title);
            $description = $sanitize->sanitize($jsonData->description);

                
            //set data array
            $data['record'] = array(
                "title"=>$title,
                "description" => $description
            );

            //create reading screen
            $result = $readingScreen->create($data['record']);

            //check if create succesfull
            if(!is_null($result)){

                //repsonse
                http_response_code(201);
                echo json_encode(array(
                    "msg"=>"success",
                    "code"=>http_response_code(201),
                    "recordId"=> $result->insert_id,
                    "response"=>"created successfully"
                ));
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
