<?php 
    session_start();

    include("../Database/connection.php");

    $roomName = str_replace(" ","_", $_POST['room-name']);

    $checkRoom = "SELECT * FROM `room` WHERE `room_name` = '$roomName'";
    $resultCheck = mysqli_query($con, $checkRoom);
    if(mysqli_num_rows($resultCheck) > 0){
        $_SESSION['addError'] = true;
        header('location: ./rooms.php');
    }else{
        $addNewRoom = "INSERT INTO `room`(`room_id`, `room_name`) VALUES (null,'$roomName')";
        mysqli_query($con, $addNewRoom);
        $_SESSION['addSuccess'] = true;
        $_SESSION['roomAddName'] = $roomName;
        header('location: ./rooms.php');
    }

?>