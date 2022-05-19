<?php
    session_start();

    include("../Database/connection.php");

    date_default_timezone_set("Asia/Manila");

    $query_room = "SELECT * FROM `room` LIMIT 1";
    $result_room = mysqli_query($con, $query_room);
    if(mysqli_num_rows($result_room) > 0){
        while($room_row = mysqli_fetch_assoc($result_room)){
            $first_room = $room_row['room_name'];
        }
    }

    if(!isset($_SESSION['Connected'])){
        header('location: ../login.php');
    }

    $todayTime = strtotime(date("Y-m-d H:i:s"));
    $queryDone = "SELECT * FROM `reservation` WHERE `status` <> 'Done'";
    $resultDone = mysqli_query($con, $queryDone);
    while($rowDone = mysqli_fetch_assoc($resultDone)){
        $doneId = $rowDone['reserve_id'];
        if($todayTime > strtotime($rowDone['end_date_time'])){
            $updateDone = "UPDATE `reservation` SET `status`='Done' WHERE `reserve_id` = '$doneId'";
            mysqli_query($con, $updateDone);
        }
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
    <title>Home</title>

    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../fullcalendar-5.11.0/lib/main.min.js"></script>
    <script src="../js/sweetalert2.all.min.js"></script>
</head>
<body class="overflow-hidden vh-100" onload="navFunction()">

    <?php

    if(!isset($_SESSION['headResSuccess'])){
    }else{
        if ($_SESSION['headResSuccess'] == true){
            ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Awesome!',
                        text: 'Reservation Successful!',
                    });
                </script>
            <?php
            $_SESSION['headResSuccess'] = false;
        }
    }

    if(!isset($_SESSION['staffResSuccess'])){
    }else{
        if ($_SESSION['staffResSuccess'] == true){
            ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Awesome!',
                        text: 'Your request has been process. Please wait for approval.',
                    });
                </script>
            <?php
            $_SESSION['staffResSuccess'] = false;
        }
    }

    if(!isset($_SESSION['resError'])){
    }else{
        if ($_SESSION['resError'] == true){
            ?>
                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Reservation Error!',
                        text: 'Please choose a different schedule date or time.',
                    });
                </script>
            <?php
            $_SESSION['resError'] = false;
        }
    }
    ?>
    
    <?php require_once './nav.php' ?>

    <!-- TAB NAV -->
    <ul class="nav nav-pills mt-5 position-relative start-50 translate-middle" id="pills-tab" role="tablist">
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle active" id="btn-dropDown" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false"><?php echo str_replace("_"," ", $first_room); ?></a>
        <ul class="dropdown-menu" role="tablist">
            <?php
                $query_roomNav = "SELECT * FROM `room`";
                $result_roomNav = mysqli_query($con, $query_roomNav);
                if(mysqli_num_rows($result_roomNav) > 0){
                    $first_nav = 0;
                    while($room_row = mysqli_fetch_assoc($result_roomNav)){
                        if($first_nav == 0){
                            $first_nav++;
                            ?>
                                <li><button class="dropdown-item active" id="btn-<?php echo $room_row['room_name']; ?>" data-bs-toggle="pill" data-bs-target="#<?php echo $room_row['room_name']; ?>" type="button" role="tab" aria-controls="pills-profile" aria-selected="false"><?php echo str_replace("_"," ",$room_row['room_name']); ?></button></li>
                            <?php
                        }else{
                            ?>
                                <li><button class="dropdown-item" id="btn-<?php echo $room_row['room_name']; ?>" data-bs-toggle="pill" data-bs-target="#<?php echo $room_row['room_name']; ?>" type="button" role="tab" aria-controls="pills-profile" aria-selected="false"><?php echo str_replace("_"," ",$room_row['room_name']); ?></button></li>
                            <?php
                        }
                    }
                }
            ?>
        </ul>
    </li>
    </ul>
    <!-- TAB CONTENT -->
    <div class="tab-content mx-3" id="pills-tabContent">
        <?php
            $query_roomNav = "SELECT * FROM `room`";
            $result_roomNav = mysqli_query($con, $query_roomNav);
            if(mysqli_num_rows($result_roomNav) > 0){
                $first_tab = 0;
                $tabArray = array();
                while($room_row = mysqli_fetch_assoc($result_roomNav)){
                    if($first_tab == 0){
                        $first_tab++;
                        array_push($tabArray, $room_row['room_name']);
                        ?>
                            <div class="tab-pane fade show active" id="<?php echo $room_row['room_name']; ?>" role="tabpanel" aria-labelledby="pills-home-tab">
                                <div class="container mt-3">
                                    <div id="calendar_<?php echo $room_row['room_name']; ?>"></div>
                                </div>
                            </div>
                        <?php
                    }else{
                        array_push($tabArray, $room_row['room_name']);
                        ?>
                            <div class="tab-pane fade" id="<?php echo $room_row['room_name']; ?>" role="tabpanel" aria-labelledby="pills-home-tab">
                                <div class="container mt-3">
                                    <div id="calendar_<?php echo $room_row['room_name']; ?>"></div>
                                </div>
                            </div>
                        <?php
                    }
                }
            }
        ?>
    </div>

    <!-- MODAL -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Reserve a Room</h5>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" id="frmModal" action="./reserve_room.php" method="POST" novalidate>
                        <div class="mb-3">
                            <label for="selected_room_name" class="col-form-label">Room:</label>
                            <input type="text" name="roomName" id="selected_room_name" class="form-control" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="desc" class="col-form-label">Description:</label>
                            <input type="text" name="name_desc" class="form-control" id="desc" autofocus required autocomplete="off">
                            <div class="invalid-feedback">Please enter a valid description.</div>
                        </div>
                        <div class="row">
                            <div class=" col-6 mb-3">
                                <label for="startDate" class="col-form-label">Start Date & Time:</label>
                                <input type="datetime-local" name="sDateTime" class="form-control" id="startDateTime" required>
                                <div class="invalid-feedback">Please choose start date & time.</div>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="startTime" class="col-form-label">End Date & Time:</label>
                                <input type="datetime-local" name="eDateTime" class="form-control" id="endDateTime" required>
                                <div class="invalid-feedback">Please choose end date & time.</div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Reserve</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>





    

<!-- ================================ SCRIPT ================================ -->

    <script>
        function navFunction(){
            $("#home").addClass("active");
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            var aRoomId;
            var aaRoomId;
            var selectedRoomId;
            var c = 0;

            // ===================================== Front Page Full Calendar =====================================
            var roomArray = <?php echo json_encode($tabArray); ?>;

            var calendarEl1 = document.getElementById('calendar_'+roomArray[0]);
            var calendar1 = new FullCalendar.Calendar(calendarEl1, {
                initialView: 'dayGridMonth',
                height: window.innerHeight-250,
                editable:false,
                headerToolbar:{
                    left:'today prev,next',
                    center:'title',
                    right:'reserve dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                },
                customButtons: {
                    reserve: {
                        text: 'Reserve a Room',
                        click: function() {
                            selectedRoomId = this.id;
                            $('#selected_room_name').val(this.id.replace(/_/g, " "));
                        }
                    }
                },
                events: [
                    {
                        title: 'Test',
                        start: '2022-05-09T10:00:00',
                        end: '2022-05-09T15:30:00'
                    }
                ]
            });
            calendar1.render();

            $('.fc-reserve-button').attr("data-bs-toggle", "modal");
            $('.fc-reserve-button').attr("id", roomArray[0]);
            $('.fc-reserve-button').attr("data-bs-target", "#staticBackdrop");
            // ===================================== END =====================================



            // ===================================== Display Calendar after Tab reload on Click =====================================
            $('li button').click(function(){
                if(c != 0){
                    calendar.destroy();
                }else{
                    calendar1.destroy();
                }
                var roomId = 'calendar_' + (this.id).replace("btn-", "");
                var roomName = (this.id).replace("btn-", "");
                var btnId = '#'+this.id;

                $('#btn-dropDown').html((roomName.replace(/_/g, " ")));

                $(btnId).on('shown.bs.tab', function(){
                    var calendarEl = document.getElementById(roomId);
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        height: window.innerHeight-250,
                        editable:false,
                        headerToolbar:{
                            left:'today prev,next',
                            center:'title',
                            right:'reserve dayGridMonth,timeGridWeek,timeGridDay,listWeek'
                        },
                        customButtons: {
                            reserve: {
                                text: 'Reserve a Room',
                                click: function() {
                                    selectedRoomId = this.id;
                                    $('#selected_room_name').val(this.id.replace(/_/g, " "));
                                }
                            }
                        },
                        events: [
                            {
                                title: 'Test',
                                start: '2022-05-09T19:15',
                                end: '2022-05-09T22:30'
                            }
                        ]
                    });
                    calendar.render();

                    aRoomId = (this.id).replace("btn-", "");
                    $('.fc-reserve-button').attr("data-bs-toggle", "modal");
                    $('.fc-reserve-button').attr("id", aRoomId);
                    $('.fc-reserve-button').attr("data-bs-target", "#staticBackdrop");
                });
            });
            // ===================================== END =====================================

            // Form(Modal) Validation
            var forms;
            (function () {
            'use strict'
            forms = document.querySelectorAll('.needs-validation');
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    }

                    form.classList.add('was-validated');
                }, false)
                });
            })();

            // Reset Modal on Close
            $('#staticBackdrop').on('hidden.bs.modal', function() {
                $('#frmModal').removeClass('was-validated');
                $('#frmModal').get(0).reset();
            });

            
            $("#startDateTime").change(function(){
                if(!$("#endDateTime").val()){
                    $("#endDateTime").val(this.value);
                }

                var sDate = $('#startDateTime').val();
                var eDate = $('#endDateTime').val();
                var sTime = new Date(sDate).getTime();
                var eTime = new Date(eDate).getTime();

                var today = new Date();
                var yyyy = today.getFullYear();
                var MM = today.getMonth() + 1;
                if(MM < 10){
                    MM = "0"+MM;
                }
                var dd = today.getDate();
                if(dd < 10){
                    dd = "0"+dd;
                }
                var HH = today.getHours();
                if(HH < 10){
                    HH = "0"+HH;
                }
                var mm = today.getMinutes();
                if(mm < 10){
                    mm = "0"+mm;
                }

                var DateTimeNow = yyyy + '-' + MM + '-' + dd + 'T' + HH + ':' + mm;
                var nowTime = new Date(DateTimeNow).getTime();

                if(sTime < nowTime){
                    $("#startDateTime").val(DateTimeNow);
                }

                if(sTime > eTime){
                    $("#startDateTime").val(eDate);
                }
            });
            $("#endDateTime").change(function(){
                if(!$("#startDateTime").val()){
                    $("#startDateTime").val(this.value);
                }

                var sDate = $('#startDateTime').val();
                var eDate = $('#endDateTime').val();
                var sTime = new Date(sDate).getTime();
                var eTime = new Date(eDate).getTime();

                if(sTime > eTime){
                    $("#endDateTime").val(sDate);
                }
            });
        });
        
    </script>
</body>
</html>