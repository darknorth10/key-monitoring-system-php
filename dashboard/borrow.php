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
        
        <div class="main-return mx-auto my-3 h-100 w-75 bg-light">
            <!-- Borrow Room Key -->
            <div class="borrowform rounded shadow-sm w-100" style="font-family: 'Poppins'; background-color:  #e0e0e0;" id="registeredTransaction">
                <h6 class="bg-dark rounded ps-4 py-3" style="font-size: 0.9em; color: white;">Borrow Key : <span class="border rounded px-2 py-1">Room <?php echo $_SESSION['borrowRoom'];?></span></h6>
                <form class="px-4 py-3" method="post">
                    <?php
                        if (isset($_POST['borrowSubmit'])) {
                            //splits the value of borrower number value into borrower number and fullname in the select element 
                            $splitValue = explode('?', $_POST['borrowerNo']);
                            $roomNo = $_SESSION['borrowRoom'];

                            $borrowerNo = $splitValue[0];
                            $fullname = $splitValue[1] ?? '';

                            if ($borrowerNo == 'false' || $roomNo == 'false') {
                                echo "<div class='errmessage p-0 rounded text-center text-danger shadow-sm'> <p> All selection are required. </p> </div>";
                                
                            } else {
                                $sqlCheck = "SELECT * FROM transaction_tbl WHERE room_no = '$roomNo' AND transaction_status = 'borrowed'";
                                $sqlCheck2 = "SELECT * FROM transaction_tbl WHERE borrowers_id = '$borrowerNo' AND transaction_status = 'borrowed'";
                                $result1 = mysqli_query($conn, $sqlCheck);
                                $result2 = mysqli_query($conn, $sqlCheck2);

                                // 2 validation errors for borrowing key
                                if(mysqli_num_rows($result1) != 0 ) {
                                    echo "<div class='errmessage p-0 rounded text-center text-danger shadow-sm'> <p> Selected room is currently not available. </p> </div>";
                                } else if(mysqli_num_rows($result2) != 0 ) {
                                    echo "<div class='errmessage p-0 rounded text-center text-danger shadow-sm'> <p> Selected borrower is currently not eligiblle to borrow. </p> </div>";
                                } else if(mysqli_num_rows($result1) == 0 &&  mysqli_num_rows($result2) == 0 ) {
                                    // borrowing the key
                                    $insert = "INSERT INTO `transaction_tbl`(`borrowers_id`, `room_no`, `transaction_status`, `fullname`) VALUES ('$borrowerNo', '$roomNo', 'borrowed', '$fullname')";
                                    mysqli_query($conn, $insert);

                                    $curr_user = $_SESSION['user'];

                                    mysqli_query($conn, "INSERT INTO `audit_tbl`(`user`, `action`) VALUES ('$curr_user', 'Room $roomNo has been borrowed by borrower $borrowerNo.')");

                                    // update room and borrower status
                                    mysqli_query($conn, "UPDATE room_tbl SET room_status = 'Unavailable' WHERE room_no = '$roomNo'");
                                    mysqli_query($conn, "UPDATE borrowers_tbl SET eligibility = 'ineligible' WHERE stud_employee_no = '$borrowerNo'");

                                    echo "<div class='succmessage p-0 rounded text-center text-dark shadow-sm'> <p> Key has been borrowed successfully by borrower : $borrowerNo. </p> </div>";

                                }  else {
                                    echo "<div class='errmessage p-0 rounded text-center text-danger shadow-sm'> <p> Internal Error : Try again later. </p> </div>";
                                }
                            }
                        }

                        // Non registered Transaction

                        if (isset($_POST['borrowNonSubmit'])) {
                            $borrowerID = $_POST['borrowerID'];
                            $fullname = $_POST['fullname'];
                            $roomNum = $_SESSION['borrowRoom'];

                            if (empty($borrowerID) || $roomNum == 'false' || empty($fullname)) {
                                echo "<div class='errmessage p-0 rounded text-center text-danger shadow-sm'> <p> All selection are required. </p> </div>";
                                
                            } else {
                                $sqlCheck = "SELECT * FROM transaction_tbl WHERE room_no = '$roomNum' AND transaction_status = 'borrowed'";
                                $sqlCheck2 = "SELECT * FROM transaction_tbl WHERE borrowers_id = '$borrowerID' AND transaction_status = 'borrowed'";
                                $sqlCheck3 = "SELECT * FROM borrowers_tbl WHERE stud_employee_no = '$borrowerID'";
                                $result1 = mysqli_query($conn, $sqlCheck);
                                $result2 = mysqli_query($conn, $sqlCheck2);
                                $result3 = mysqli_query($conn, $sqlCheck3);

                                // 2 validation errors for borrowing key
                                if(mysqli_num_rows($result1) != 0 ) {
                                    echo "<div class='errmessage p-0 rounded text-center text-danger shadow-sm'> <p> Selected room is currently not available. </p> </div>";
                                } else if(mysqli_num_rows($result3) != 0 ) {
                                    echo "<div class='errmessage p-0 rounded text-center text-danger shadow-sm'> <p> The ID you inserted is already registered. </p> </div>";
                                } else if(mysqli_num_rows($result2) != 0 ) {
                                    echo "<div class='errmessage p-0 rounded text-center text-danger shadow-sm'> <p> Selected borrower is currently not eligiblle to borrow. </p> </div>";
                                } else if(mysqli_num_rows($result1) == 0 &&  mysqli_num_rows($result2) == 0 ) {
                                    // borrowing the key
                                    $insert = "INSERT INTO `transaction_tbl`(`borrowers_id`, `room_no`, `transaction_status`, `non_faculty`, `fullname`) VALUES ('$borrowerID', '$roomNum', 'borrowed', 'true', '$fullname')";
                                    mysqli_query($conn, $insert);

                                    // update room and borrower status
                                    mysqli_query($conn, "UPDATE room_tbl SET room_status = 'Unavailable' WHERE room_no = '$roomNum'");

                                    $curr_user = $_SESSION['user'];
                                    mysqli_query($conn, "INSERT INTO `audit_tbl`(`user`, `action`) VALUES ('$curr_user', 'Room $roomNum has been borrowed by a non-registered personnel: $fullname with ID $borrowerID .')");

                                    

                                    echo "<div class='succmessage p-0 rounded text-center text-dark shadow-sm'> <p> Key has been borrowed successfully. </p> </div>";

                                }  else {
                                    echo "<div class='errmessage p-0 rounded text-center text-danger shadow-sm'> <p> Internal Error : Try again later. </p> </div>";

                                }
                            }
                        }



                    ?>  

                        <div class="borrowform row">
                            <div class="col d-flex">
                                <h6 class="m-2">Borrower</h6>
                                <select name="borrowerNo" class="form-select" aria-label="Default select example">
                                    <option value="false" selected>Select Teacher / Employee No.</option>
                                    <?php
                                    // list of id eligible for borrowing
                                        $sqlBorrowerNo = "SELECT stud_employee_no, firstname, lastname FROM borrowers_tbl WHERE eligibility = 'eligible'";

                                        $resultBorrowerNo = mysqli_query($conn, $sqlBorrowerNo);

                                        while($res = mysqli_fetch_assoc($resultBorrowerNo)) {
                                            echo "<option value='" . $res['stud_employee_no'] . '?' . $res['firstname'] . ' ' . $res['lastname'] . "'>". $res['stud_employee_no'] . "</option>";
                                        }

                                    ?>
                                </select>
                            </div>


                            <div class="col">   
                                <button type="submit" name="borrowSubmit" class="btn btn-primary shadow-sm w-100">Borrow Key <img src="assets/images/key3.png" width="15" height='15'></button>
                            </div>

                        </div>
                        
                        <a class="btn btn-dark w-25 my-3" style="font-size: 0.9rem;" data-bs-toggle="collapse" href="#nonRegTransaction" role="button" aria-expanded="false" aria-controls="nonRegTransaction">Non-Registered Borrower</a>
                        
                </form>
                
            </div>


                <!-- Non Reg Transaction -->
            <div class="borrowform collapse rounded shadow-sm w-100 my-2" style="font-family: 'Poppins'; background-color:  #e0e0e0;" id="nonRegTransaction">
                <h6 class="bg-primary rounded ps-4 py-3" style="font-size: 0.9em; color: white;">Borrow Key | Non-Registered : <span class="border rounded px-2 py-1">Room <?php echo $_SESSION['borrowRoom'];?></span></h6>
                <form method="post" class="px-4 py-3">
                    <!-- collapse form for non-registered borrower -->
                    <div class="row rounded" >
                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="borrowerID" placeholder="Teacher / Student ID" required>
                                    <label for="borrowerID">Teacher / Student ID</label>
                                </div>
                            </div>

                            <div class="col">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="fullname" placeholder="Full Name" required>
                                    <label for="fullname">Full Name</label>
                                </div>
                            </div>
                            
                            
                            <div class="col">
                                <button type="submit" name="borrowNonSubmit" class="btn btn-primary shadow-sm w-100">Borrow Key <img src="assets/images/key3.png" width="15" height='15'></button>

                            </div>
                    </div>

                </form>
            </div>
        </div>

      
    </div>

</body>
</html>




