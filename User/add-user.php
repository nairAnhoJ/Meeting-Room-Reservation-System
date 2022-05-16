<?php 
    session_start();

    include("../Database/connection.php");

    $IDNum = $_POST['IDNum'];

    $searchUser = "SELECT * FROM `users` WHERE idNum = '$IDNum'";
    $resultSearchUser = mysqli_query($con, $searchUser);
    if(mysqli_num_rows($resultSearchUser) > 0){
        $_SESSION['addError'] = true;
        header('location: ./manage-user.php');
    }else{
        $fName = ucwords($_POST['fName']);
        $eMail = $_POST['eMail'];
        $user_Role = $_POST['user_Role'];
        $hashPass = password_hash($_POST['pass1'], PASSWORD_DEFAULT);

        if($_SESSION['role'] == 'superuser'){

            if($user_Role == 'head'){
                $headDept = $_POST['user_Dept'];
                $headName = '-';

            }else if($user_Role == 'staff'){
                $user_Head = $_POST['user_Head'];

                $getDept = "SELECT * FROM `users` WHERE idNum = '$user_Head'";
                $resultGetDept = mysqli_query($con, $getDept);
                if(mysqli_num_rows($resultGetDept) > 0){
                    while($rowGetDept = mysqli_fetch_assoc($resultGetDept)){
                        $headDept = $rowGetDept['department'];
                        $headName = $rowGetDept['full_name'];
                    }
                }
            }
        }else if($_SESSION['role'] == 'head'){
            $user_Role = 'staff';
            $headDept = $_SESSION['dept'];
            $headName = $_SESSION['fname'];
        }

        $addNewUser = "INSERT INTO `users`(`user_id`, `idNum`, `full_name`, `email`, `department`, `passwrd`, `head`, `role`) VALUES (null,'$IDNum','$fName','$eMail','$headDept','$hashPass','$headName','$user_Role')";
        mysqli_query($con, $addNewUser);
        $_SESSION['addSuccess'] = true;
        $_SESSION['addName'] = $fName;
        header('location: ./manage-user.php');
    }

?>