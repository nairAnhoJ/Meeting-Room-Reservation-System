<?php
    session_start();

    include("../Database/connection.php");

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
    <link rel="stylesheet" href="../bootstrap/css/dataTables.bootstrap5.min.css">
    <title><?php if($_SESSION['role'] == 'head'){ echo 'My Reservation'; }else{ echo 'My Request'; } ?></title>

    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/sweetalert2.all.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap5.min.js"></script>
    <script crossorigin src="../js/react.production.min.js"></script>
    <script crossorigin src="../js/react-dom.production.min.js"></script>
</head>
<body onload="navFunction()">
    
    <?php require_once './nav.php' ?>

    <?php
    if(!isset($_SESSION['editSuccess'])){
    }else{
        if ($_SESSION['editSuccess'] == true){
            ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Awesome!',
                        text: 'Your Reservation has been updated successfully!',
                    });
                </script>
            <?php
            $_SESSION['editSuccess'] = false;
        }
    }
    if(!isset($_SESSION['deleteSuccess'])){
    }else{
        if ($_SESSION['deleteSuccess'] == true){
            ?>
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Reservation has been deleted successfully.',
                    });
                </script>
            <?php
            $_SESSION['deleteSuccess'] = false;
        }
    }
    ?>

    <div class="row justify-content-center mt-5 w-100">
        <div class="col-10">
            <hr class="my-0">
            <table class="table table-striped table-hover text-center" id="roomTable">
                <thead>
                    <tr>
                        <th>Room Name</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Start Date & Time</th>
                        <th>End Date & Time</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $myID = $_SESSION['uID'];
                        $queryMyRes = "SELECT res.reserve_id, res.room_id, room.room_name, res.description, res.status, res.start_date_time, res.end_date_time FROM reservation AS res INNER JOIN room ON res.room_id = room.room_id WHERE user_id = '$myID' AND res.status <> 'Done' AND res.status <> 'Decline' ORDER BY res.start_date_time";
                        $resultMyRes = mysqli_query($con, $queryMyRes);
                        if(mysqli_num_rows($resultMyRes) > 0){
                            while($rowMyRes = mysqli_fetch_assoc($resultMyRes)){
                                ?>
                                    <tr>
                                        <td class="align-middle"><?php echo str_replace("_"," ",$rowMyRes['room_name']); ?></td>
                                        <td class="align-middle"><?php echo $rowMyRes['description']; ?></td>
                                        <td class="align-middle"><?php echo $rowMyRes['status']; ?></td>
                                        <td class="align-middle"><?php echo $rowMyRes['start_date_time']; ?></td>
                                        <td class="align-middle"><?php echo $rowMyRes['end_date_time']; ?></td>
                                        <td>
                                            <button class="editBtn btn me-3" data-resid="<?php echo $rowMyRes['reserve_id']; ?>" data-roomid="<?php echo $rowMyRes['room_id']; ?>" data-resRoom="<?php echo str_replace("_"," ",$rowMyRes['room_name']); ?>" data-resDesc="<?php echo $rowMyRes['description']; ?>" data-resStart="<?php echo $rowMyRes['start_date_time']; ?>" data-resEnd="<?php echo $rowMyRes['end_date_time']; ?>" data-bs-toggle="modal" data-bs-target="#requestModal">
                                                <svg style="fill: #0d6efd;" height="20px" viewBox="0 0 512 512">
                                                    <path d="M421.7 220.3L188.5 453.4L154.6 419.5L158.1 416H112C103.2 416 96 408.8 96 400V353.9L92.51 357.4C87.78 362.2 84.31 368 82.42 374.4L59.44 452.6L137.6 429.6C143.1 427.7 149.8 424.2 154.6 419.5L188.5 453.4C178.1 463.8 165.2 471.5 151.1 475.6L30.77 511C22.35 513.5 13.24 511.2 7.03 504.1C.8198 498.8-1.502 489.7 .976 481.2L36.37 360.9C40.53 346.8 48.16 333.9 58.57 323.5L291.7 90.34L421.7 220.3zM492.7 58.75C517.7 83.74 517.7 124.3 492.7 149.3L444.3 197.7L314.3 67.72L362.7 19.32C387.7-5.678 428.3-5.678 453.3 19.32L492.7 58.75z"/>
                                                </svg>
                                            </button>
                                            <button class="deleteBtn btn ms-3" data-delresid="<?php echo $rowMyRes['reserve_id']; ?>" data-delresroom="<?php echo str_replace("_"," ",$rowMyRes['room_name']); ?>" data-delresdesc="<?php echo $rowMyRes['description']; ?>" data-delresstart="<?php echo $rowMyRes['start_date_time']; ?>" data-delresend="<?php echo $rowMyRes['end_date_time']; ?>" >
                                                <svg style="fill: #dc3545;" height="20px" viewBox="0 0 448 512">
                                                    <path d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM31.1 128H416V448C416 483.3 387.3 512 352 512H95.1C60.65 512 31.1 483.3 31.1 448V128zM111.1 208V432C111.1 440.8 119.2 448 127.1 448C136.8 448 143.1 440.8 143.1 432V208C143.1 199.2 136.8 192 127.1 192C119.2 192 111.1 199.2 111.1 208zM207.1 208V432C207.1 440.8 215.2 448 223.1 448C232.8 448 240 440.8 240 432V208C240 199.2 232.8 192 223.1 192C215.2 192 207.1 199.2 207.1 208zM304 208V432C304 440.8 311.2 448 320 448C328.8 448 336 440.8 336 432V208C336 199.2 328.8 192 320 192C311.2 192 304 199.2 304 208z"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                <?php
                            }
                        }else{
                            ?>
                                <tr><td colspan="6">NO RECORD!</td></tr>
                            <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- MODAL -->
    <div class="modal fade" id="requestModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="resTitle">Edit Reservation</h5>
                </div>
                <div class="modal-body">
                    <form class="needs-validation" id="frmModal" action="" method="POST">
                        <div class="mb-3">
                            <label for="selected_room_name" class="col-form-label">Room:</label>
                            <select class="form-select" id="selectRoom" name="res_room">
                                <?php
                                    $roomOption = "SELECT * FROM `room`";
                                    $resultOption = mysqli_query($con, $roomOption);
                                    while($rowOption = mysqli_fetch_assoc($resultOption)){
                                        ?>
                                            <option value="<?php echo $rowOption['room_id'] ?>" data-opt-room-id="<?php echo $rowOption['room_id'] ?>"><?php echo str_replace("_"," ",$rowOption['room_name']); ?></option>
                                        <?php
                                    }
                                ?>
                            </select>
                            <!-- <input type="text" name="roomName" id="selected_room_name" class="form-control"> -->
                        </div>
                        <div class="mb-3">
                            <label for="desc" class="col-form-label">Description:</label>
                            <input type="text" name="res_desc" class="form-control" id="resDesc" autofocus required autocomplete="off">
                        </div>
                        <div class="row">
                            <div class=" col-6 mb-3">
                                <label for="startDate" class="col-form-label">Start Date & Time:</label>
                                <input type="datetime-local" name="res_start" class="form-control" id="resStart" required>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="startTime" class="col-form-label">End Date & Time:</label>
                                <input type="datetime-local" name="res_end" class="form-control" id="resEnd" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" id="btnEditRes">Edit Reservation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function navFunction(){
            $("#request").addClass("active");
        }

        $(document).ready(function(){
            var resId, resRoom, resDesc, resStart, resEnd, optionIndex, loopIndex;
            $('.editBtn').click(function(){
                resId = $(this).attr('data-resid');
                resRoomId = $(this).attr('data-roomid');
                resRoomName = $(this).attr('data-resRoom');
                resDesc = $(this).attr('data-resDesc');
                resStart = $(this).attr('data-resStart').replace(/ /g, "T");
                resEnd = $(this).attr('data-resEnd').replace(/ /g, "T");


                optionIndex = 0;
                loopIndex = 0;
                $("#selectRoom > option").each(function() {
                    if($(this).attr('data-opt-room-id') == resRoomId){
                        optionIndex = loopIndex;
                    }else{
                        loopIndex++;
                    }
                });
                $('#resDesc').val(resDesc);
                $('#resStart').val(resStart);
                $('#resEnd').val(resEnd);
                document.getElementById("selectRoom").selectedIndex = optionIndex;
            });

            $('#btnEditRes').click(function(event){
                event.preventDefault();
                nResRoomId = $('#selectRoom').val();
                nResDesc = $('#resDesc').val();
                nResStart = $('#resStart').val();
                nResEnd = $('#resEnd').val();
                console.log(nResRoomId);
                console.log(nResDesc);
                console.log(nResStart);
                console.log(nResEnd);
                window.location.href = './reserve-edit.php?editId=' + resId + '&editRoomId=' + nResRoomId + '&editDesc=' + nResDesc + '&editStart=' + nResStart + '&editEnd=' + nResEnd;
            });

            $('.deleteBtn').click(function(){
                Swal.fire({
                    title: 'Are you sure you want to delete this Reservation?',
                    html: "Room: " + $(this).data('delresroom') + "<br>Description: " + $(this).data('delresdesc'),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './reserve-delete.php?delRes=' + $(this).data('delresid');
                    }
                })
            })
        });
    </script>

</body>
</html>