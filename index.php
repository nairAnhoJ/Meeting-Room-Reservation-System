<?php

    session_start();

    if(!isset($_SESSION['Connected'])){
        header('location: ./login.php');
    }
?>