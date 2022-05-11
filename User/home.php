<?php
    session_start();

    include("../Database/connection.php");

    $query_room = "SELECT * FROM `room` LIMIT 1";
    $result_room = mysqli_query($con, $query_room);
    if(mysqli_num_rows($result_room) > 0){
        while($room_row = mysqli_fetch_assoc($result_room)){
            $first_room = $room_row['room_name'];
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
</head>
<body class="overflow-hidden vh-100" onload="navFunction()">
    
    <?php require_once './nav.php' ?>

<!-- TAB NAV -->
<ul class="nav nav-pills mt-5 mx-5 mb-3" id="pills-tab" role="tablist">
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
<div class="tab-content mx-5" id="pills-tabContent">
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
            // print_r($tabArray);
        }
    ?>
</div>


<!-- MODAL -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Modal title</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Room:</label>
                    <select class="form-select" aria-label="Default select example">

                    <?php
                        $query_room = "SELECT * FROM `room`";
                        $result_room = mysqli_query($con, $query_room);
                        if(mysqli_num_rows($result_room) > 0){
                            while($room_row = mysqli_fetch_assoc($result_room)){
                                ?>
                                    <option id="<?php echo $room_row['room_id']; ?>" value="<?php echo $room_row['room_id']; ?>"><?php echo $room_row['room_name']; ?></option>
                                <?php
                            }
                        }
                    ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="recipient-name" class="col-form-label">Description:</label>
                    <input type="text" class="form-control" id="recipient-name">
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label for="recipient-name" class="col-form-label">Start Date:</label>
                        <input type="date" class="form-control" id="recipient-name">
                    </div>
                    <div class="col-6 mb-3">
                        <label for="recipient-name" class="col-form-label">End Date:</label>
                        <input type="date" class="form-control" id="recipient-name">
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <label for="recipient-name" class="col-form-label">Start Time:</label>
                        <input type="time" class="form-control" id="recipient-name">
                    </div>
                    <div class="col-6 mb-3">
                        <label for="recipient-name" class="col-form-label">End Time:</label>
                        <input type="time" class="form-control" id="recipient-name">
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Reserve</button>
        </div>
        </div>
    </div>
</div>



















    <script>

        function navFunction(){
            $("#home").addClass("active");
        }

        $('#btn-Conference_Room_1').click(function(){
            $('#btn-dropDown').html("Conference Room 1");
        });

        $('#btn-Conference_Room_2').click(function(){
            $('#btn-dropDown').html("Conference Room 2");
        });

        $('#btn-Conference_Room_3').click(function(){
            $('#btn-dropDown').html("Conference Room 3");
        });

        $('#btn-Conference_Room_4').click(function(){
            $('#btn-dropDown').html("Conference Room 4");
        });

        $('#btn-Conference_Room_5').click(function(){
            $('#btn-dropDown').html("Conference Room 5");
        });

        

        document.addEventListener('DOMContentLoaded', function() {

            // All Rooms Array
            var roomArray = <?php echo json_encode($tabArray); ?>;

            // Front Page Full Calendar
            var calendarEl1 = document.getElementById('calendar_'+roomArray[0]);
            var calendar1 = new FullCalendar.Calendar(calendarEl1, {
                initialView: 'dayGridMonth',
                height: window.innerHeight-250,
                editable:true,
                headerToolbar:{
                    left:'today prev,next',
                    center:'title',
                    right:'reserve dayGridMonth,timeGridWeek,timeGridDay'
                },
                customButtons: {
                    reserve: {
                        text: 'Reserve a Room'
                    }
                },
                events: [
                    {
                        title: 'Test',
                        start: '2022-05-09T09:00:00',
                        end: '2022-05-09T12:30:00'
                    }
                ]
            });
            calendar1.render();

            $('.fc-reserve-button').attr("data-bs-toggle", "modal");
                    $('.fc-reserve-button').attr("id", roomArray[0]);
            $('.fc-reserve-button').attr("data-bs-target", "#staticBackdrop");





            $('li button').click(function(){
                    var roomId = 'calendar_' + (this.id).replace("btn-", "");
                    var btnId = '#'+this.id;

                $(btnId).on('shown.bs.tab', function(){
                    var calendarEl = document.getElementById(roomId);
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: 'dayGridMonth',
                        height: window.innerHeight-250,
                        editable:true,
                        headerToolbar:{
                            left:'today prev,next',
                            center:'title',
                            right:'reserve dayGridMonth,timeGridWeek,timeGridDay'
                        },
                        customButtons: {
                            reserve: {
                                text: 'Reserve a Room'
                            }
                        },
                        events: [
                            {
                                title: 'Test',
                                start: '2022-05-09T09:00:00',
                                end: '2022-05-09T12:30:00'
                            }
                        ]
                    });
                    calendar.render();

                    $('.fc-reserve-button').attr("data-bs-toggle", "modal");
                    $('.fc-reserve-button').attr("id", (this.id).replace("btn-", ""));
                    $('.fc-reserve-button').attr("data-bs-target", "#staticBackdrop");
                });

            });













            // Loop All Rooms
            // for(var m = 0; m < roomArray.length; m++){

            //     var roomName = roomArray[m];
            //     var calendarEl;
            //     var calendar;

                // $('#btn-' + roomName).on('shown.bs.tab', function(){
                //     alert(roomName);
                //     calendarEl = "";
                //     calendar = "";
                //     calendarEl = document.getElementById('#calendar_' + roomName);
                //     calendar = new FullCalendar.Calendar(calendarEl, { initialView: 'dayGridMonth',
                //         height: window.innerHeight-250,
                //         editable:true,
                //         headerToolbar:{
                //             left:'today prev,next',
                //             center:'title',
                //             right:'reserve dayGridMonth,timeGridWeek,timeGridDay'
                //         },
                //         customButtons: {
                //             reserve: {
                //                 text: 'Reserve a Room1'
                //             }
                //         },
                //         events: [
                //             {
                //                 title: 'Test',
                //                 start: '2022-05-09T09:00:00',
                //                 end: '2022-05-09T12:30:00'
                //             }
                //         ]
                //     });
                //     calendar.render();

                //     $('.fc-reserve-button').attr("data-bs-toggle", "modal");
                //     $('.fc-reserve-button').attr("data-bs-target", "#staticBackdrop");
                // });
            // }

















            // ========================================== Room 1 =========================================

            // var calEl;
            // var cal;

            // $('#btn-Conference_Room_1').on('shown.bs.tab', function(){
            //     var calendarEl1 = document.getElementById('calendar_Conference_Room_1');
            //     var calendar1 = new FullCalendar.Calendar(calendarEl1, {
            //         initialView: 'dayGridMonth',
            //         height: window.innerHeight-250,
            //         editable:true,
            //         headerToolbar:{
            //             left:'today prev,next',
            //             center:'title',
            //             right:'reserve dayGridMonth,timeGridWeek,timeGridDay'
            //         },
            //         customButtons: {
            //             reserve: {
            //                 text: 'Reserve a Room1'
            //             }
            //         },
            //         events: [
            //             {
            //                 title: 'Test',
            //                 start: '2022-05-09T09:00:00',
            //                 end: '2022-05-09T12:30:00'
            //             }
            //         ]
            //     });
            //     calendar1.render();

            //     $('.fc-reserve-button').attr("data-bs-toggle", "modal");
            //     $('.fc-reserve-button').attr("data-bs-target", "#staticBackdrop");
            // });

            // // ========================================== Room 2 =========================================
            // $('#btn-Conference_Room_2').on('shown.bs.tab', function(){
            //     var calEl = document.getElementById('calendar_Conference_Room_2');
            //     var cal = new FullCalendar.Calendar(calEl, {
            //         initialView: 'dayGridMonth',
            //         height: window.innerHeight-250,
            //         editable:true,
            //         headerToolbar:{
            //             left:'today prev,next',
            //             center:'title',
            //             right:'reserve dayGridMonth,timeGridWeek,timeGridDay'
            //         },
            //         customButtons: {
            //             reserve: {
            //                 text: 'Reserve a Room2'
            //             }
            //         },
            //         events: [
            //             {
            //                 title: 'Test',
            //                 start: '2022-05-09T09:00:00',
            //                 end: '2022-05-09T12:30:00'
            //             }
            //         ]
            //     });
            //     cal.render();

            //     $('.fc-reserve-button').attr("data-bs-toggle", "modal");
            //     $('.fc-reserve-button').attr("data-bs-target", "#staticBackdrop");
            // });

            // // ========================================== Room 3 =========================================
            // $('#btn-Conference_Room_3').on('shown.bs.tab', function(){
            //     var calEl = document.getElementById('calendar_Conference_Room_3');
            //     var cal = new FullCalendar.Calendar(calEl, {
            //         initialView: 'dayGridMonth',
            //         height: window.innerHeight-250,
            //         editable:true,
            //         headerToolbar:{
            //             left:'today prev,next',
            //             center:'title',
            //             right:'reserve dayGridMonth,timeGridWeek,timeGridDay'
            //         },
            //         customButtons: {
            //             reserve: {
            //                 text: 'Reserve a Room3'
            //             }
            //         },
            //         events: [
            //             {
            //                 title: 'Test',
            //                 start: '2022-05-09T09:00:00',
            //                 end: '2022-05-09T12:30:00'
            //             }
            //         ]
            //     });
            //     cal.render();

            //     $('.fc-reserve-button').attr("data-bs-toggle", "modal");
            //     $('.fc-reserve-button').attr("data-bs-target", "#staticBackdrop");
            // });

            // // ========================================== Room 4 =========================================
            // $('#btn-Conference_Room_4').on('shown.bs.tab', function(){
            //     var calEl = document.getElementById('calendar_Conference_Room_4');
            //     var cal = new FullCalendar.Calendar(calEl, {
            //         initialView: 'dayGridMonth',
            //         height: window.innerHeight-250,
            //         editable:true,
            //         headerToolbar:{
            //             left:'today prev,next',
            //             center:'title',
            //             right:'reserve dayGridMonth,timeGridWeek,timeGridDay'
            //         },
            //         customButtons: {
            //             reserve: {
            //                 text: 'Reserve a Room4'
            //             }
            //         },
            //         events: [
            //             {
            //                 title: 'Test',
            //                 start: '2022-05-09T09:00:00',
            //                 end: '2022-05-09T12:30:00'
            //             }
            //         ]
            //     });
            //     cal.render();

            //     $('.fc-reserve-button').attr("data-bs-toggle", "modal");
            //     $('.fc-reserve-button').attr("data-bs-target", "#staticBackdrop");
            // });

            // // ========================================== Room 5 =========================================
            // $('#btn-Conference_Room_5').on('shown.bs.tab', function(){
            //     var calendarEl5 = document.getElementById('calendar_Conference_Room_5');
            //     var calendar5 = new FullCalendar.Calendar(calendarEl5, {
            //         initialView: 'dayGridMonth',
            //         height: window.innerHeight-250,
            //         editable:true,
            //         headerToolbar:{
            //             left:'today prev,next',
            //             center:'title',
            //             right:'reserve dayGridMonth,timeGridWeek,timeGridDay'
            //         },
            //         customButtons: {
            //             reserve: {
            //                 text: 'Reserve a Room5'
            //             }
            //         },
            //         events: [
            //             {
            //                 title: 'Test',
            //                 start: '2022-05-09T09:00:00',
            //                 end: '2022-05-09T12:30:00'
            //             }
            //         ]
            //     });
            //     calendar5.render();

            //     $('.fc-reserve-button').attr("data-bs-toggle", "modal");
            //     $('.fc-reserve-button').attr("data-bs-target", "#staticBackdrop");
            // });
        });

        
        
    </script>

    

</body>
</html>