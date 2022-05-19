<?php
    session_start();

    include("../Database/connection.php");

    if(!isset($_SESSION['Connected'])){
        header('location: ../login.php');
    }

    $approveID = $_GET['approveId'];
    echo $approveID;

    $approveReq = "UPDATE `reservation` SET `status`='Approved' WHERE reserve_id = $approveID";
    mysqli_query($con, $approveReq);
    $_SESSION['approveSuccess'] = true;
    header("location: approval.php");

?>