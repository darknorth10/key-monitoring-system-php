<?php
    require('connection.php');

    $sqlaudit  = "SELECT * FROM audit_tbl order by audit_id desc";

    $audit = mysqli_query($conn, $sqlaudit);


?>

<div class="main-borrow h-100 w-100 bg-light p-2">

    <div class="room_table h-75 bg-white rounded shadow-sm mt-4 overflow-scroll">

        <table class="table rounded table-secondary table-striped table-bordered">
            <tr class="table-danger position-sticky top-0">
                <th class="text-center">Trailing ID</th>
                <th>User</th>
                <th>Action</th>
                <th>Date & Time Executed</th>

            </tr>
                <?php
                    
                    while($res = mysqli_fetch_assoc($audit)) {
                        echo "<tr><td class='text-center'>" . $res['audit_id'] . "</td>";
                        echo "<td>" . $res['user'] . "</td>";
                        echo "<td>" . $res['action'] . "</td>";
                        echo "<td class='ps-4'>" . $res['date_occured'] . "</td></tr>";
                    }

                ?>


        </table>
    </div>
</div>