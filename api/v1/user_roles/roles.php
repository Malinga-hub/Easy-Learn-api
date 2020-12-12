<?php

//require pacakges  and classes
require_once('../../../vendor/autoload.php');
require_once('../../../util/includes/headers.php');
require_once('../../../util/includes/constants.php');
require_once('../../../server/Database.php');
require_once('../../../classes/UserRole.php');

include_once('../../../util/Sanitize.php');

//required header
header('Access-Control-Allow-Methods: POST');


//use php-jwt
use Firebase\JWT\JWT;

//db connection
$conn = new Database();
$db = $conn->connectDB();

//create objects
$userRole = new UserRole($db);
$sanitize = new Sanitize($db);


//get all
if($_SERVER['REQUEST_METHOD'] == 'POST'){


        //set records array
        $data['records'] = array();

        //get all and return response
        $result = $userRole->getAllRoles();

        if(!is_null($result)){

            while($record = $result->fetch_assoc()){
                //push data to array
                array_push($data['records'], array(
                    "id"=>$record['id'],
                    "role"=>$record['role'],
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
else{
    include_once('../../../util/server-responses/methodNotAllowed.php');
}