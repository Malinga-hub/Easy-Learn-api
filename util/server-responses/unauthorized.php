<?php

http_response_code(401);
echo json_encode(array(
    "msg"=>"failed",
    "code"=>http_response_code(401),
    "response"=>"Unauthorized"
));
