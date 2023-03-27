<?php
    session_start();

    if (empty($_SESSION['user'])) {
        header('location: index.php');
    } elseif (empty($_SESSION['edit_user_id'])) {
        header('location: main.php#userManagement');
    }

    $sql = "SELECT * FROM user_table WHERE user_id = '$_SESSION['edit_user_id'"];

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

    <div class="main-wrapper bg-light d-flex flex-column h-100 w-100 p-0 m-0">

        <!-- header -->
        <nav class="navbar bg-dark" data-bs-theme="dark">
            <div class="container-fluid py-1 ps-1 pe-2">
                <a class="navbar-brand" href="#" style="font-family: 'Poppins'; font-size:0.9rem; letter-spacing:1px;">
                <img src="assets/images/key.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top mx-3">
                Key Monitoring | Add User
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

        <div class="add_user card bg-white w-50 mx-auto p-0 mt-3">
            <div class="card-header pt-3 bg-primary text-white">
                <h6>Create New User</h6>
            </div>
            <form class="p-3" method="post" id="add_user_form">
                <?php
                    require('connection.php');


                    #validations error
                    if (isset($_POST['adduserSubmit'])) {
                        $fname = $_POST['fname'];
                        $lname = $_POST['lname'];
                        $username = $_POST['username'];
                        $password = $_POST['password'];
                        $cpassword = $_POST['cpassword'];
                        $usertype = $_POST['usertype'];
                        $status = $_POST['status'];
                        $tsid = $_POST['tsid'];


                        if (empty($fname) || empty($lname) || empty($username) || empty($password) || empty($cpassword) || empty($usertype) ||  empty($tsid)) {
                                echo "<div class='errmessage p-0 rounded text-center text-danger'> <p> All fields are required </p> </div>";
                        } else {
                            
                            if($password != $cpassword) {
                                echo "<div class='errmessage p-0 rounded text-center text-danger'> <p> Passwords Do Not Match </p> </div>";
                            }
                            else if ($usertype == "false" || $status == "false") {
                                echo "<div class='errmessage p-0 rounded text-center text-danger'> <p> Select options for user type or status </p> </div>";

                            } else {
                                # $sql = "INSERT INTO `user_tbl`(`user_id`, `first_name`, `last_name`, `username`, `password`, `user_type`, `status`, `student_id`, `teacher_id`) VALUES ( Null,'$fname','$lname','$username','$password','$usertype','$status','$tsid','$tsid')";
                                $sql = "SELECT * FROM user_tbl WHERE username = '$username' OR student_teacher_id = '$tsid'";
                                $result = mysqli_query($conn, $sql);

                                if(mysqli_num_rows($result) == 0) {
                                    $sql = "INSERT INTO `user_tbl`(`user_id`, `first_name`, `last_name`, `username`, `password`, `user_type`, `status`, `student_teacher_id`) VALUES ( Null,'$fname','$lname','$username','$password','$usertype','$status','$tsid')";
                                    mysqli_query($conn, $sql);

                                    header('location: main.php#userManagement');
                                } else {
                                    echo "<div class='errmessage p-0 rounded text-center text-danger'> <p> Username or Teacher/Student ID already exist </p> </div>";
                                }
                            }
                        }
                        
                    }   
                    
                ?>
                <div class="row">
                    <div class="col">
                        <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="fname" placeholder="First Name" required>
                        <label for="floatingInput">First Name</label>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="lname" placeholder="Last Name" required>
                        <label for="floatingInput">Last Name</label>
                        </div>
                    </div>
                </div>
                
                
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="username" placeholder="Username" required>
                    <label for="floatingInput">Username</label>
                </div>

                <div class="row">
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" name="password" required placeholder="Password">
                            <label for="floatingPassword">Password</label>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-floating">
                            <input type="password" class="form-control" name="cpassword" required placeholder="Re-type Password">
                            <label for="floatingPassword">Re-type Password</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <select name="usertype" class="form-select" aria-label="Default select example">
                            <option value="false" selected>Select User Type</option>
                            <option value="admin">Admin</option>
                            <option value="student assistant">Student Assistant</option>
                        </select>
                    </div>

                    <div class="col">
                        <select name="status" class="form-select" aria-label="Default select example">
                            <option value="false" selected>Set Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-floating my-3">
                    <input type="text" name="tsid" class="form-control" placeholder="Teacher / Student ID" required>
                    <label for="floatingPassword">Teacher / Student ID</label>
                </div>
                
                <button type="submit" name="adduserSubmit" class="btn btn-success d-inline-block w-100">Create User</button>
            </form>
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