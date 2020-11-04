<?php

http_response_code(400);
echo json_encode(array(
    "msg"=>"failed",
    "code"=>http_response_code(400),
    "response"=>"record already exists"
));