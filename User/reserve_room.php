<?php 
    session_start();

    include("../Database/connection.php");

    $userID = $_SESSION['uID'];
    $rName = str_replace(" ","_",$_POST['roomName']);
    $desc = ucfirst($_POST['name_desc']);
    $sDateTime = $_POST['sDateTime'];
    $eDateTime = $_POST['eDateTime'];
    $resHead = $_SESSION['userHead'];

    $queryRoomId = "SELECT * FROM `room` WHERE room_name = '$rName'";
    $resultRoomId = mysqli_query($con, $queryRoomId);
    while($roomRow = mysqli_fetch_assoc($resultRoomId)){
        $rId = $roomRow['room_id'];
    }

    $queryReserve = "SELECT * FROM `reservation` WHERE room_id = '$rId'";
    $resultReserve = mysqli_query($con, $queryReserve);
    if(mysqli_num_rows($resultReserve) > 0){
        while($resRow = mysqli_fetch_assoc($resultReserve)){
            for ($x = strtotime($sDateTime); $x <= strtotime($eDateTime); $x = $x + 60){
            
                if(($x >= strtotime($resRow['start_date_time'])) && ($x <= strtotime($resRow['end_date_time']))){
                    $schedError = true;
                    break;
                }
            }
            if($schedError == true){
                $_SESSION['resError'] = true;
                header('Location: ./home.php');
            }else{
                if($_SESSION['role'] == 'head'){
                    $status = 'Approved';
                    $_SESSION['headResSuccess'] = true;
                }else{
                    $status = 'Waiting for Approval';
                    $_SESSION['staffResSuccess'] = true;
                }
            
                $reserveRoom = "INSERT INTO `reservation`(`reserve_id`, `user_id`, `room_id`, `description`, `status`, `start_date_time`, `end_date_time`, `approver`) VALUES (null,'$userID','$rId','$desc','$status','$sDateTime','$eDateTime','$resHead')";
                mysqli_query($con, $reserveRoom);
                header('Location: ./home.php');
            }
        }
    }else{
        if($_SESSION['role'] == 'head'){
            $status = 'Approved';
            $_SESSION['headResSuccess'] = true;
        }else{
            $status = 'Waiting for Approval';
            $_SESSION['staffResSuccess'] = true;
        }
    
        $reserveRoom = "INSERT INTO `reservation`(`reserve_id`, `user_id`, `room_id`, `description`, `status`, `start_date_time`, `end_date_time`, `approver`) VALUES (null,'$userID','$rId','$desc','$status','$sDateTime','$eDateTime','$resHead')";
        mysqli_query($con, $reserveRoom);
        header('Location: ./home.php');
    }

?>