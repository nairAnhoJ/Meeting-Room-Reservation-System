<?php
    session_start();

    include("../Database/connection.php");

    if(!isset($_SESSION['Connected'])){
        header('location: ../login.php');
    }

    $declineId = $_GET['declineId'];

    $declineReq = "UPDATE `reservation` SET `status`='Declined' WHERE reserve_id = $declineId";
    mysqli_query($con, $declineReq);
    $_SESSION['declineSuccess'] = true;
    header("location: approval.php");

?>