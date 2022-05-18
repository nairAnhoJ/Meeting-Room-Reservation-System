<?php 
    session_start();

    include("../Database/connection.php");

    $deptID = $_GET['delDept'];
    echo $deptID;

    $delDept = "DELETE FROM `department` WHERE `dept_id` = $deptID";
    mysqli_query($con, $delDept);
    $_SESSION['deleteSuccess'] = true;
    header('location: ./departments.php');

?>