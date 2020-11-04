<?php

http_response_code(404);
echo json_encode(array(
    "msg"=>"failed",
    "code"=>http_response_code(404),
    "response"=>"exercise Not found"
));