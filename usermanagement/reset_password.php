<?php
    session_start();

    if (empty($_SESSION['user']) || empty($_SESSION['getroomid'])) {
        header('location: ../index.php');
    }
    $editUserid = (int)$_SESSION['userid'];

    require('../connection.php');

    $sql = "SELECT * FROM user_tbl WHERE user_id = '$editUserid'";

    $res = mysqli_query($conn, $sql);

    $rez = mysqli_fetch_assoc($res);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Key Monitoring | Reset Password</title>

    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400&family=Poppins:wght@300&display=swap" rel="stylesheet">
    <!-- bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- custom styles -->
    <link rel="stylesheet" href="../css/styles.css">

</head>
<body>
    <!-- main div wrapper -->

    <div class="main-wrapper bg-light d-flex flex-column h-100 w-100 p-0 m-0">

        <!-- header -->
        <nav class="navbar bg-dark" data-bs-theme="dark">
            <div class="container-fluid py-1 ps-1 pe-2">
                <a class="navbar-brand" href="main.php#rooms" style="font-family: 'Poppins'; font-size:0.9rem; letter-spacing:1px;">
                <img src="../assets/images/key.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top mx-3">
                Key Monitoring | Reset Password
                </a>

                <div class="dropdown me-4 ">
                    <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.7rem;">
                        <?php
                            echo $_SESSION['user'];
                        ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" style="font-size: 0.7rem;">
                        <li><a class="dropdown-item text-center" href="../logout.php">Logout <img class='ms-2' src="../assets/images/logout.png" height="20" width="20"></a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <a class="btn btn-dark mx-4 my-3" href="../main.php#userManagement" style="font-family:'Poppins'; font-size:0.7rem; width:7%;">BACK</a>

        <div class="add_user card bg-white w-50 mx-auto p-0 mt-3">
            <div class="card-header pt-3 bg-primary text-white">
                <h6>Reset Password User : <span class="border rounded px-2 py-1"><?php echo $rez['username'] ."  |  ". $rez['student_teacher_id']; ?></span></h6>
            </div>
            <form class="p-3" method="post" id="reset_pass_form">

                <?php

                    #validations error
                    if (isset($_POST['resetpassSubmit'])) {
                        $adminpass = $_POST['apassword'];
                        $newpass = $_POST['npassword'];
                        $confirmpass = $_POST['cpassword'];
                        $admin = $_SESSION['user'];

                        $query = "SELECT * FROM user_tbl WHERE username = '$admin'";
                        $result = mysqli_fetch_assoc(mysqli_query($conn, $query));
                        
                        if (empty($adminpass) || empty($newpass) || empty($confirmpass)) {
                            echo "<div class='errmessage p-0 rounded text-center text-danger'> <p> All fields are required. </p> </div>";
                        } else if($adminpass != $result['password']) {
                            echo "<div class='errmessage p-0 rounded text-center text-danger'> <p> Admin password is required to reset password for this user. </p> </div>";
                        } else if($confirmpass != $newpass) {
                            echo "<div class='errmessage p-0 rounded text-center text-danger'> <p> Passwords do not match. </p> </div>";
                        } else {{

                            $query = "UPDATE user_tbl SET password = '$newpass' WHERE user_id = '$editUserid'";
                            mysqli_query($conn, $query);
                            header('location: ../main.php#userManagement');

                        }}
                    }
                    
                ?>
                
                <div class="row mb-2">
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="apassword" required placeholder="Password">
                            <label for="floatingPassword">Password for <?php echo $_SESSION['user']; ?></label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="npassword" required placeholder="Password">
                            <label for="floatingPassword">New Password</label>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="cpassword" required placeholder="Password">
                            <label for="floatingPassword">Confirm Password</label>
                        </div>
                    </div>
                </div>
                
                
                <button type="submit" name="resetpassSubmit" class="btn btn-success d-inline-block w-100 my-3">Reset Password</button>
            </form>
        </div>
    </div>


    

    


<!-- bootstarp bundle -->
<script src="../css/bootstrap.bundle.min.js"></script>
    <script>
        window.addEventListener('resize', function(){
            location.reload();
    }, true);

</script>
</body>
</html>