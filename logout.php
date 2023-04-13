<?php
    session_start();
    if (empty($_SESSION['user'])) {
        header('location: index.php');
    }
    require_once('connection.php');
    
    $curr_user = $_SESSION['user'];

    mysqli_query($conn, "INSERT INTO `audit_tbl`(`user`, `action`) VALUES ('$curr_user', 'User had logged out')");

    session_unset();
    session_destroy();
    
?>


<html>
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

        <div class="main bg-light h-100 w-100 m-0 p-0">

            <!-- header -->
            <nav class="navbar bg-dark" data-bs-theme="dark">
                <div class="container-fluid p-1">
                    <a class="navbar-brand" href="#" style="font-family: 'Poppins'; font-size:0.9rem; letter-spacing:1px;">
                    <img src="assets/images/key.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top mx-3">
                    Key Monitoring
                    </a>
                </div>
            </nav>

            <!-- card div -->
            <div class="card shadow-sm p-2 w-50 h-25 mx-auto mt-5 bg-white">
                <p class="card-body text-center mt-3">You have been logout, click the button to redirect to login page.</p>
                <div class="d-inline-flex justify-content-end p-2">
                    <a class="btn btn-primary" href="index.php">Go to login page</a>
                </div>
            </div>
        </div>
        <script src="css/bootstrap.bundle.min.js"></script>
    </body>
    
</html>