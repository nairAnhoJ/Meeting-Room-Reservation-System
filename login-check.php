<?php
    session_start();

    include("./Database/connection.php");

    $username = $_POST['username'];
    $userpass = $_POST['userpass'];

    $queryUser = "SELECT * FROM `users` WHERE idNum = $username LIMIT 1";
    $resultUser = mysqli_query($con, $queryUser);
    if(mysqli_num_rows($resultUser) > 0){
        $userRow = mysqli_fetch_assoc($resultUser);
        if (password_verify($userpass, $userRow['passwrd'])) {
            $_SESSION['fname'] = $userRow['full_name'];
            $_SESSION['Connected'] = 'true';
            $_SESSION['dept'] = $userRow['department'];
            $_SESSION['role'] = $userRow['role'];
            header('Location: ./User/home.php');
        } else {
            $_SESSION['errMes'] = 'true';
            echo "asdfasdf";
            header('Location: ./login.php');
        }
    }else{
        $_SESSION['errMes'] = 'true';
        echo "asdfasddfgsdfgsdfgfa";
        header('Location: ./login.php');
    }



?>