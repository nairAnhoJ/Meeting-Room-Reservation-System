<?php 
    session_start();

    include("../Database/connection.php");

    $rName = $_POST['roomName'];
    $desc = $_POST['name_desc'];
    $sDate = $_POST['sDate'];
    $eDate = $_POST['eDate'];
    $sTime = $_POST['sTime'];
    $eTime = $_POST['eTime'];

    echo $rName;
    echo $desc;
    echo $sDate;
    echo $eDate;
    echo $sTime;
    echo $eTime;

?>