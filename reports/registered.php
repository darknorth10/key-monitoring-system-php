<div class="main-borrow h-100 w-100 bg-light p-2">

    <div class="room_table h-75 bg-white rounded shadow-sm mt-4 overflow-scroll">

        <table class="table rounded table-secondary table-striped table-bordered">
            <tr class="table-primary position-sticky top-0">
                <th>Transaction No.</th>
                <th>Borrower ID</th>
                <th>Full Name</th>
                <th>Room No.</th>
                <th>Date & Time Borrowed</th>
                <th>Date & Time Returned</th>
                <th>Status</th>
            </tr>
                <?php
                    $sql = "SELECT transaction_tbl.transaction_no, transaction_tbl.borrowers_id, borrowers_tbl.firstname, borrowers_tbl.lastname, transaction_tbl.room_no, transaction_tbl.date_time_barrowed, transaction_tbl.date_time_returned, transaction_tbl.transaction_status
                     FROM transaction_tbl INNER JOIN borrowers_tbl ON transaction_tbl.borrowers_id = borrowers_tbl.stud_employee_no";

                    $result = mysqli_query($conn, $sql);

                    while($res = mysqli_fetch_assoc($result)) {
                        echo "<tr><td class='text-center'>" . $res['transaction_no'] . "</td>";
                        echo "<td>" . $res['borrowers_id'] . "</td>";
                        echo "<td class='ps-5'>" . $res['firstname'] . " " . $res['lastname'] . "</td>";
                        echo "<td class='ps-4'>" . $res['room_no'] . "</td>";
                        echo "<td class='ps-4'>" . $res['date_time_barrowed'] . "</td>";
                        echo "<td class='ps-4'>" . $res['date_time_returned'] . "</td>";
                        echo "<td class='ps-4 text-primary'>" . $res['transaction_status'] . "</td></tr>";
                    }

                ?>


        </table>
    </div>
</div>