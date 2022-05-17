<?php 
    session_start();

    include("../Database/connection.php");

    if(isset($_GET['delUser'])){
        $delUser = $_GET['delUser'];

        mysqli_query($con, "DELETE FROM `users` WHERE idNum = '$delUser'");
        $_SESSION['deleteSuccess'] = true;
        header("location: manage-user.php");
    }
?>