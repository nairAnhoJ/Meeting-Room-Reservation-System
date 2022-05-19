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
    <link rel="stylesheet" href="../fullcalendar-5.11.0/lib/main.min.css">
    <link rel="stylesheet" href="../bootstrap/css/dataTables.bootstrap5.min.css">
    <title>Home</title>

    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/sweetalert2.all.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap5.min.js"></script>
    <script crossorigin src="../js/react.production.min.js"></script>
    <script crossorigin src="../js/react-dom.production.min.js"></script>
</head>
<body onload="navFunction()">

    <?php
        if(!isset($_SESSION['approveSuccess'])){
        }else{
            if ($_SESSION['approveSuccess'] == true){
                ?>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Approval Successful',
                            text: 'Reservation Successful Approved!',
                        });
                    </script>
                <?php
                $_SESSION['approveSuccess'] = false;
            }
        }
        if(!isset($_SESSION['declineSuccess'])){
        }else{
            if ($_SESSION['declineSuccess'] == true){
                ?>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Decline Successful',
                            text: 'Reservation Successful Declined!',
                        });
                    </script>
                <?php
                $_SESSION['declineSuccess'] = false;
            }
        }
    ?>
    
    <?php require_once './nav.php' ?>

    <div class="row justify-content-center mt-5 w-100">
        <div class="col-10">
            <hr class="my-0">
            <table class="table table-striped table-hover text-center" id="roomTable">
                <thead>
                    <tr>
                        <th>Room Name</th>
                        <th>Description</th>
                        <th>Start Date & Time</th>
                        <th>End Date & Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $myID = $_SESSION['fname'];
                        $queryMyRes = "SELECT res.reserve_id, res.room_id, room.room_name, res.description, res.status, res.start_date_time, res.end_date_time, res.approver FROM reservation AS res INNER JOIN room ON res.room_id = room.room_id WHERE res.approver = '$myID' AND res.status <> 'Done' AND res.status <> 'Declined' AND res.status <> 'Approved'";
                        $resultMyRes = mysqli_query($con, $queryMyRes);
                        if(mysqli_num_rows($resultMyRes) > 0){
                            while($rowMyRes = mysqli_fetch_assoc($resultMyRes)){
                                ?>
                                    <tr>
                                        <td class="align-middle"><?php echo str_replace("_"," ",$rowMyRes['room_name']); ?></td>
                                        <td class="align-middle"><?php echo $rowMyRes['description']; ?></td>
                                        <td class="align-middle"><?php echo $rowMyRes['start_date_time']; ?></td>
                                        <td class="align-middle"><?php echo $rowMyRes['end_date_time']; ?></td>
                                        <td>
                                            <button class="approveBtn btn me-3" data-resid="<?php echo $rowMyRes['reserve_id']; ?>" data-resRoom="<?php echo str_replace("_"," ",$rowMyRes['room_name']); ?>" data-resDesc="<?php echo $rowMyRes['description']; ?>" data-resStart="<?php echo $rowMyRes['start_date_time']; ?>" data-resEnd="<?php echo $rowMyRes['end_date_time']; ?>">
                                                <svg style="fill: #56b170;" height="30px" viewBox="0 0 448 512">
                                                    <path d="M438.6 105.4C451.1 117.9 451.1 138.1 438.6 150.6L182.6 406.6C170.1 419.1 149.9 419.1 137.4 406.6L9.372 278.6C-3.124 266.1-3.124 245.9 9.372 233.4C21.87 220.9 42.13 220.9 54.63 233.4L159.1 338.7L393.4 105.4C405.9 92.88 426.1 92.88 438.6 105.4H438.6z"/>
                                                </svg>
                                                Approve
                                            </button>
                                            <button class="declineBtn btn ms-3" data-decresid="<?php echo $rowMyRes['reserve_id']; ?>" data-decresroom="<?php echo str_replace("_"," ",$rowMyRes['room_name']); ?>" data-decresdesc="<?php echo $rowMyRes['description']; ?>" data-decresstart="<?php echo $rowMyRes['start_date_time']; ?>" data-decresend="<?php echo $rowMyRes['end_date_time']; ?>" >
                                                <svg style="fill: #dc3545;" height="30px" viewBox="0 0 320 512">
                                                    <path d="M310.6 361.4c12.5 12.5 12.5 32.75 0 45.25C304.4 412.9 296.2 416 288 416s-16.38-3.125-22.62-9.375L160 301.3L54.63 406.6C48.38 412.9 40.19 416 32 416S15.63 412.9 9.375 406.6c-12.5-12.5-12.5-32.75 0-45.25l105.4-105.4L9.375 150.6c-12.5-12.5-12.5-32.75 0-45.25s32.75-12.5 45.25 0L160 210.8l105.4-105.4c12.5-12.5 32.75-12.5 45.25 0s12.5 32.75 0 45.25l-105.4 105.4L310.6 361.4z"/>
                                                </svg>
                                                Decline
                                            </button>
                                        </td>
                                    </tr>
                                <?php
                            }
                        }else{
                            ?>
                                <tr><td colspan="6">There are no request pending.</td></tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function navFunction(){
            $("#approval").addClass("active");
        }

        $(document).ready(function(){
            $('.declineBtn').click(function(){
                Swal.fire({
                    title: 'Decline Request?',
                    html: "Are you sure you want to decline this request?<br><br>Room: " + $(this).data('decresroom') + "<br>Description: " + $(this).data('decresdesc'),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Decline'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './approval-decline.php?declineId=' + $(this).data('decresid');
                    }
                })
            })
        });

        $(document).ready(function(){
            $('.approveBtn').click(function(){
                Swal.fire({
                    title: 'Approve Request?',
                    html: "Are you sure you want to approve this request?<br><br>Room: " + $(this).data('resroom') + "<br>Description: " + $(this).data('resdesc'),
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#56b170',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Approve'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './approval-approve.php?approveId=' + $(this).data('resid');
                    }
                })
            })
        });
    </script>

</body>
</html>