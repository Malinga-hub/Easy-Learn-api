<?php

http_response_code(405);
echo json_encode(array(
    "msg"=>"failed",
    "code"=>http_response_code(405),
    "response"=>"Method not allowed"
));