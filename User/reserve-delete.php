<?php
    session_start();

    include("../Database/connection.php");

    $delResId = $_GET['delRes'];

    $resDelete = "DELETE FROM `reservation` WHERE reserve_id = '$delResId'";
    mysqli_query($con, $resDelete);

    $_SESSION['deleteSuccess'] = true;
    header('location: ./request.php');


    ?>