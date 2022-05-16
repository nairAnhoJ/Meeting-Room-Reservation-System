<?php 
    session_start();

    include("../Database/connection.php");

    $rName = str_replace(" ","_",$_POST['roomName']);
    $desc = $_POST['name_desc'];
    $sDate = $_POST['sDate'];
    $eDate = $_POST['eDate'];
    $sTime = $_POST['sTime'];
    $eTime = $_POST['eTime'];

    echo $rName;
    echo ucfirst($desc);
    echo $sDate;
    echo $eDate;
    echo $sTime;
    echo $eTime;

    

?>