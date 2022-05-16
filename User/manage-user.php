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
    <title>Manage Users</title>

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
                            text: '<?php echo $_SESSION['addName']; ?> has been added successfully!',
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
                            text: 'The ID Number you entered already exist.',
                        });
                    </script>
                <?php
                $_SESSION['addError'] = false;
            }
        }

    ?>

    <?php require_once './nav.php' ?>

    <!-- <div class="row justify-content-center my-3">
        <div class="col-5 align-center">
            <input type="text" class="form-control w-50 ps-4 ms-5 rounded-pill" id="" placeholder="Search...">
        </div>
        <div class="col-5">
            <button type="button" class="btn btn-primary px-5 me-5 float-end">Add User</button>
        </div>
    </div> -->
    
    <div class="row justify-content-center mt-5 w-100">
        <div class="col-10">
            <table class="table table-striped table-hover text-center mt-3" id="usersTable">
                <thead>
                    <tr>
                        <th class="text-center">ID Number</th>
                        <th class="text-center">Name</th>
                        <th class="text-center">Email</th>
                        <?php
                            if($_SESSION['role'] == 'superuser'){
                                ?>
                                    <th class="text-center">Department</th>
                                    <th class="text-center">Head</th>
                                    <th class="text-center">Role</th>
                                <?php
                            }
                        ?>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $myName = $_SESSION['fname'];
                        if($_SESSION['role'] == 'superuser'){
                            $queryUsers = "SELECT * FROM `users` WHERE user_id <> '1'";
                        }else if($_SESSION['role'] == 'head'){
                            $queryUsers = "SELECT * FROM `users` WHERE head = '$myName'";
                        }

                        $resultUsers = mysqli_query($con, $queryUsers);
                        if(mysqli_num_rows($resultUsers) > 0){
                            while($rowUsers = mysqli_fetch_assoc($resultUsers)){
                                ?>
                                    <tr>
                                        <td class="align-middle"><?php echo $rowUsers['idNum'] ?></td>
                                        <td class="align-middle"><?php echo $rowUsers['full_name'] ?></td>
                                        <td class="align-middle"><?php echo $rowUsers['email'] ?></td>
                                        <?php
                                            if($_SESSION['role'] == 'superuser'){
                                                ?>
                                                    <td class="align-middle"><?php echo $rowUsers['department'] ?></td>
                                                    <td class="align-middle"><?php echo $rowUsers['head'] ?></td>
                                                    <td class="align-middle"><?php echo $rowUsers['role'] ?></td>
                                                <?php
                                            }
                                        ?>
                                        <td>
                                            <button class="editBtn btn me-1" id="<?php echo $rowUsers['idNum'] ?>" data-name="<?php echo $rowUsers['full_name'] ?>" data-email="<?php echo $rowUsers['email'] ?>" data-dept="<?php echo $rowUsers['department'] ?>" data-head="<?php echo $rowUsers['head'] ?>" data-role="<?php echo $rowUsers['role'] ?>" data-bs-toggle="modal" data-bs-target="#userModal" data-EditUserId="<?php echo $rowUsers['idNum'] ?>">
                                                <svg style="fill: #0d6efd;" height="20px" viewBox="0 0 512 512">
                                                    <path d="M421.7 220.3L188.5 453.4L154.6 419.5L158.1 416H112C103.2 416 96 408.8 96 400V353.9L92.51 357.4C87.78 362.2 84.31 368 82.42 374.4L59.44 452.6L137.6 429.6C143.1 427.7 149.8 424.2 154.6 419.5L188.5 453.4C178.1 463.8 165.2 471.5 151.1 475.6L30.77 511C22.35 513.5 13.24 511.2 7.03 504.1C.8198 498.8-1.502 489.7 .976 481.2L36.37 360.9C40.53 346.8 48.16 333.9 58.57 323.5L291.7 90.34L421.7 220.3zM492.7 58.75C517.7 83.74 517.7 124.3 492.7 149.3L444.3 197.7L314.3 67.72L362.7 19.32C387.7-5.678 428.3-5.678 453.3 19.32L492.7 58.75z"/>
                                                </svg>
                                            </button>
                                            <button href="#" class="btn ms-1" id="<?php echo $rowUsers['idNum'] ?>">
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
    
    <div class="modal fade" id="userModal" data-bs-backdrop="static" data-bs-keyboard="false"  tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                </div>
                <div class="modal-body px-5">
                    <form class="needs-validation" id="frmModal" action="./add-user.php" method="POST">
                        <div class="row mb3">
                            <div class="col-6">
                                <label for="user_idNumber" class="col-form-label">Id Number:</label>
                                <input type="text" name="IDNum" id="user_idNumber" class="form-control" autofocus autocomplete="off">
                                <div class="text-danger visually-hidden" id="idError">Please enter a valid ID number.</div>
                            </div>
                            <div class="col-6">
                                <label for="uname" class="col-form-label">Name:</label>
                                <input type="text" name="fName" class="form-control" id="uname" autocomplete="off">
                                <div class="text-danger visually-hidden" id="nameError">Please enter a valid Name.</div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="uemail" class="col-form-label">Email:</label>
                            <input type="email" name="eMail" class="form-control" id="uemail" autocomplete="off">
                            <div class="text-danger visually-hidden" id="emailError">Please enter a valid email.</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-6" id="userPassword">
                                <label for="upass" class="col-form-label">Password:</label>
                                <input type="password" name="pass1" class="form-control" id="upass1" autocomplete="off">
                            </div>
                            <div class="col-6" id="userPassword">
                                <label for="upass" class="col-form-label">Confirm Password:</label>
                                <input type="password" name="pass2" class="form-control" id="upass2" autocomplete="off">
                            </div>
                            <div class="text-danger text-center visually-hidden" id="passError" style="font-size: 15px;">The password you entered did not match, please try again.</div>
                        </div>

                        <div class="row mb-3">
                            <?php
                                if($_SESSION['role'] == 'superuser'){
                                    $queryHeads = "SELECT * FROM `users` WHERE role = 'head'";
                                    $resultHeads = mysqli_query($con, $queryHeads);

                                    $queryDept = "SELECT * FROM `department`";
                                    $resultDept = mysqli_query($con, $queryDept);
                                    ?>
                                        <div class="mb-3 col-6" id="opdept">
                                            <label for="udept" class="col-form-label">Department:</label>
                                            <select class="form-select" name="user_Dept" id="udept" aria-label="Default select example">
                                                <?php
                                                    if(mysqli_num_rows($resultDept) > 0){
                                                        while($rowDept = mysqli_fetch_assoc($resultDept)){
                                                            ?>
                                                                <option value="<?php echo $rowDept['dept_name']; ?>"><?php echo $rowDept['dept_name']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-6" id="ophead">
                                            <label for="uhead" class="col-form-label">Head:</label>
                                            <select class="form-select" name="user_Head" id="uhead" aria-label="Default select example">
                                                <?php
                                                    if(mysqli_num_rows($resultHeads) > 0){
                                                        while($rowHeads = mysqli_fetch_assoc($resultHeads)){
                                                            ?>
                                                                <option value="<?php echo $rowHeads['idNum']; ?>"><?php echo $rowHeads['full_name']; ?></option>
                                                            <?php
                                                        }
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="mb-3 col-6">
                                            <label for="oprole" class="col-form-label">Role:</label>
                                            <select class="form-select" name="user_Role" id="oprole" aria-label="Default select example">
                                                <option value="head">head</option>
                                                <option value="staff">staff</option>
                                            </select>
                                        </div>
                                    <?php
                                }
                            ?>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" id="sbmtForm" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <script>
        function navFunction(){
            $("#manageuser").addClass("active");
        }

        $(document).ready(function () {
            $('#usersTable').DataTable({
                scrollY: window.innerHeight-300,
                paging: true,
                pagingType: "full_numbers",
                ordering: false,
                lengthMenu: [ [25, 50, 100, -1], [25, 50, 100, "All"] ],
                dom: 'l<"toolbar">frtip',
                initComplete: function(){
                    $("div.toolbar").html('<button type="button" class="btn btn-primary ms-5 px-5" id="userAdd" data-bs-toggle="modal" data-bs-target="#userModal">Add User</button>');           
                },
                language: {
                    paginate: {
                    next: ">",
                    previous: '<',
                    first: '<<',
                    last: '>>'
                    }
                }  
            });

            var UName, UEmail, UDept, UHead, URole;

            $('.editBtn').click(function(){
                $('#user_idNumber').val(this.id);
                UName = $(this).attr("data-name");
                UEmail = $(this).attr("data-email");
                UDept = $(this).attr("data-dept");
                UHead = $(this).attr("data-head");
                URole = $(this).attr("data-role");

                $('#oprole').val(URole);
                $('#uname').val(UName);
                $('#uemail').val(UEmail);
                $('#modalTitle').html('Edit User');

                if($(this).attr("data-role") == 'head'){
                    $('#ophead').addClass('visually-hidden');
                    $('#opdept').removeClass('visually-hidden');
                }else if($(this).attr("data-role") == 'staff'){
                    $('#opdept').addClass('visually-hidden');
                    $('#ophead').removeClass('visually-hidden');
                }

                $('#user_idNumber').attr('readonly', true);
                $('#frmModal').attr('action', './edit-user.php');
            });

            $('#oprole').change(function(){
                if($(this).val() == 'head'){
                    $('#ophead').addClass('visually-hidden');
                    $('#opdept').removeClass('visually-hidden');
                }else if($(this).val() == 'staff'){
                    $('#opdept').addClass('visually-hidden');
                    $('#ophead').removeClass('visually-hidden');
                }
            });

            $('#userAdd').click(function(){
                $('#ophead').addClass('visually-hidden');
                $('#opdept').removeClass('visually-hidden');
                $('#oprole').val('head');
                $('#modalTitle').html('Add User');
                $('#user_idNumber').attr('readonly', false);
                $('#frmModal').attr('action', './add-user.php');
            });

            
            // ========================================= Submit (MODAL) Validation =========================================
            $('#sbmtForm').click(function(event){
                if($('#user_idNumber').val() < 1){
                    $('#idError').removeClass('visually-hidden');
                    $('#user_idNumber').addClass('border-danger');
                    event.preventDefault();
                }

                if($('#uname').val() < 1){
                    $('#nameError').removeClass('visually-hidden');
                    $('#uname').addClass('border-danger');
                    event.preventDefault();
                }

                if($('#uemail').val() < 1){
                    $('#emailError').removeClass('visually-hidden');
                    $('#uemail').addClass('border-danger');
                    event.preventDefault();
                }

                if($('#modalTitle').html() == 'Add User'){
                    if(($('#upass1').val() < 1) || ($('#upass2').val() < 1) || ($('#upass1').val() != $('#upass2').val())){
                        $('#passError').removeClass('visually-hidden');
                        $('#upass1').addClass('border-danger');
                        $('#upass2').addClass('border-danger');
                        event.preventDefault();
                    }
                }

                if($('#modalTitle').html() == 'Edit User'){
                    if($('#upass1').val() != $('#upass2').val()){
                        $('#passError').removeClass('visually-hidden');
                        $('#upass1').addClass('border-danger');
                        $('#upass2').addClass('border-danger');
                        event.preventDefault();
                    }
                }
            });
            // ========================================= END =========================================


            // ========================================= Keyup - Remove Validation Error on each input =========================================
            $('#user_idNumber').on('keyup', function(){
                $('#idError').addClass('visually-hidden');
                $('#user_idNumber').removeClass('border-danger');
            });

            $('#uname').on('keyup', function(){
                $('#nameError').addClass('visually-hidden');
                $('#uname').removeClass('border-danger');
            });

            $('#uemail').on('keyup', function(){
                $('#emailError').addClass('visually-hidden');
                $('#uemail').removeClass('border-danger');
            });

            $('#upass1').on('keyup', function(){
                $('#passError').addClass('visually-hidden');
                $('#upass1').removeClass('border-danger');
                $('#upass2').removeClass('border-danger');
            });

            $('#upass2').on('keyup', function(){
                $('#passError').addClass('visually-hidden');
                $('#upass1').removeClass('border-danger');
                $('#upass2').removeClass('border-danger');
            });
            // ========================================= END =========================================

            // Reset Form (Remove all validation Error)
            function removeValidationError(){
                $('#idError').addClass('visually-hidden');
                $('#user_idNumber').removeClass('border-danger');
                $('#nameError').addClass('visually-hidden');
                $('#uname').removeClass('border-danger');
                $('#emailError').addClass('visually-hidden');
                $('#uemail').removeClass('border-danger');
                $('#passError').addClass('visually-hidden');
                $('#upass1').removeClass('border-danger');
                $('#upass2').removeClass('border-danger');
            }

            $('#userModal').on('hidden.bs.modal', function() {
                removeValidationError();
                $('#frmModal').get(0).reset();
            });
        });
    </script>
</body>
</html>