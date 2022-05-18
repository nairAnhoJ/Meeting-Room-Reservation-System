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
    <title>Manage Rooms</title>

    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../js/sweetalert2.all.min.js"></script>
    <script src="../js/jquery.dataTables.min.js"></script>
    <script src="../js/dataTables.bootstrap5.min.js"></script>
    <script crossorigin src="../js/react.production.min.js"></script>
    <script crossorigin src="../js/react-dom.production.min.js"></script>
</head>
<body class="overflow-hidden vh-100" onload="navFunction()">

    <?php

        if(!isset($_SESSION['addSuccess'])){
        }else{
            if ($_SESSION['addSuccess'] == true){
                ?>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Congratulations',
                            text: '<?php echo $_SESSION['roomAddName']; ?> has been added successfully!',
                        });
                    </script>
                <?php
                $_SESSION['addSuccess'] = false;
            }
        }

        if(!isset($_SESSION['addError'])){
        }else{
            if ($_SESSION['addError'] == true){
                ?>
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'The Room you entered already exist.',
                        });
                    </script>
                <?php
                $_SESSION['addError'] = false;
            }
        }

        if(!isset($_SESSION['editSuccess'])){
        }else{
            if ($_SESSION['editSuccess'] == true){
                ?>
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Congratulations',
                            text: 'Room has been updated successfully!',
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
                            text: 'Room has been deleted successfully.',
                        });
                    </script>
                <?php
                $_SESSION['deleteSuccess'] = false;
            }
        }
    ?>

    <?php require_once './nav.php' ?>

    <div class="row justify-content-center mt-5 w-100">
        <div class="col-3">
            <input type="text" class="form-control w-50 ps-3 ms-3 rounded-pill" id="searchRoom" placeholder="Search...">
        </div>
        <div class="col-3">
            <button type="text" class="btn btn-primary float-end me-3" id="addRoom" data-bs-toggle="modal" data-bs-target="#roomModal">+ Add Room</button>
        </div>
    </div>
    <div class="row justify-content-center mt-3 w-100">
        <div class="col-6">
            <hr class="my-0">
            <table class="table table-striped table-hover text-center" id="roomTable">
                <thead>
                    <tr>
                        <th>Room</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $queryRoom = "SELECT * FROM `room`";
                        $resultRoom = mysqli_query($con, $queryRoom);
                        if(mysqli_num_rows($resultRoom) > 0){
                            while($rowRoom = mysqli_fetch_assoc($resultRoom)){
                                ?>
                                    <tr>
                                        <td class="align-middle"><?php echo str_replace("_"," ", $rowRoom['room_name']); ?></td>
                        
                                    <td>
                                        <button class="editBtn btn me-3" data-room="<?php echo str_replace("_"," ", $rowRoom['room_name']); ?>" data-roomid="<?php echo $rowRoom['room_id']; ?>" data-bs-toggle="modal" data-bs-target="#roomModal">
                                            <svg style="fill: #0d6efd;" height="20px" viewBox="0 0 512 512">
                                                <path d="M421.7 220.3L188.5 453.4L154.6 419.5L158.1 416H112C103.2 416 96 408.8 96 400V353.9L92.51 357.4C87.78 362.2 84.31 368 82.42 374.4L59.44 452.6L137.6 429.6C143.1 427.7 149.8 424.2 154.6 419.5L188.5 453.4C178.1 463.8 165.2 471.5 151.1 475.6L30.77 511C22.35 513.5 13.24 511.2 7.03 504.1C.8198 498.8-1.502 489.7 .976 481.2L36.37 360.9C40.53 346.8 48.16 333.9 58.57 323.5L291.7 90.34L421.7 220.3zM492.7 58.75C517.7 83.74 517.7 124.3 492.7 149.3L444.3 197.7L314.3 67.72L362.7 19.32C387.7-5.678 428.3-5.678 453.3 19.32L492.7 58.75z"/>
                                            </svg>
                                        </button>
                                        <button class="deleteBtn btn ms-3" data-room="<?php echo str_replace("_"," ", $rowRoom['room_name']); ?>" data-roomid="<?php echo $rowRoom['room_id']; ?>">
                                            <svg style="fill: #dc3545;" height="20px" viewBox="0 0 448 512">
                                                <path d="M135.2 17.69C140.6 6.848 151.7 0 163.8 0H284.2C296.3 0 307.4 6.848 312.8 17.69L320 32H416C433.7 32 448 46.33 448 64C448 81.67 433.7 96 416 96H32C14.33 96 0 81.67 0 64C0 46.33 14.33 32 32 32H128L135.2 17.69zM31.1 128H416V448C416 483.3 387.3 512 352 512H95.1C60.65 512 31.1 483.3 31.1 448V128zM111.1 208V432C111.1 440.8 119.2 448 127.1 448C136.8 448 143.1 440.8 143.1 432V208C143.1 199.2 136.8 192 127.1 192C119.2 192 111.1 199.2 111.1 208zM207.1 208V432C207.1 440.8 215.2 448 223.1 448C232.8 448 240 440.8 240 432V208C240 199.2 232.8 192 223.1 192C215.2 192 207.1 199.2 207.1 208zM304 208V432C304 440.8 311.2 448 320 448C328.8 448 336 440.8 336 432V208C336 199.2 328.8 192 320 192C311.2 192 304 199.2 304 208z"/>
                                            </svg>
                                        </button>
                                    </td>
                                    </tr>
                                <?php
                            }
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="roomModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                </div>
                <div class="modal-body px-5">
                    <form class="needs-validation" id="frmModal" action="./room-add.php" method="POST">
                        <div class="row mb-4">
                                <label for="roomName" class="col-form-label">Room Name:</label>
                                <input type="text" name="room-name" id="roomName" class="form-control" autofocus autocomplete="off">
                                <div class="text-danger visually-hidden" id="roomError">Please enter a valid Room Name.</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" id class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="sbmtForm" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    



    <script>
        function navFunction(){
            $("#managerooms").addClass("active");
        }

        $(document).ready(function(){
            $("#searchRoom").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                $("#roomTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
                });
            });

            $('#addRoom').click(function(){
                $('#modalTitle').html('Add Room');
                $('#sbmtForm').html('Add');
                $('#sbmtForm').addClass('px-5');
                $('#roomName').focus();
            });

            var roomID;
            $('.editBtn').click(function(){
                $('#modalTitle').html('Edit Room');
                $('#sbmtForm').html('Save Changes');
                $('#sbmtForm').removeClass('px-5');
                $('#roomName').val($(this).attr('data-room'));
                $('#roomName').focus();
                roomID = $(this).attr('data-roomid');
            });

            $('#sbmtForm').click(function(){
                if($('#roomName').val() == ""){
                    event.preventDefault();
                    $('#roomError').removeClass('visually-hidden');
                }else{
                    $('#roomError').addClass('visually-hidden');
                    var editRoom = $('#roomName').val();
                    console.log($('#modalTitle').html());
                    if($('#modalTitle').html() == 'Edit Room'){
                        event.preventDefault();
                        window.location = './room-edit.php?editID=' + roomID + '&editRoom=' + editRoom;
                    }
                }
            });

            $('#roomModal').on('hidden.bs.modal', function(){
                $('#frmModal').get(0).reset();
            });

            $('.deleteBtn').click(function(){
                Swal.fire({
                    title: 'Are you sure you want to delete this Room?',
                    html: $(this).data('room'),
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = './room-delete.php?delRoom=' + $(this).data('roomid');
                    }
                })
            })
        });
    </script>
</body>
</html>