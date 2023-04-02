<?php
    
    require('../connection.php');
    session_start();
    
    $editUserid = (int)$_SESSION['userid'];

    if (empty($editUserid)) {
        header('Location: ../main.php#userManagement');
    }
    if($_SESSION['usertype'] == 'assistant') {
        header('Location: ../assistant.php');

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
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- custom styles -->
    <link rel="stylesheet" href="../css/styles.css">

</head>
<body>

    
    <!-- main div wrapper -->

    <div class="main-wrapper d-flex flex-column h-100 w-100 p-0 m-0" style="background-color: #eee;">

        <!-- header -->
        <nav class="navbar bg-dark" data-bs-theme="dark">
            <div class="container-fluid py-1 ps-1 pe-2">
                <a href='main.php#userManagement' class="navbar-brand" href="#" style="font-family: 'Poppins'; font-size:0.9rem; letter-spacing:1px;">
                <img src="../assets/images/key.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top mx-3">
                    Key Monitoring | Edit User
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

        <div class="add_user card shadow-sm bg-white w-50 mx-auto p-0 mt-3">
            <div class="card-header pt-3 bg-primary text-white">
                <h6>Edit User : <span class="border rounded px-2 py-1"><?php echo $rez['username'] ."  |  ". $rez['student_teacher_id']; ?></span></h6>
            </div>
            <form class="p-3" method="post" id="edit_user_form">
                <?php

                    #validations error
                    if (isset($_POST['adduserSubmit'])) {
                        $fname = $_POST['fname'];
                        $lname = $_POST['lname'];
                        $usertype = $_POST['usertype'];
                        $status = $_POST['status'];


                        if (empty($fname) || empty($lname)) {
                            echo "<div class='errmessage p-0 rounded text-center text-danger'> <p> All fields are required </p> </div>";
                        } else if ($rez['first_name'] == $fname && $rez['last_name'] == $lname && $rez['user_type'] == $usertype && $rez['status'] == $status) {
                            echo "<div class='succmessage p-0 rounded text-center text-dark'> <p> No Changes Detected </p> </div>";
                        } 
                        else {
                            $query = "UPDATE user_tbl SET first_name = '$fname', last_name = '$lname', user_type = '$usertype', status = '$status' WHERE user_id = '$editUserid'";
                             mysqli_query($conn, $query);

                             header('location: ../main.php#userManagement');
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
                        <select name="usertype" class="form-select" aria-label="Default select example">
                        <?php
                            if ($rez['user_type'] == 'admin') {
                                echo "<option value='admin' selected>Admin</option>
                                <option value='student assistant'>Student Assistant</option>";
                            } else {
                                echo "<option value='admin'>Admin</option>
                                <option value='student assistant' selected >Student Assistant</option>";
                            }

                        ?>
                            
                        </select>
                    </div>

                    <div class="col">
                        <select name="status" class="form-select" aria-label="Default select example" value='<?php echo $rez['status'];  ?>'>
                        <?php
                            if ($rez['status'] == 'active') {
                                echo "<option value='active' selected>Active</option>
                                <option value='inactive'>Inactive</option>";
                            } else {
                                echo "<option value='active'>Active</option>
                                <option value='inactive' selected >Inactive</option>";
                            }

                        ?>
                        </select>
                    </div>
                </div>
                
                <button type="submit" name="adduserSubmit" class="btn btn-success d-inline-block w-100">Update User</button>
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