<?php
    require '../includes/database.php';   
    
    function error422($message) {
        $data = [
            'status' => 422,
            'message' => $message 
        ];
        header("HTTP/1.0 422 Incomplete or incorrect information");
        echo json_encode($data);
        exit();
    };

    function storeCustomer($customerInput) {

        global $connection;

        $name = mysqli_real_escape_string($connection, $customerInput['name']);
        $email = mysqli_real_escape_string($connection, $customerInput['email']);
        $phone = mysqli_real_escape_string($connection, $customerInput['phone']);

        //trim will remove whitespaces to ensure that is real empty

        if(empty(trim($name))) {
            return error422('Enter Your Name');

        } elseif (empty(trim($email))) {
            return error422('Enter Your Email');
            
        } elseif (empty(trim($phone))) {
            return error422('Enter Your Phone');

        } else {
            $query = "INSERT INTO customers (name, email, phone) VALUES ('$name', '$email', '$phone')";         
            $result = mysqli_query($connection, $query);
            

            if($result) {

                $data = [
                    'status' => 201,
                    'message' =>'Customer Created Successfully', 
                ];
                header("HTTP/1.0 201 Created");
                return json_encode($data);

            } else {
                $data = [
                    'status' => 500,
                    'message' =>'Internal Server Error', 
                ];
                header("HTTP/1.0 500 Internal Server Error");
                return json_encode($data);
            }


        };

    }

    function getCustomerList() {
       global $connection;

       $query = "SELECT * FROM customers";
       $query_run = mysqli_query($connection, $query);
       

       if($query_run){

            if(mysqli_num_rows($query_run) >= 3 ) {

                $response = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

                $data = [
                    'status' => 200,
                    'message' => 'Customer List Fetched Successfully', 
                    'Response Data' => $response
                ];
                header("HTTP/1.0 200 Customer List Fetched Successfully");
                return json_encode($data);
                
            }
            else {
                $data = [
                    'status' => 404,
                    'message' => 'No Customer Found', 
                ];
                header("HTTP/1.0 404 No Customer Found");
                return json_encode($data);
            };

       }
       
       else {

        $data = [
            'status' => 500,
            'message' =>'Internal Server Error', 
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
       };

    };
?>