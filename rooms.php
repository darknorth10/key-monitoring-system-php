<div class="main-room h-100 w-100 bg-light p-2">
    <div class="actionbar w-100 d-inline-flex justify-content-end">
        <a href="add_user.php" class="btn btn-primary rounded-pill" style="font-size: 0.8em;">+ Add New Room</a>
    </div>
    <div class="room_table h-75 bg-white rounded shadow-sm mt-4">
        <table class="table rounded">
            <tr class="table-primary">
                <th>Room No.</th>
                <th>Room Category</th>
                <th>Floor</th>
                <th>Room Status</th>
            </tr>
                <?php
                    
                    require('connection.php');

                    $sql = "SELECT * FROM room_tbl ORDER BY room_no DESC";

                    $result = mysqli_query($conn, $sql);

                    while($res = mysqli_fetch_array($result)) {
                        echo "<tr><td>" . $res['room_no'] . "</td>";
                        echo "<td>" . $res['room_category'] . " " . $res['last_name'] . "</td>";
                        echo "<td>" . $res['floor'] . "</td>";
                        echo "<td>" . $res['room_status'] . "</td>";
                        echo "<td><a class='editroom btn btn-primary rounded-pill px-4 py-1 m-0' href='#'>EDIT</a></td></tr>";
                    }

                ?>

        </table>
    </div>
</div>