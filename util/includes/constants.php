<?php

define('SECRET_KEY', 'easy-learn@secure123!');
define("ALGO", array('HS256'));

//token
$headers = getallheaders();
if(isset($headers['Authorization'])){
    define('TOKEN', explode('Bearer ', $headers['Authorization'])[1]);
}
else{
    define('TOKEN', null);
}