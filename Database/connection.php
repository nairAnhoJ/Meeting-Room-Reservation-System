<?php

    $dbhost = "localhost";
    $dbuser = "root";
    $dbpass = "";
    $dbname = "reservation_system";

    if(!$con = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname)){
        die("Failed to Connect to Database!");
    }

?>