<?php
    session_start();

    if (empty($_SESSION['user'])) {
        header('location: index.php');
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Key Monitoring</title>

    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400&family=Poppins:wght@300&display=swap" rel="stylesheet">
    <!-- bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- custom styles -->
    <link rel="stylesheet" href="css/styles.css">

</head>
<body>

    
    <!-- main div wrapper -->

    <div class="main-wrapper d-flex flex-column h-100 w-100 p-0 m-0">

        <!-- header -->
        <nav class="navbar bg-dark" data-bs-theme="dark">
            <div class="container-fluid py-1 ps-1 pe-2">
                <a class="navbar-brand" href="main.php" style="font-family: 'Poppins'; font-size:0.7rem; letter-spacing:1px;">
                <img src="assets/images/key.png" alt="Logo" width="25" height="25" class="d-inline-block align-text-top mx-3">
                Key Monitoring
                </a>

                <div class="dropdown me-4 ">
                    <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.7rem;">
                        <?php
                            echo $_SESSION['user'];
                        ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" style="font-size: 0.7rem;">
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <!-- content div -->
        <div class="content bg-light flex-fill d-flex overflow-hidden">

            <!-- side navigation bar -->
            <div class="sidenav card h-100 p-2">
                <div class="logo">
                    <img src="assets/images/university-seal.png" alt="">
                </div>
                <ul type="none" class="w-100 mx-0 mt-2 py-1" id="nav">
                    <li><a href="#dashboard">Dashboard</a></li>
                    <li><a href="#userManagement">User Management</a></li>
                    <li><a href="#barrowersProfile">Borrowers Profile</a></li>
                    <li><a href="#rooms">Rooms</a></li>
                    <li><a data-bs-toggle="collapse" href="#transactionSubMenu" role="button" aria-expanded="false" aria-controls="transactionSubMenu">Transactions</a></li>

                    <ul class="collapse" id="transactionSubMenu" type="none">
                        <li><a href="#">Borrow Room</a></li>
                        <li><a href="#">Return Key</a></li>
                    </ul>

                    <li><a href="#">Audit Trail</a></li>
                </ul>
            </div>

            <!-- include content page here -->
            <div class="page m-0 bg-light overflow-hidden" style="width: 80%;">

                <!-- DASHBOARD -->
                <div class="dashboard h-100 w-100 mb-2 p-3 bg-light" id="dashboard">
                    <h4>Dashboard</h4>

                    <?php include 'dashboard.php'; ?>

                </div>

                <!-- USER MANAGEMENT -->
                <div class="dashboard h-100 w-100 mb-2 p-3 bg-light" id="userManagement">
                    <h4>User Management</h4>

                    <?php include 'usermanagement.php'; ?>

                </div>

                <!-- BARROWERS PROFILE -->
                <div class="dashboard h-100 w-100 mb-2 p-3 bg-light" id="barrowersProfile">
                    <h4>Borrowers Profile</h4>
                </div>

                <!--  ROOMS -->
                <div class="dashboard h-100 w-100 mb-2 p-3 bg-light" id="rooms">
                    <h4>Rooms</h4>
                    <?php include 'rooms.php'; ?>
                </div>
                
            </div>
        </div>
    </div>

    


<!-- bootstarp bundle -->
<script src="css/bootstrap.bundle.min.js"></script>
<script>
    window.addEventListener('resize', function(){
        location.reload();
}, true);

</script>
</body>
</html>