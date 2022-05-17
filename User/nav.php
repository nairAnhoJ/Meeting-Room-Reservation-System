<nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-gradient px-5">
  <div class="container-fluid">
    <a class="navbar-brand fs-5" href="./home.php">Room Reservation</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link fs-5" id="home" aria-current="page" href="./home.php">Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link fs-5" id="request" href="./request.php">My Request</a>
            </li>

            <li class="nav-item">
                <a class="nav-link fs-5" id="approval" href="./approval.php">For Approval</a>
            </li>

            <li class="nav-item <?php if(($_SESSION['role'] != 'superuser') && ($_SESSION['role'] != 'head')){ echo 'visually-hidden'; } ?>">
                <a class="nav-link fs-5" id="manageuser" href="./manage-user.php">Manage Users</a>
            </li>

            <li class="nav-item <?php if($_SESSION['role'] != 'superuser'){ echo 'visually-hidden'; } ?>">
                <a class="nav-link fs-5" id="managedept" href="#">Manage Departments</a>
            </li>
            
            <li class="nav-item dropdown position-absolute end-0 pe-5 me-5">
                <a class="nav-link dropdown-toggle active fs-5" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $_SESSION['fname']; ?> </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li><a class="dropdown-item <?php if($_SESSION['role'] == 'superuser'){ echo 'visually-hidden'; } ?>" href="#">Change Password</a></li>
                    <li><a class="dropdown-item" href="./log-out.php">Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
  </div>
</nav>


