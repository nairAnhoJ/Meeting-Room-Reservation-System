<?php

    session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/style.css">
    <link rel="stylesheet" href="./bootstrap/css/bootstrap.min.css">
    <title>Login</title>

    <script src="./bootstrap/js/bootstrap.min.js"></script>
    <script src="./js/jquery-3.6.0.min.js"></script>
    <script src="./js/sweetalert2.all.min.js"></script>
</head>
<body>

<?php

    if(!isset($_SESSION['errMes'])){
    }else{
        if ($_SESSION['errMes'] == 'true'){
            ?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Incorrect Username or Password.',
                    });
                </script>
            <?php
            session_destroy();
            session_unset();
        }
    }

?>





<div class="container-fluid vh-100 text-center">
    <div class="row vh-100 justify-content-end text-center">
        <div class="col-7 text-center vh-100 pt-5">
            <h1 class="mt-5 text-light">Room Reservation System</h1>
            <img src="./images/company-logo.png" class="mt-5" alt="company-logo" height="300px">
        </div>
        <div class="col-5 align-self-center">
            <h1 class="fw-bold">Sign In</h1>
            <form action="./login-check.php" method="POST" class="container needs-validation mt-4">
                <div class="position-relative mb-4 w-50 mx-auto">
                    <img src="./images/user.png" class="position-absolute start-0" style="margin: 1.25rem 0 0 1.25rem;" height="23px">
                    <input type="text" name="username" class="form-control fs-5 rounded-pill py-3" style="padding-left: 3.5rem;" placeholder="ID Number" autocomplete="off" autofocus required>
                </div>

                <div class="position-relative mb-4 w-50 mx-auto">
                    <img src="./images/password.png" class="position-absolute start-0" style="margin: 1.25rem 0 0 1.25rem;" height="23px">
                    <input type="password" name="userpass" class="form-control fs-5 rounded-pill py-3" style="padding-left: 3.5rem;" placeholder="Password" required>
                </div>

                <div class="input-group justify-content-center mt-4">
                    <div class="col-5">
                        <button class="btn btn-primary bg-gradient rounded px-5 py-2 fs-4 rounded-pill" type="submit">Sign In</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <div class="rounded-circle bg-primary bg-gradient position-fixed" style="width: 4000px; height: 4000px; top: -2500px; left: -2700px; z-index: -1;"></div>

</div>
</body>
</html>