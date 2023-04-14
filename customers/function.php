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

    function findUserById($input) {
        global $connection;

        $id = mysqli_real_escape_string($connection, $input['id']);

        if(empty(trim($id))) {
            return error422('Enter the ID');
        } else {
            $query = "SELECT * FROM customers WHERE id = '$id'";
            $queryResponse = mysqli_query($connection, $query);

            if($queryResponse) {
                
                if(mysqli_num_rows($queryResponse) == 0) {
                    $data = [
                        'status' => 404,
                        'message' =>'Customer Not Found', 
                    ];
                    header("HTTP/1.0 201 Not Found");
                    return json_encode($data);
                }

                else {
                $response = mysqli_fetch_all($queryResponse, MYSQLI_ASSOC);

                $data = [
                    'status' => 201,
                    'message' =>'Customer By Id: ' . $id .' Listed Successfully', 
                    'Response' => $response
                ];
                header("HTTP/1.0 201 Listed");
                return json_encode($data);
                }
            }
            else {
                $data = [
                    'status' => 404,
                    'message' =>'Customer Not Found', 
                ];
                header("HTTP/1.0 201 Not Found");
                return json_encode($data);
            }
        }



    }

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

    function updateCustomer($customerInput, $customerParams) {

        global $connection;

        if (!isset($customerParams['id'])) {

            return error422('Customer Id Not Found in URL');

        } elseif($customerParams['id'] == null) {

           return error422('Enter The Customer ID');
        }
        

        $customerId = mysqli_real_escape_string($connection, $customerParams['id']);

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
            $query = "UPDATE customers SET name='$name', email='$email', phone='$phone' WHERE id='$customerId' LIMIT 1";         
            $queryResponse = mysqli_query($connection, $query);
            

            if($queryResponse) {

                $data = [
                    'status' => 200,
                    'message' =>'Customer Updated Successfully', 
                    'data' => [
                        'name' => $name,
                        'email' => $email,
                        'phone' => $phone
                    ]
                ];
                header("HTTP/1.0 200 Updated");
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

    function deleteCustomer($customerParams) {
        global $connection;

        if (!isset($customerParams['id'])) {

            return error422('Customer Id Not Found in URL');

        } elseif($customerParams['id'] == null) {

           return error422('Enter The Customer ID');
        }
        

        $customerId = mysqli_real_escape_string($connection, $customerParams['id']);

        $query = "DELETE FROM customers WHERE id='$customerId' LIMIT 1 ";
        $queryResult = mysqli_query($connection, $query);

        if($queryResult) {
            $data = [
                'status' => 200,
                'message' =>'Deleted Successfully', 
            ];
            header("HTTP/1.0 200 Deleted");
            return json_encode($data);

        } else {
            
            $data = [
                'status' => 404,
                'message' =>'Customer Not Found', 
            ];
            header("HTTP/1.0 404 Customer Not Found");
            return json_encode($data);
        }
    }

    function getCustomer($customerParams) {
        
        global $connection;

        if($customerParams['id'] == null) {
            return error422("Enter Your Id");
        }

        $customerId = mysqli_real_escape_string($connection, $customerParams['id']);

        $query = "SELECT * FROM customers WHERE id = '$customerId' LIMIT 1";
        $queryResult = mysqli_query($connection,$query);

        if($queryResult) {
            if(mysqli_num_rows($queryResult) == 1) {

                $response = mysqli_fetch_assoc($queryResult);

                $data = [
                    'status' => 200,
                    'message' => 'Customer Fetched Successfully', 
                    'data' => $response
                ];
                header("HTTP/1.0 200 Success");
                return json_encode($data);
            }
            else {
                $data = [
                    'status' => 404,
                    'message' => 'No Customer Found', 
                ];
                header("HTTP/1.0 404 No Customer Found");
                return json_encode($data);
            }
        } else {
            $data = [
                'status' => 500,
                'message' =>'Internal Server Error', 
            ];
            header("HTTP/1.0 500 Internal Server Error");
            return json_encode($data);
        }

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