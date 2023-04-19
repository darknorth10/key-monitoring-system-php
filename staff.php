<?php
    session_start();
    require('connection.php');
    if (empty($_SESSION['user']) || $_SESSION['usertype'] != 'staff') {
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
                <a class="navbar-brand" href="assistant.php" style="font-family: 'Poppins'; font-size:0.7rem; letter-spacing:1px;">
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
                        <li><a class="dropdown-item text-center" href="logout.php">Logout <img class='ms-2' src="assets/images/logout.png" height="20" width="20"></a></li>
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
                    <li><a href="staff.php">Dashboard</a></li>

                    <li id="barrowLi"><a href="#borrowerFaculty">Borrowers Profile</a></li>
                </ul>
            </div>

            <!-- include content page here -->
            <div class="page m-0 overflow-hidden" style="width: 90%;">

                <!-- DASHBOARD -->
                <div class="dashboard h-100 w-100 mb-2 p-3 bg-light" id="dashboard">
                    <h4>Dashboard</h4>

                    <?php include 'dashboard/dashboard.php'; ?>

                </div>

                <!-- BARROWERS PROFILE -->

                <!-- for faculty -->
                <div class="borrowerFaculty h-100 w-100 mb-2 p-3 bg-light" id="borrowerFaculty">
                    <h4>Borrowers Profile</h4>

                    <?php include 'borrowers/borrowers_faculty.php'; ?>
                </div>


                
            </div>
        </div>
    </div>

    


    <!-- bootstarp bundle -->
    <script src="css/bootstrap.bundle.min.js"></script>
    <!-- jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
        window.addEventListener('resize', function(){
            location.reload();
        }, true);
        
        $("#transLi").click(function (e) { 
            if ($('#submenuToggle').attr('aria-expanded') == 'true') {
                $("#carret").css('transform', 'rotate(90deg)');
            } else {
                $("#carret").css('transform', 'rotate(0deg)');
            }
        });

        $("#barrowLi").click(function (e) { 
            if ($('#bsubmenuToggle').attr('aria-expanded') == 'true') {
                $("#bcarret").css('transform', 'rotate(90deg)');
            } else {
                $("#bcarret").css('transform', 'rotate(0deg)');
            }
        });
        
    </script>
</body>
</html> 