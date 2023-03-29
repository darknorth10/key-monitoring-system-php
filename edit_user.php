<?php
    
    require('connection.php');
    session_start();
    
    $editUserid = (int)$_SESSION['userid'];

    if (empty($editUserid)) {
        header('Location: main.php#userManagement');
    }
   


    $sql = "SELECT * FROM user_tbl WHERE user_id = '$editUserid'";

    $result2 = mysqli_query($conn, $sql);
    $rez = mysqli_fetch_assoc($result2); 

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
                <a href='main.php#userManagement' class="navbar-brand" href="#" style="font-family: 'Poppins'; font-size:0.9rem; letter-spacing:1px;">
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
                <h6>Edit User</h6>
            </div>
            <form class="p-3" method="post" id="add_user_form">
                <?php

                    #validations error
                    if (isset($_POST['adduserSubmit'])) {
                        $fname = $_POST['fname'];
                        $lname = $_POST['lname'];
                        $usertype = $_POST['usertype'];
                        $status = $_POST['status'];


                        if (empty($fname) || empty($lname) || empty($usertype) || empty($status)) {
                                echo "<div class='errmessage p-0 rounded text-center text-danger'> <p> All fields are required </p> </div>";
                        } else {

                            if ($usertype == "false" || $status == "false") {
                                echo "<div class='errmessage p-0 rounded text-center text-danger'> <p> Select options for user type or status </p> </div>";
                            } else {
                                $query = "UPDATE user_tbl SET first_name = '$fname', last_name = '$lname', user_type = '$usertype', status = '$status' WHERE user_id = '$editUserid'";
                                mysqli_query($conn, $query);

                                header('location: main.php#userManagement');
                            }
                        }
                        
                    }   
                    
                ?>
                <div class="row">
                    <div class="col">
                        <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="fname" placeholder="First Name" value='<?php echo $rez['first_name'];  ?>' required>
                        <label for="floatingInput">First Name</label>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="lname" placeholder="Last Name" value='<?php echo $rez['last_name'];  ?>' required>
                        <label for="floatingInput">Last Name</label>
                        </div>
                    </div>
                </div>
                


                <div class="row mb-3">
                    <div class="col">
                        <select name="usertype" class="form-select" aria-label="Default select example" value='<?php echo $rez['user_type'];  ?>'>
                            <option value="false">Select User Type</option>
                            <option value="admin">Admin</option>
                            <option value="student assistant">Student Assistant</option>
                        </select>
                    </div>

                    <div class="col">
                        <select name="status" class="form-select" aria-label="Default select example" value='<?php echo $rez['status'];  ?>'>
                            <option value="false">Set Status</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                
                <button type="submit" name="adduserSubmit" class="btn btn-success d-inline-block w-100">Update User</button>
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