<div class="main-usermanagement h-100 w-100 bg-light p-2 overflow-hidden">
    <div class="actionbar w-100 d-inline-flex justify-content-end">
        <a href="usermanagement/add_user.php" class="btn btn-primary rounded-pill" style="font-size: 0.8em;">+ Add New User</a>
    </div>
    <div class="user_table h-75 bg-white rounded shadow-sm mt-4 overflow-scroll">

        <table class="table rounded table-secondary table-striped table-bordered">
            <tr class="table-primary position-sticky top-0">
                <th>ID</th>
                <th>Name</th>
                <th>Username</th>
                <th>User Type</th>
                <th>Teacher / Student ID</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
                <?php
                    $sql = "SELECT * FROM user_tbl ORDER BY user_id DESC";

                    $result = mysqli_query($conn, $sql);

                    while($res = mysqli_fetch_assoc($result)) {
                        echo "<tr><td>" . $res['user_id'] . "</td>";
                        echo "<td class='ps-5'>" . $res['first_name'] . " " . $res['last_name'] . "</td>";
                        echo "<td class='ps-5'>" . $res['username'] . "</td>";
                        echo "<td class='ps-5'>" . $res['user_type'] . "</td>";
                        echo "<td>" . $res['student_teacher_id'] . "</td>";
                        
                        if($res['status'] == 'active') {
                            echo "<td class='text-success'>" . $res['status'] . "</td>";
                        } else {
                            echo "<td class='text-danger'>" . $res['status'] . "</td>";
                        }
            
                        echo "<td class='d-flex justify-content-center'>
                          <form method='post' action='usermanagement/edit_user_action.php' class='me-2'>
                          <input type='hidden' name='userid' value='" . $res['user_id'] . "'>" .
                          "<input type='hidden' name='action' value='updateUser'>" .
                          "<button type='submit' class='edituser btn btn-primary rounded-pill px-3 py-1 m-0'
                          id='editUser'>EDIT <img class='ms-2 mb-1' src='assets/images/editing.png' height='15' width='15'></button>
                          </form>
                          <form method='post' action='usermanagement/edit_user_action.php'>" .
                          "<input type='hidden' name='userid' value='" . $res['user_id'] . "'>" .
                          "<input type='hidden' name='action' value='resetPass'>
                          <button type='submit' class='edituser btn btn-primary rounded-pill px-2 py-1 m-0'
                          id='editUser'>CHANGE PASSWORD <img class='ms-1' src='assets/images/reset-password.png' height='18' width='18'></button>
                          </form></td>
                          </tr>";
                    }

                ?>


        </table>
    </div>
</div>