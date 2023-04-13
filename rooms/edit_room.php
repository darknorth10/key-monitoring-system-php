<?php
    session_start();

    if($_SESSION['usertype'] != 'admin') {
        header('Location: ../assistant.php');
    }
    if (empty($_SESSION['user']) || empty($_SESSION['getroomid'])) {
        header('location: ../index.php');
    }
    $getroomid = $_SESSION['getroomid'];

    require('../connection.php');

    $sql = "SELECT * FROM room_tbl WHERE room_no = '$getroomid'";

    $res = mysqli_query($conn, $sql);

    $result = mysqli_fetch_assoc($res);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Key Monitoring | Edit Room</title>

    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400&family=Poppins:wght@300&display=swap" rel="stylesheet">
    <!-- bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- custom styles -->
    <link rel="stylesheet" href="../css/styles.css">

</head>
<body>
    <!-- main div wrapper -->

    <div class="main-wrapper bg-secondary d-flex flex-column h-100 w-100 p-0 m-0">

        <!-- header -->
        <nav class="navbar bg-dark" data-bs-theme="dark">
            <div class="container-fluid py-1 ps-1 pe-2">
                <a class="navbar-brand" href="main.php#rooms" style="font-family: 'Poppins'; font-size:0.9rem; letter-spacing:1px;">
                <img src="../assets/images/key.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top mx-3">
                Key Monitoring | Edit Room
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

        <div class="add_user card bg-white w-50 mx-auto p-0 mt-3">
            <div class="card-header pt-3 bg-primary text-white">
                <h6>Edit Room : <span class="border rounded px-2 py-1"><?php echo $result['room_no'];?></h6>
            </div>
            <form class="p-3" method="post" id="edit_room_form">

                <?php

                    #validations error
                    if (isset($_POST['editroomSubmit'])) {
                        $category = $_POST['roomcat'];
                        $status = $_POST['roomstatus'];

                        $sql = "SELECT * FROM room_tbl WHERE room_no = '$getroomid'";

                        $result = mysqli_fetch_assoc(mysqli_query($conn, $sql));

                        if($result['room_category'] == $category && $result['room_status'] == $status){
                            echo "<div class='succmessage p-0 rounded text-center text-dark'> <p> No Changes Detected. </p> </div>";
                        } else {
                            $sql = "UPDATE room_tbl SET room_category = '$category', room_status = '$status' WHERE room_no = '$getroomid'";
                            mysqli_query($conn, $sql);

                            $curr_user = $_SESSION['user'];

                            mysqli_query($conn, "INSERT INTO `audit_tbl`(`user`, `action`) VALUES ('$curr_user', 'Room $getroomid has been updated')");

                            header('location: ../main.php#rooms');
                        }
                    }
                    
                ?>
                

                <div class="row mb-3">
                    <div class="col">
                    <select name="roomcat" class="form-select text-center" aria-label="Default select example">
                            <?php
                                if ($result['room_category'] == "Lecture") {
                                    echo "<option value='Lecture' selected>Lecture</option>
                                    <option value='Laboratory'>Laboratory</option>";
                                } else {
                                    echo "<option value='Lecture'>Lecture</option>
                                    <option value='Laboratory' selected>Laboratory</option>";
                                }
                            ?>
                        </select>
                    </div>

                    <div class="col">
                        <select name="roomstatus" class="form-select" aria-label="Default select example">
                            <?php
                                if ($result['room_status'] == "Available") {
                                    echo "<option value='Available' selected>Available</option>
                                    <option value='Unavailable'>Unavailable</option>";
                                } else if ($result['room_status'] == "Unavailable") {
                                    echo "<option value='Available'>Available</option>
                                    <option value='Unavailable' selected>Unavailable</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                
                
                <button type="submit" name="editroomSubmit" class="btn btn-success d-inline-block w-100 mt-2 mb-3">Update Room</button>
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