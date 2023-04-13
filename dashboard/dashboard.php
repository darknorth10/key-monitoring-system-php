<div class="main-dashboard h-100 w-100 bg-light mt-4 p-2 overflow-y-auto">
    <?php
        $ar = "SELECT * FROM room_tbl WHERE room_status = 'Available'";
        $uk = "SELECT * FROM transaction_tbl WHERE transaction_status = 'borrowed'";
        $tt = "SELECT * FROM transaction_tbl";
        $arRes = mysqli_num_rows(mysqli_query($conn, $ar));
        $ukRes = mysqli_num_rows(mysqli_query($conn, $uk));
        $ttRes = mysqli_num_rows(mysqli_query($conn, $tt));
    ?>
    <div class="cards w-100 d-flex justify-content-evenly">
        <div class="shadow rounded border border-4 border-success w-25 ps-5 py-2 bg-white"><i class="fa fa-check-circle fa-lg text-success me-4"></i> Available Rooms | <?php echo $arRes; ?></div>
        <div class="shadow rounded border border-4 border-danger w-25 ps-5 py-2 bg-white"><i class="fa fa-exclamation-circle fa-lg text-danger me-4"></i> Unreturned Keys | <?php echo $ukRes; ?></div>
        <div class="shadow rounded border border-4 border-primary w-25 ps-5 py-2 bg-white"><i class="fa-solid fa-lg fa-arrow-right-arrow-left text-primary me-4"></i> Total Transactions | <?php echo $ttRes; ?></div>
    </div>

    
    <div class="transaction w-100 h-75 rounded mt-3 p-2">
        <!-- Borrow Room Key -->
        <div class="borrowform rounded shadow-sm w-100" style="font-family: 'Poppins'; background-color:  #e0e0e0;" id="registeredTransaction">
            <h6 class="bg-dark rounded ps-4 py-3" style="font-size: 0.9em; color: white;">Borrow Key</h6>
            <form class="px-4 py-3" method="post">
                <?php
                    if (isset($_POST['borrowSubmit'])) {
                        $borrowerNo = $_POST['borrowerNo'];
                        $roomNo = $_POST['roomNo'];

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
                                $insert = "INSERT INTO `transaction_tbl`(`borrowers_id`, `room_no`, `transaction_status`) VALUES ('$borrowerNo', '$roomNo', 'borrowed')";
                                mysqli_query($conn, $insert);

                                $curr_user = $_SESSION['user'];

                                mysqli_query($conn, "INSERT INTO `audit_tbl`(`user`, `action`) VALUES ('$curr_user', 'A Room has been borrowed')");

                                // update room and borrower status
                                mysqli_query($conn, "UPDATE room_tbl SET room_status = 'Unavailable' WHERE room_no = '$roomNo'");
                                mysqli_query($conn, "UPDATE borrowers_tbl SET eligibility = 'ineligible' WHERE stud_employee_no = '$borrowerNo'");

                                echo "<div class='succmessage p-0 rounded text-center text-dark shadow-sm'> <p> Key has been borrowed successfully. </p> </div>";

                            }  else {
                                echo "<div class='errmessage p-0 rounded text-center text-danger shadow-sm'> <p> Internal Error : Try again later. </p> </div>";

                            }
                        }
                    }

                    // Non registered Transaction

                    if (isset($_POST['borrowNonSubmit'])) {
                        $borrowerID = $_POST['borrowerID'];
                        $fullname = $_POST['fullname'];
                        $roomNum = $_POST['roomNum'];

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

                                $curr_user = $_SESSION['user'];
                                mysqli_query($conn, "INSERT INTO `audit_tbl`(`user`, `action`) VALUES ('$curr_user', 'A Room has been borrowed by a non-registered personnel.')");

                                // update room and borrower status
                                mysqli_query($conn, "UPDATE room_tbl SET room_status = 'Unavailable' WHERE room_no = '$roomNum'");

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
                                    $sqlBorrowerNo = "SELECT stud_employee_no FROM borrowers_tbl WHERE eligibility = 'eligible'";

                                    $resultBorrowerNo = mysqli_query($conn, $sqlBorrowerNo);

                                    while($res = mysqli_fetch_assoc($resultBorrowerNo)) {
                                        echo "<option value='" . $res['stud_employee_no'] . "'>". $res['stud_employee_no'] . "</option>";
                                    }

                                ?>
                            </select>
                        </div>

                        <div class="col d-flex">
                            <h6 class="m-2">Room</h6>
                            <select name="roomNo" class="form-select" aria-label="Default select example">
                                <option value="false" selected>Select Room No.</option>
                                <?php
                                // list of available rooms
                                    $sqlRoomNo = "SELECT room_no FROM room_tbl WHERE room_status = 'Available'";

                                    $resultRoomNo = mysqli_query($conn, $sqlRoomNo);

                                    while($res = mysqli_fetch_assoc($resultRoomNo)) {
                                        echo "<option value='" . $res['room_no'] . "'>". "Room ". $res['room_no'] . "</option>";
                                    }

                                ?>
                            </select>
                        </div>

                        <div class="col">   
                            <button type="submit" name="borrowSubmit" class="btn btn-primary shadow-sm w-100">Borrow Key <img src="assets/images/key3.png" width="15" height='15'></button>
                        </div>

                    </div>
                    
                    <a class="btn btn-dark px-3 my-2" style="font-size: 0.9rem;" data-bs-toggle="collapse" href="#nonRegTransaction" role="button" aria-expanded="false" aria-controls="nonRegTransaction">Non-Registered Borrower</a>
                    
                    
            </form>
            
        </div>


        <!-- Non Reg Transaction -->
        <div class="borrowform collapse rounded shadow-sm w-100 my-2" style="font-family: 'Poppins'; background-color:  #e0e0e0;" id="nonRegTransaction">
            <h6 class="bg-info rounded ps-4 py-3" style="font-size: 0.9em; color: white;">Borrow Key</h6>
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
                            <select name="roomNum" class="form-select" aria-label="Default select example">
                                <option value="false" selected>Select Room No.</option>
                                <?php
                                // list of available rooms
                                    $sqlRoomNo = "SELECT room_no FROM room_tbl WHERE room_status = 'Available'";

                                    $resultRoomNo = mysqli_query($conn, $sqlRoomNo);

                                    while($res = mysqli_fetch_assoc($resultRoomNo)) {
                                        echo "<option value='" . $res['room_no'] . "'>". "Room ". $res['room_no'] . "</option>";
                                    }
                                ?>
                            </select>
                        </div>
                        
                        <div class="col">
                            <button type="submit" name="borrowNonSubmit" class="btn btn-info shadow-sm w-100">Borrow Key <img src="assets/images/key3.png" width="15" height='15'></button>

                        </div>
                </div>

            </form>
        </div>

        

    <!-- Room Status -->
    <div class="room_table h-75 w-100 mx-auto bg-white rounded shadow-sm mt-4 overflow-scroll">
        <table class="table rounded table-primary table-striped">
            <tr class="table-dark position-sticky top-0">
                <th>Room No.</th>
                <th>Room Category</th>
                <th>Floor</th>
                <th>Room Status</th>
     
            </tr>
                <?php
                    require('connection.php');

                    $sqlroom = "SELECT * FROM room_tbl ORDER BY room_no";

                    $result = mysqli_query($conn, $sqlroom);

                    while($res = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . $res['room_no'] . "</td>";
                        echo "<td>" . $res['room_category'] . "</td>";
                        echo "<td>" . $res['floor'] . " Floor </td>";
                        if($res['room_status'] == 'Available') {
                            echo "<td class='text-success'><i class='fa-solid fa-circle me-3'></i>" . $res['room_status'] . "</td></tr>";
                        } else {
                            echo "<td class='text-danger'><i class='fa-solid fa-circle me-3'></i>" . $res['room_status'] . "</td></tr>";
                        }

                    }

                ?>

        </table>
    </div>
    
    </div>
</div>