<?php
    session_start();

    if (empty($_SESSION['user'])) {
        header('location: ../index.php');
    }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Key Monitoring</title>

    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400&family=Poppins:wght@300&display=swap" rel="stylesheet">
    <!-- bootstrap -->
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <!-- custom styles -->
    <link rel="stylesheet" href="../css/styles.css">

</head>
<body>

    
    <!-- main div wrapper -->

    <div class="main-wrapper bg-light d-flex flex-column h-100 w-100 p-0 m-0">

        <!-- header -->
        <nav class="navbar bg-dark" data-bs-theme="dark">
            <div class="container-fluid py-1 ps-1 pe-2">
                <a class="navbar-brand" href="#" style="font-family: 'Poppins'; font-size:0.9rem; letter-spacing:1px;">
                <img src="../assets/images/key.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top mx-3">
                Key Monitoring | Add Borrower
                </a>

                <div class="dropdown me-4 ">
                    <button class="btn btn-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 0.7rem;">
                        <?php
                            echo $_SESSION['user'];
                        ?>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark" style="font-size: 0.7rem;">
                        <li><a class="dropdown-item text-center" href="../logout.php">Logout <img class='ms-2' src="../assets/images/logout.png" height="20" width="20"></a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <a class="btn btn-dark mx-4 mt-3" href="../main.php#borrowerStudent" style="font-family:'Poppins'; font-size:0.7rem; width:7%;">BACK</a>

        <div class="add_user card bg-white w-50 mx-auto p-0">
            <div class="card-header pt-3 bg-primary text-white">
                <h6>Add New Borrower</h6>
            </div>
            <form class="p-3" method="post" id="add_user_form">
                <?php
                    require('../connection.php');
                    #validations error
                    if (isset($_POST['addborrowerSubmit'])) {
                        $fname = $_POST['fname'];
                        $lname = $_POST['lname'];
                        $tsid = $_POST['tsid'];
                        $btype = $_POST['btype'];
                        $course = $_POST['course'];
                        $section = $_POST['section'];
                        $eligibility = $_POST['eligibility'];

                        // check if fields are empty
                        if (empty($fname) || empty($lname) || empty($tsid) || $btype == "false" || $course == "false" || $eligibility == "false") {
                            echo "<div class='errmessage p-0 rounded text-center text-danger'> <p> All Fields are required. </p> </div>";

                            // if selected type is student, section field is required
                            // else insert new borrower if given id does not exist yet
                        } else if($btype == "student") {
                            if(empty($section)) {
                                echo "<div class='errmessage p-0 rounded text-center text-danger'> <p> Section field is required for student. </p> </div>";
                            } else {
                                        $query = "SELECT * FROM borrowers_tbl WHERE stud_employee_no = '$tsid'";
                                        $result = mysqli_query($conn, $query);

                                        if(mysqli_num_rows($result) > 0) {
                                            echo "<div class='errmessage p-0 rounded text-center text-danger'> <p> Borrower with same Teacher or Student ID already exist. </p> </div>";

                                        } else {
                                            $sql = "INSERT INTO borrowers_tbl (stud_employee_no, firstname, lastname, borrowers_type, course, section, eligibility) VALUES ('$tsid', '$fname', '$lname', '$btype', '$course', '$section', '$eligibility')";
                                            mysqli_query($conn, $sql);

                                            echo "<div class='succmessage p-0 rounded text-center text-success'> <p> New Borrower has been registered successfully. </p> </div>";

                                        }

                                     }
                            
                        } else {
                                $sql = "INSERT INTO borrowers_tbl (stud_employee_no, firstname, lastname, borrowers_type, course, eligibility) VALUES ('$tsid', '$fname', '$lname', '$btype', '$course', '$eligibility')";
                                mysqli_query($conn, $sql);

                                echo "<div class='succmessage p-0 rounded text-center text-success'> <p> New Borrower has been registered successfully. </p> </div>";
                        }


                    }
                       
                           
                    
                ?>
                <div class="row">
                    <div class="col">
                        <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="fname" placeholder="First Name" required>
                        <label for="floatingInput">First Name</label>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="lname" placeholder="Last Name" required>
                            <label for="floatingInput">Last Name</label>
                        </div>
                    </div>
                </div>
                
                
                <div class="form-floating mb-3">
                    <input type="text" class="form-control" name="tsid" placeholder="Teacher / Student ID" required>
                    <label for="floatingInput">Teacher / Student ID</label>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <select name="btype" class="form-select" aria-label="Default select example">
                            <option value="false" selected>Set Borrower Type</option>
                            <option value="student">Student</option>
                            <option value="faculty">Faculty</option>
                        </select>
                    </div>

                    <div class="col">
                        <select name="course" class="form-select" aria-label="Default select example">
                            <option value="false" selected>Select Course</option>
                            <?php
                                $sql = "SELECT * FROM course_tbl ORDER BY course";
                                $result = mysqli_query($conn, $sql);

                                while ($res = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $res['course'] . "'>" . $res['course'] . "</option>";
                                }

                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="section" placeholder="Section ( Only required for student )">
                            <label for="floatingInput">Section <span style="font-size: 0.8em;">( required for student )</span></label>
                        </div>
                    </div>

                    <div class="col">
                        <select name="eligibility" class="form-select" aria-label="Default select example">
                            <option value="false" selected>Set Eligibility</option>
                            <option value="eligible">Eligible</option>
                            <option value="ineligible">Ineligible</option>
                        </select>
                    </div>
                </div>
                <button type="submit" name="addborrowerSubmit" class="btn btn-success d-inline-block w-100">Add Borrower</button>
            </form>
        </div>
    </div>


    

    


<!-- bootstarp bundle -->
<script src="../css/bootstrap.bundle.min.js"></script>
<script>
    window.addEventListener('resize', function(){
        location.reload();
}, true);

</script>
</body>
</html>