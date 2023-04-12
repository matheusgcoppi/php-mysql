<?php

    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "php_api";

    $connection = mysqli_connect($host, $username, $password, $dbname);

    if(!$connection) {
        die("connection failed: " . mysqli_connect_error());
    };

?>