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
                        echo "<td>" . $res['student_teacher_id'] . "</td>";
                        
                        if($res['status'] == 'active') {
                            echo "<td class='text-success'>" . $res['status'] . "</td>";
                        } else {
                            echo "<td class='text-danger'>" . $res['status'] . "</td>";
                        }
            
                        echo "<td>
                          <form method='post' action='edit_user_action.php'>
                          <input type='hidden' name='userid' value=" . $res['user_id'] . "'>" .
                          "<button type='submit' class='edituser btn btn-primary rounded-pill px-4 py-1 m-0' href='#'
                          id='editUser'>EDIT</button>
                          </form></td></tr>";
                    }

                ?>

        </table>
    </div>
</div>