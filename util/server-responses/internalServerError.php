<?php

http_response_code(500);
echo json_encode(array(
    "msg"=>"failed",
    "code"=>http_response_code(500),
    "response"=>"internal server error."
));