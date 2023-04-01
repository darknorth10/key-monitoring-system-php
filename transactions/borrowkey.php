<div class="main-borrow h-100 w-100 bg-light p-2 overflow-y-scroll">
    <div class="borrowform rounded shadow-sm w-100" style="font-family: 'Poppins'; background-color:  #e0e0e0;">
        <h6 class="bg-primary rounded ps-4 py-3" style="font-size: 0.9em; color: white;">New Transaction</h6>
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

                            // update room and borrower status
                            mysqli_query($conn, "UPDATE room_tbl SET room_status = 'Unavailable' WHERE room_no = '$roomNo'");
                            mysqli_query($conn, "UPDATE borrowers_tbl SET eligibility = 'ineligible' WHERE stud_employee_no = '$borrowerNo'");

                            echo "<div class='succmessage p-0 rounded text-center text-dark shadow-sm'> <p> Key has been borrowed successfully. </p> </div>";

                        }  else {
                            echo "<div class='errmessage p-0 rounded text-center text-danger shadow-sm'> <p> Internal Error : Try again later. </p> </div>";

                        }
                    }
                }



            ?>
                <div class="borrowform row">
                    <div class="col">
                        <select name="borrowerNo" class="form-select" aria-label="Default select example">
                            <option value="false" selected>Select Student / Employee No.</option>
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

                    <div class="col">
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
        </form>
    </div>
    <div class="user_table h-75 bg-white rounded shadow-sm mt-4 overflow-scroll">

        <table class="table rounded table-secondary table-striped table-bordered">
            <tr class="table-primary position-sticky top-0">
                <th>Transaction No.</th>
                <th>Borrower ID</th>
                <th>Full Name</th>
                <th>Borrower Type</th>
                <th>Room No.</th>
                <th>Date & Time Borrowed</th>
                <th>Date & Time Returned</th>
                <th>Status</th>
            </tr>
                <?php
                    $sql = "SELECT transaction_tbl.transaction_no, transaction_tbl.borrowers_id, borrowers_tbl.firstname, borrowers_tbl.lastname, borrowers_tbl.borrowers_type,  transaction_tbl.room_no, transaction_tbl.date_time_barrowed, transaction_tbl.date_time_returned, transaction_tbl.transaction_status
                     FROM transaction_tbl INNER JOIN borrowers_tbl ON transaction_tbl.borrowers_id = borrowers_tbl.stud_employee_no";

                    $result = mysqli_query($conn, $sql);

                    while($res = mysqli_fetch_assoc($result)) {
                        echo "<tr><td class='text-center'>" . $res['transaction_no'] . "</td>";
                        echo "<td>" . $res['borrowers_id'] . "</td>";
                        echo "<td class='ps-5'>" . $res['firstname'] . " " . $res['lastname'] . "</td>";
                        echo "<td class='ps-4'>" . $res['borrowers_type'] . "</td>";
                        echo "<td class='ps-4'>" . $res['room_no'] . "</td>";
                        echo "<td class='ps-4'>" . $res['date_time_barrowed'] . "</td>";
                        echo "<td class='ps-4'>" . $res['date_time_returned'] . "</td>";
                        echo "<td class='ps-4 text-primary'>" . $res['transaction_status'] . "</td></tr>";
                    }

                ?>


        </table>
    </div>
</div>