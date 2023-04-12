<?php

error_reporting(0);

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method: POST');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

require './function.php';

$requestMethod = $_SERVER['REQUEST_METHOD'];

if ($requestMethod == 'POST') {

    $inputData = json_decode(file_get_contents("php://input"), true); //true because the json_decode return an object by default and you need an array
    if(empty($inputData)) {

         $storeCustomer = storeCustomer($_POST); 
        
    }
    else {
        $storeCustomer = storeCustomer($inputData);
    }
    echo $storeCustomer;
}
else {
    $data = [
        'status' => 405,
        'message' => $requestMethod . ' Method Not Allowed', 
    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}

?>