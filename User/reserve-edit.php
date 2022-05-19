<?php
    session_start();

    include("../Database/connection.php");

    $resId = $_GET['editId'];
    $resRoom = $_GET['editRoomId'];
    $resDesc = $_GET['editDesc'];
    $resStart = $_GET['editStart'];
    $resEnd = $_GET['editEnd'];

    $resUpdate = "UPDATE `reservation` SET `room_id`='$resRoom',`description`='$resDesc',`start_date_time`='$resStart',`end_date_time`='$resEnd' WHERE reserve_id = '$resId'";
    mysqli_query($con, $resUpdate);

    $_SESSION['editSuccess'] = true;
    header('location: ./request.php');


    ?>