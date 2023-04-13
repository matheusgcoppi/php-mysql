<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Method: GET');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

    require './function.php'; 

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    if($requestMethod == 'GET') {

        
        if (isset($_GET['id'])) { //isset check if the URL has id
            echo $_GET['id'];
            $customer = getCustomer($_GET);
            echo $customer;
        } else {
            $CustomerList = getCustomerList();
            echo $CustomerList;
        }

    }
    else {
        $data = [
            'status' => 405,
            'message' => $requestMethod . 'Method Not Allowed', 
        ];
        header("HTTP/1.0 405 Method Not Allowed");
        echo json_encode($data);
    }

?>