<?php 
    session_start();

    include("../Database/connection.php");

    $deptName = $_GET['editDept'];
    $deptID = $_GET['editID'];

    $editDept = "UPDATE `department` SET `dept_name`='$deptName' WHERE `dept_id` = $deptID";
    mysqli_query($con, $editDept);
    $_SESSION['editSuccess'] = true;
    header('location: ./departments.php');

?>