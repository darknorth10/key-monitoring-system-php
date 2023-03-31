<div class="main-borrowers h-100 w-100 bg-light p-2 overflow-hidden">
    <div class="actionbar w-100 d-inline-flex justify-content-end">
        <a href="borrowers/add_borrowers.php" class="btn btn-success shadow-sm rounded-pill" style="font-size: 0.8em;">+ Add New Borrower</a>
    </div>
    <div class="user_table h-75 bg-white rounded shadow-sm mt-4 overflow-scroll">

        <table class="table table-success table-striped rounded">
            <tr class="table-dark text-light position-sticky top-0">
                <th>Student No.</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Course</th>
                <th>Year & Section</th>
                <th>Eligibility</th>
                <th>Action</th>
            </tr>
                <?php
                    $sql = "SELECT * FROM borrowers_tbl WHERE borrowers_type = 'student' ORDER BY course";

                    $result = mysqli_query($conn, $sql);

                    while($res = mysqli_fetch_assoc($result)) {
                        echo "<tr class='text-center'><td>" . $res['stud_employee_no'] . "</td>";
                        echo "<td>" . $res['firstname'] . "</td>";
                        echo "<td>" . $res['lastname'] . "</td>";
                        echo "<td>" . $res['course'] . "</td>";
                        echo "<td>" . $res['section'] . "</td>";
                        
                        if($res['eligibility'] == 'eligible') {
                            echo "<td class='text-primary'>" . $res['eligibility'] . "</td>";
                        } else {
                            echo "<td class='text-danger'>" . $res['eligibility'] . "</td>";
                        }
            
                        echo "<td class='d-flex justify-content-center'>
                          <form method='post' action='borrowers/get_borrower_no.php' class='me-2'>
                          <input type='hidden' name='borrowerid' value='" . $res['stud_employee_no'] . "'>" .
                          "<input type='hidden' name='action' value='updateStudent'>" .
                          "<button type='submit' class='edituser btn btn-primary shadow-sm rounded-pill px-3 py-1 m-0'
                          >EDIT<img class='ms-2 mb-1' src='assets/images/editing.png' height='15' width='15'></button>
                          </form></td></tr>";
                    }

                ?>


        </table>
    </div>
</div>