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
                    $sql = "SELECT * from transaction_tbl where non_faculty = 'false'";

                    $result = mysqli_query($conn, $sql);

                    while($res = mysqli_fetch_assoc($result)) {
                        echo "<tr><td class='text-center'>" . $res['transaction_no'] . "</td>";
                        echo "<td>" . $res['borrowers_id'] . "</td>";
                        echo "<td class='ps-5'>" . $res['fullname'] . "</td>";
                        echo "<td class='ps-4'>" . $res['room_no'] . "</td>";
                        echo "<td class='ps-4'>" . $res['date_time_barrowed'] . "</td>";
                        echo "<td class='ps-4'>" . $res['date_time_returned'] . "</td>";
                        echo "<td class='ps-4 text-primary'>" . $res['transaction_status'] . "</td></tr>";
                    }

                ?>


        </table>
    </div>
</div>