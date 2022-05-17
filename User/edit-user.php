<?php 
    session_start();

    include("../Database/connection.php");

    $eIDNum = $_POST['IDNum'];
    $efName = ucwords($_POST['fName']);
    $eEmail = $_POST['eMail'];
    $ePass = $_POST['pass1'];

    if($_SESSION['role'] == 'superuser'){
        $eRole = $_POST['user_Role'];
        if($eRole == 'head'){
            $eDept = $_POST['user_Dept'];
            $eHead = '-';
        }else if($eRole == 'staff'){
            $user_Head = $_POST['user_Head'];

            $getDept = "SELECT * FROM `users` WHERE idNum = '$user_Head'";
            $resultGetDept = mysqli_query($con, $getDept);
            if(mysqli_num_rows($resultGetDept) > 0){
                while($rowGetDept = mysqli_fetch_assoc($resultGetDept)){
                    $eDept = $rowGetDept['department'];
                    $eHead = $rowGetDept['full_name'];
                }
            }
        }
        if($ePass == ""){
            $editUser = "UPDATE `users` SET `full_name`='$efName',`email`='$eEmail',`department`='$eDept',`head`='$eHead',`role`='$eRole' WHERE `idNum` = '$eIDNum';";
            mysqli_query($con, $editUser);
            $_SESSION['editSuccess'] = true;
            header('location: ./manage-user.php');
        }else{
            $hashPass = password_hash($ePass, PASSWORD_DEFAULT);
            $editUser = "UPDATE `users` SET `full_name`='$efName',`email`='$eEmail',`department`='$eDept',`passwrd`='$hashPass',`head`='$eHead',`role`='$eRole' WHERE `idNum` = '$eIDNum';";
            mysqli_query($con, $editUser);
            $_SESSION['editSuccess'] = true;
            header('location: ./manage-user.php');
        }
    }else if($_SESSION['role'] == 'head'){
        if($ePass == ""){
            $editUser = "UPDATE `users` SET `full_name`='$efName',`email`='$eEmail' WHERE `idNum` = '$eIDNum';";
            mysqli_query($con, $editUser);
            $_SESSION['editSuccess'] = true;
            header('location: ./manage-user.php');
        }else{
            $hashPass = password_hash($ePass, PASSWORD_DEFAULT);
            $editUser = "UPDATE `users` SET `full_name`='$efName',`email`='$eEmail',`passwrd`='$hashPass' WHERE `idNum` = '$eIDNum';";
            mysqli_query($con, $editUser);
            $_SESSION['editSuccess'] = true;
            header('location: ./manage-user.php');
        }
    }

?>