<nav class="navbar navbar-expand-lg navbar-dark bg-primary bg-gradient px-5">
  <div class="container-fluid">
    <a class="navbar-brand" href="./home.php">Room Reservation</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" id="home" aria-current="page" href="./home.php">Home</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" id="reserve" href="./reserve.php">Reserve</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" id="request" href="./request.php">My Request</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" id="approval" href="./approval.php">For Approval</a>
            </li>
            
            <li class="nav-item dropdown position-absolute end-0 pe-5 me-5">
                <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Account</a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <li class="visually-hidden"><a class="dropdown-item" href="#">Settings</a></li>
                    <li><a class="dropdown-item" href="#">Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
  </div>
</nav>