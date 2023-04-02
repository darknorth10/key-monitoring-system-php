<?php
    session_start();

    if (empty($_SESSION['user'])) {
        header('location: ../index.php');
    }

        if($_SESSION['usertype'] == 'assistant') {
        header('Location: ../assistant.php');

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
                <a class="navbar-brand" href="main.php#rooms" style="font-family: 'Poppins'; font-size:0.9rem; letter-spacing:1px;">
                <img src="../assets/images/key.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top mx-3">
                Key Monitoring | Add Room
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

        <a class="btn btn-dark mx-4 my-3" href="../main.php#rooms" style="font-family:'Poppins'; font-size:0.7rem; width:7%;">BACK</a>

        <div class="add_user card shadow-sm w-50 mx-auto p-0 mt-3">
            <div class="card-header pt-3 bg-primary text-white">
                <h6>Register New Room</h6>
            </div>
            <form class="p-3" method="post" id="add_room_form">

                <?php
                    require('../connection.php');


                    #validations error
                    if (isset($_POST['addroomSubmit'])) {
                        $roomNum = mysqli_escape_string($conn, $_POST['roomnum']);
                        $category = mysqli_escape_string($conn, $_POST['roomcat']);
                        $floor = mysqli_escape_string($conn, $_POST['floor']);
                        $status = mysqli_escape_string($conn, $_POST['roomstatus']);

                        $query = "SELECT * FROM room_tbl WHERE room_no = '$roomNum'";
                        
                        if (empty($roomNum) || $category == 'false' || $floor == 'false' || $status == 'false') {
                            echo "<div class='errmessage p-0 rounded text-center text-danger'> <p> All Fields are required. </p> </div>";
                        } else  {

                            $result = mysqli_query($conn, $query);

                            if(mysqli_num_rows($result) == 0) {
                                $sql = "INSERT INTO `room_tbl`(`room_no`, `room_category`, `floor`, `room_status`) VALUES ('$roomNum','$category','$floor','$status')";
                                mysqli_query($conn, $sql);

                                echo "<div class='succmessage p-0 rounded text-center text-success'> <p> Room has been registered. </p> </div>";

                            } else {
                                echo "<div class='errmessage p-0 rounded text-center text-danger'> <p> Room with same room number already exist. </p> </div>";
                            }
                        }
                    }
                    
                ?>
                

                <div class="row">
                    <div class="col">
                        <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="roomnum" placeholder="First Name" required>
                        <label for="floatingInput">Room Number</label>
                        </div>
                    </div>

                    <div class="col">
                        <select name="roomcat" class="form-select" aria-label="Default select example">
                            <option value="false" selected>Room Category</option>
                            <option value="Lecture">Lecture</option>
                            <option value="Laboratory">Laboratory</option>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <select name="floor" class="form-select" aria-label="Default select example">
                            <option value="false" selected>Floor Located</option>
                            <option value="1st">1st</option>
                            <option value="2nd">2nd</option>
                            <option value="3rd">3rd</option>
                            <option value="4th">4th</option>
                        </select>
                    </div>

                    <div class="col">
                        <select name="roomstatus" class="form-select" aria-label="Default select example">
                            <option value="false" selected>Room Status</option>
                            <option value="Available">Available</option>
                            <option value="Unavailable">Unavailable</option>
                        </select>
                    </div>
                </div>
                
                
                <button type="submit" name="addroomSubmit" class="btn btn-success d-inline-block w-100">Register Room</button>
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