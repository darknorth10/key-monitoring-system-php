<div class="main-reeturn h-100 w-100 bg-light p-2 overflow-y-scroll">
    <div class="borrowform rounded shadow-sm w-100" style="font-family: 'Poppins'; background-color:  #e0e0e0;">
        <h6 class="bg-success rounded ps-4 py-3" style="font-size: 0.9em; color: white;">Return Key</h6>
        <form class="px-4 py-3" method="post">
            <?php
                if (isset($_POST['returnSubmit'])) {
                    $roomNo = $_POST['roomNo'];

                    if ($roomNo == 'false') {
                        echo "<div class='errmessage p-0 rounded text-center text-danger shadow-sm'> <p> All selection are required. </p> </div>";
                        
                    } else {
                        $sqlCheck = "SELECT * FROM transaction_tbl WHERE room_no = '$roomNo' AND transaction_status = 'borrowed'";
                        $result1 = mysqli_query($conn, $sqlCheck);
                        $res1 = mysqli_fetch_assoc($result1);
                        $borrowerNo = $res1['borrowers_id'];
                        // 2 validation errors for returning key
                        if(mysqli_num_rows($result1) == 1 ) {
                            // update transaction, room and borrower status
                            mysqli_query($conn, "UPDATE room_tbl SET room_status = 'Available' WHERE room_no = '$roomNo'");
                            mysqli_query($conn, "UPDATE borrowers_tbl SET eligibility = 'eligible' WHERE stud_employee_no = '$borrowerNo'");
                            mysqli_query($conn, "UPDATE transaction_tbl SET date_time_returned = now(), transaction_status = 'returned' WHERE room_no = '$roomNo' AND transaction_status = 'borrowed'");

                            echo "<div class='succmessage p-0 rounded text-center text-dark shadow-sm'> <p> Key has been returned successfully. </p> </div>";

                        } else if(mysqli_num_rows($result1) == 0 ) {
                            echo "<div class='errmessage p-0 rounded text-center text-danger shadow-sm'> <p> Selected room was not in the borrowed list. </p> </div>";                            

                        }  else {
                            echo "<div class='errmessage p-0 rounded text-center text-danger shadow-sm'> <p> Internal Error : Try again later. </p> </div>";

                        }
                    }
                }



            ?>
                <div class="borrowform row">

                    <div class="col">
                        <select name="roomNo" class="form-select" aria-label="Default select example">
                            <option value="false" selected>Select Room No.</option>
                            <?php
                            // list of available rooms
                                $sqlRoomNo = "SELECT room_no FROM transaction_tbl WHERE transaction_status = 'borrowed'";

                                $resultRoomNo = mysqli_query($conn, $sqlRoomNo);

                                while($res = mysqli_fetch_assoc($resultRoomNo)) {
                                    echo "<option value='" . $res['room_no'] . "'>".  "Room " . $res['room_no'] . "</option>";
                                }

                            ?>
                        </select>
                    </div>

                    <div class="col">
                        <button type="submit" name="returnSubmit" class="btn btn-success shadow-sm w-100">Return Key <img src="assets/images/key3.png" width="15" height='15'></button>
                    </div>

                </div>
        </form>
    </div>
    <div class="user_table h-75 bg-white rounded shadow-sm mt-4 overflow-scroll">

        <table class="table rounded table-secondary table-striped table-bordered">
            <tr class="table-success position-sticky top-0">
                <th>Transaction No.</th>
                <th>Borrower ID</th>
                <th>Full Name</th>
                <th>Borrower Type</th>
                <th>Room No.</th>
                <th>Date & Time Borrowed</th>
                <th>Status</th>
            </tr>
                <?php
                    $sql = "SELECT transaction_tbl.transaction_no, transaction_tbl.borrowers_id, borrowers_tbl.firstname, borrowers_tbl.lastname, borrowers_tbl.borrowers_type,  transaction_tbl.room_no, transaction_tbl.date_time_barrowed, transaction_tbl.date_time_returned, transaction_tbl.transaction_status
                     FROM transaction_tbl INNER JOIN borrowers_tbl ON transaction_tbl.borrowers_id = borrowers_tbl.stud_employee_no WHERE transaction_status = 'borrowed'";

                    $result = mysqli_query($conn, $sql);

                    while($res = mysqli_fetch_assoc($result)) {
                        echo "<tr><td class='text-center'>" . $res['transaction_no'] . "</td>";
                        echo "<td class='ps-5'>" . $res['borrowers_id'] . "</td>";
                        echo "<td class='ps-5'>" . $res['firstname'] . " " . $res['lastname'] . "</td>";
                        echo "<td class='ps-5'>" . $res['borrowers_type'] . "</td>";
                        echo "<td class='ps-5'>" . $res['room_no'] . "</td>";
                        echo "<td class='ps-5'>" . $res['date_time_barrowed'] . "</td>";
                        echo "<td class='ps-5 text-primary'>" . $res['transaction_status'] . "</td></tr>";
                    }

                ?>


        </table>
    </div>
</div>