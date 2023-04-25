<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Key</title>

    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400&family=Poppins:wght@300&display=swap" rel="stylesheet">
    
    <!-- font-awesome -->
    <link rel="stylesheet" href="../css/fontawesome/css/all.min.css">

    <!-- bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- custom styles -->
    <style>
        .errmessage {
            font-size: 0.7rem;
            font-family: 'Poppins', sans-serif;
            background-color: rgb(242, 213, 213);
        }
        .errmessage p {
            padding: 10px;
        }
        .succmessage {
            font-size: 0.7rem;
            font-family: 'Poppins', sans-serif;
            background-color: rgb(228, 253, 247);
        }
        .succmessage p {
            padding: 10px;
        }
    </style>
    <script src="../css/bootstrap.bundle.min.js"></script>

</head>
<body>
    <div class="main w-100 bg-light">
        <!-- header -->
        <nav class="navbar bg-dark" data-bs-theme="dark">
            <div class="container-fluid py-1 ps-1 pe-2">
                <a class="navbar-brand" href="main.php" style="font-family: 'Poppins'; font-size:0.7rem; letter-spacing:1px;">
                <img src="../assets/images/key.png" alt="Logo" width="25" height="25" class="d-inline-block align-text-top mx-3">
                Key Monitoring
                </a>

                <div class="dropdown me-4 ">
                    <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.7rem;">
                        <?php
                            session_start();
                            echo $_SESSION['user'];
                            require('../connection.php')
                        ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" style="font-size: 0.7rem;">
                        <li><a class="dropdown-item text-center" href="../logout.php">Logout <img class='ms-2' src="../assets/images/logout.png" height="20" width="20"></a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <a href="<?php echo $userType = ($_SESSION['usertype'] == 'staff') ? '../staff.php' : '../main.php';?>" class="btn btn-dark px-3 py-2 m-2" style="font-family: 'Poppins'; width: 120px;">Back</a>
        
        <div class="main-return mx-auto my-3 h-100 w-75 bg-light p-2">
            <form class="borrowform rounded bg-white shadow-sm w-100" method="post" style="font-family: 'Poppins'; background-color:  #e0e0e0;">
                <h6 class="bg-success rounded ps-4 py-3" style="font-size: 0.9em; color: white;">Return Key : <span class="border rounded px-2 py-1">Room <?php echo $_SESSION['returnKey'];?></span></h6>
                    <?php
                        if (isset($_POST['returnSubmit'])) {
                            $roomNo = $_SESSION['returnKey'];

                          
                                $sqlCheck = "SELECT * FROM transaction_tbl WHERE room_no = '$roomNo' AND transaction_status = 'borrowed'";
                                $result1 = mysqli_query($conn, $sqlCheck);
                                $res1 = mysqli_fetch_assoc($result1);
                                $borrowerNo = $res1['borrowers_id'] ?? "";
                                // 2 validation errors for returning key
                                if(mysqli_num_rows($result1) == 1 ) {
                                    // update transaction, room and borrower status
                                    mysqli_query($conn, "UPDATE room_tbl SET room_status = 'Available' WHERE room_no = '$roomNo'");
                                    mysqli_query($conn, "UPDATE borrowers_tbl SET eligibility = 'eligible' WHERE stud_employee_no = '$borrowerNo'");
                                    mysqli_query($conn, "UPDATE transaction_tbl SET date_time_returned = now(), transaction_status = 'returned' WHERE room_no = '$roomNo' AND transaction_status = 'borrowed'");
                                    
                                    $curr_user = $_SESSION['user'];
                                    mysqli_query($conn, "INSERT INTO `audit_tbl`(`user`, `action`) VALUES ('$curr_user', 'Room $roomNo has been returned.')");

                                    if ($_SESSION['usertype'] == 'admin')
                                        header('location: ../main.php');
                                    else
                                        header('location: ../staff.php');

    
                                } else if(mysqli_num_rows($result1) == 0 ) {
                                    echo "<div class='errmessage p-0 rounded text-center text-danger shadow-sm'> <p> Selected room was not in the borrowed list. </p> </div>";                            

                                }  else {
                                    echo "<div class='errmessage p-0 rounded text-center text-danger shadow-sm'> <p> Internal Error : Try again later. </p> </div>";

                                }
                            }

                    ?>
             <p class="p-3 fs-4 text-center">Confirm to return key for room <?php echo $_SESSION['returnKey']; ?></p>
             <div class="d-flex justify-content-end pe-5 pb-4"><button type="submit" name="returnSubmit" class="btn btn-success px-4 py-2" style="width: 150px;">Confirm</button></div>
            </form>
        </div>
    </div>

</body>
</html>




