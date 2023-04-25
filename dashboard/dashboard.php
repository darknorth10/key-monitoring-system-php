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
        

        <!-- Room Status -->
        <div class="room_table h-100 w-100 mx-auto bg-white rounded shadow-sm mt-4 overflow-scroll">
            <table class="table rounded table-primary table-striped">
                <tr class="table-dark position-sticky top-0">
                    <th>Room No.</th>
                    <th>Room Category</th>
                    <th>Floor</th>
                    <th>Room Status</th>
                    <th class="ps-5">Actions</th>
        
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
                                echo "<td class='text-success'><i class='fa-solid fa-circle me-3'></i>" . $res['room_status'] . "</td>";
                            } else  if ($res['room_status'] == 'Unavailable') {
                                echo "<td class='text-danger'><i class='fa-solid fa-circle me-3'></i>" . $res['room_status'] . "</td>";
                            } else {
                                echo "<td class='text-secondary'><i class='fa-solid fa-circle me-3'></i>" . $res['room_status'] . "</td>";

                            }
                            if($res['room_status'] == 'Available') {
                                echo "<td><form method='post' action='dashboard/getRoomId.php'> <input type='hidden' name='getroomid' value='" . $res['room_no'] . "'/>
                            <button type='submit' class='editroom btn btn-primary rounded-pill px-4 py-1 m-0'>Borrow Key</button>
                            </form></td></tr>";
                            } else  if ($res['room_status'] == 'Unavailable') {
                                echo "<td><form method='post' action='dashboard/getReturnkey.php'> <input type='hidden' name='getroomid' value='" . $res['room_no'] . "'/>
                            <button type='submit' class='editroom btn btn-danger rounded-pill px-4 py-1 m-0'>Return Key</button>
                            </form></td></tr>";
                            } else {
                                echo "<td class='text-secondary'></td></tr>";
                            }
                            


                        }

                    ?>

            </table>
        </div>
    
    </div>
</div>