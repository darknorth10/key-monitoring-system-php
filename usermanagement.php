<div class="main-usermanagement h-100 w-100 bg-light p-2">
    <div class="actionbar w-100 d-inline-flex justify-content-end">
        <a href="add_user.php" class="btn btn-primary rounded-pill" style="font-size: 0.8em;">+ Add New User</a>
    </div>
    <div class="user_table h-75 bg-white rounded shadow-sm mt-4">
        <table class="table rounded">
            <tr class="table-primary">
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>User Type</th>
                <th>Teacher / Student ID</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
                <?php
                    
                    require('connection.php');

                    $sql = "SELECT * FROM user_tbl ORDER BY user_id DESC";

                    $result = mysqli_query($conn, $sql);

                    while($res = mysqli_fetch_array($result)) {
                        echo "<tr><td>" . $res['user_id'] . "</td>";
                        echo "<td>" . $res['first_name'] . " " . $res['last_name'] . "</td>";
                        echo "<td>" . $res['username'] . "</td>";
                        echo "<td>" . $res['user_type'] . "</td>";
                        if($res['user_type'] == 'admin'){
                            echo "<td>" . $res['teacher_id'] . "</td>";
                        } else {
                            echo "<td>" . $res['student_id'] . "</td>";
                        }
                        echo "<td>" . $res['status'] . "</td>";
                        echo "<td><a class='edituser btn btn-primary rounded-pill px-4 py-1 m-0' href='#'
                          id='editUser'>EDIT</a></td></tr>";
                    }

                ?>

        </table>
    </div>
</div>