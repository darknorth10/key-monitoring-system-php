<div class="main-room h-100 w-100 bg-light p-2">
    <div class="actionbar w-100 d-inline-flex justify-content-end">
        <a href="rooms/add_room.php" class="btn btn-primary rounded-pill" style="font-size: 0.8em;">+ Add New Room</a>
    </div>
    <div class="room_table h-75 w-75 mx-auto bg-white rounded shadow-sm mt-2 overflow-scroll">
        <table class="table rounded table-success table-striped">
            <tr class="table-primary position-sticky top-0">
                <th>Room No.</th>
                <th>Room Category</th>
                <th>Floor</th>
                <th>Room Status</th>
                <th class="ps-5">Action</th>
            </tr>
                <?php
                    require('connection.php');

                    $sql = "SELECT * FROM room_tbl ORDER BY room_no";

                    $result = mysqli_query($conn, $sql);

                    while($res = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . $res['room_no'] . "</td>";
                        echo "<td>" . $res['room_category'] . "</td>";
                        echo "<td>" . $res['floor'] . "</td>";
                        if($res['room_status'] == 'Available') {
                            echo "<td class='text-primary'>" . $res['room_status'] . "</td>";
                        } else {
                            echo "<td class='text-danger'>" . $res['room_status'] . "</td>";
                        }
                        
                        echo "<td><form method='post' action='rooms/get_room_id.php'> <input type='hidden' name='getroomid' value='" . $res['room_no'] . "'/>
                        <button type='submit' class='editroom btn btn-primary rounded-pill px-4 py-1 m-0'>EDIT<img class='ms-2 mb-1' src='assets/images/editing.png' height='15' width='15'></button>
                        </form></td></tr>";
                    }

                ?>

        </table>
    </div>
</div>