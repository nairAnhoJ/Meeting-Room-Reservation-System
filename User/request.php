<?php
    session_start();

    include("../Database/connection.php");

    if(!isset($_SESSION['Connected'])){
        header('location: ../login.php');
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/style.css">
    <title>Home</title>

    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/jquery-3.6.0.min.js"></script>
</head>
<body onload="navFunction()">
    
    <?php require_once './nav.php' ?>

    <script>
        function navFunction(){
            $("#request").addClass("active");
        }
    </script>

</body>
</html>