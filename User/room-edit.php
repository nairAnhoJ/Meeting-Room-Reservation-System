<?php 
    session_start();

    include("../Database/connection.php");

    $roomName = str_replace(" ","_", $_GET['editRoom']);
    $roomID = $_GET['editID'];

    $editRoom = "UPDATE `room` SET `room_name`='$roomName' WHERE `room_id` = $roomID";
    mysqli_query($con, $editRoom);
    $_SESSION['editSuccess'] = true;
    header('location: ./rooms.php');

?>