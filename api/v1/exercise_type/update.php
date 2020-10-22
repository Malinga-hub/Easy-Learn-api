<?php

/* get required classes and modules */
require_once('../../../util/includes/headers.php');
header("Access-Control-Allow-Methods: POST");
require_once('../../../vendor/autoload.php');
require_once('../../../server/Database.php');
require_once('../../../classes/ExerciseType.php');
require_once('../../../util/Sanitize.php');
include_once('../../../util/includes/constants.php');

/* use php jwt */
use Firebase\JWT\JWT;

/* db connection */
$conn = new Database();
$db = $conn->connectDB();

/* class objects */
$exercisType = new ExerciseType($db);
$sanitize = new Sanitize($db);

/* create  */

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    /* for jwt token */
    try{

        /* veriy token */
        //JWT::decode(TOKEN, SECRET_KEY, ALGO);

        /* get json data */
        $jsonData = json_decode(file_get_contents('php://input'));
        /* sanitize */
        $id = $sanitize->sanitize($jsonData->id);
        $title = $sanitize->sanitize($jsonData->title);
        $description = $sanitize->sanitize($jsonData->description);
        $isQuestions = $sanitize->sanitize($jsonData->isQuestions);

        /* set data array */
        $data['params'] = array(
            "id"=>$id,
            "title"=>$title,
            "description"=>$description,
            "isQuestions"=>$isQuestions
        );

        /* create  */
        $result = $exercisType->update($data['params']);

        /* return response */
        if(!is_null($result)){

            /* return response */
            http_response_code(201);
            echo json_encode(array(
                "msg"=>"success",
                "code"=>http_response_code(201),
                "recordId"=> $id,
                "response"=>"updated record successfully"
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