<?php 
    session_start();

    include("../Database/connection.php");

    $deptName = $_POST['dept-name'];
    echo $deptName;

    $checkDept = "SELECT * FROM `department` WHERE `dept_name` = '$deptName'";
    $resultCheck = mysqli_query($con, $checkDept);
    if(mysqli_num_rows($resultCheck) > 0){
        $_SESSION['addError'] = true;
        header('location: ./departments.php');
    }else{
        $addNewDept = "INSERT INTO `department`(`dept_id`, `dept_name`) VALUES (null,'$deptName')";
        mysqli_query($con, $addNewDept);
        $_SESSION['addSuccess'] = true;
        $_SESSION['deptAddName'] = $deptName;
        header('location: ./departments.php');
    }

?>