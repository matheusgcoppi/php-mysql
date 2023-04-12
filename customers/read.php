<?php
    header('Access-Control-Allow-Origin:*');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Method: GET');
    header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

    require './function.php'; 

    $requestMethod = $_SERVER['REQUEST_METHOD'];

    if($requestMethod == 'GET') {

        $CustomerList = getCustomerList();
        if ($CustomerList === null) {
            // Handle error case
            $data = [
                'status' => 404,
                'message' => 'No Customer Found', 
            ];
            header("HTTP/1.0 404 No Customer Found");
            echo json_encode($data);
        } else {
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