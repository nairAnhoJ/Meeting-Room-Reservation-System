<?php 
    session_start();

    include("../Database/connection.php");

    $roomID = $_GET['delRoom'];
    echo $roomID;

    $delRoom = "DELETE FROM `room` WHERE `room_id` = $roomID";
    mysqli_query($con, $delRoom);
    $_SESSION['deleteSuccess'] = true;
    header('location: ./rooms.php');

?>