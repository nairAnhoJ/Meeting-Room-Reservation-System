<?php
    session_start();

    include("../Database/connection.php");

    if(!isset($_SESSION['Connected'])){
        header('location: ../login.php');
    }

?>