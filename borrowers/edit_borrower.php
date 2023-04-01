<?php
    session_start();
    require('../connection.php');

    if (empty($_SESSION['user'])) {
        header('location: ../index.php');
    }
    $borrowerNo = $_SESSION['borrowerid'];
    $query2 = "SELECT * FROM borrowers_tbl WHERE stud_employee_no = '$borrowerNo'";

    $result = mysqli_fetch_assoc(mysqli_query($conn, $query2));

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

    <div class="main-wrapper bg-secondary d-flex flex-column h-100 w-100 p-0 m-0">

        <!-- header -->
        <nav class="navbar bg-dark" data-bs-theme="dark">
            <div class="container-fluid py-1 ps-1 pe-2">
                <a class="navbar-brand" href="#" style="font-family: 'Poppins'; font-size:0.9rem; letter-spacing:1px;">
                <img src="../assets/images/key.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top mx-3">
                Key Monitoring | Update Borrower
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
            <div class="card-header pt-3 bg-dark text-white">
                <h6>Edit Borrower : <span class="border rounded px-2 py-1"><?php echo $result['stud_employee_no'] ."  |  ". $result['firstname'] . ' ' . $result['lastname'] ; ?></span></h6>
            </div>
            <form class="p-3" method="post" id="add_user_form">
                <?php
                    
                    #validations error
                    if (isset($_POST['updateborrowerSubmit'])) {
                        $fname = $_POST['fname'];
                        $lname = $_POST['lname'];
                        $course = $_POST['course'];
                       
                        $eligibility = $_POST['eligibility'];

                        // check if fields are empty
                        if (empty($fname) || empty($lname) || $course == "false" || $eligibility == "false") {
                            echo "<div class='errmessage p-0 rounded text-center text-danger'> <p> All Fields are required. </p> </div>";
                        } else {

                            // if student type
                            if ($result['borrowers_type'] == "student") {
                                $query3 = "SELECT * FROM borrowers_tbl WHERE stud_employee_no = '$borrowerNo'";
                                $result3 = mysqli_fetch_assoc(mysqli_query($conn, $query3));
                                $section = $_POST['section'];
                                if(empty($section)) {
                                    echo "<div class='errmessage p-0 rounded text-center text-danger'> <p> Section field is required for student. </p> </div>";

                                } else if ($result3['firstname'] == $fname && $result3['lastname'] == $lname && $result3['course'] == $course &&  $result3['section'] ==  $section && $result3['eligibility'] == $eligibility) {
                                    echo "<div class='succmessage p-0 rounded text-center text-dark'> <p> No Changes Detected. </p> </div>";
                                } else {
                                    $sql = "UPDATE borrowers_tbl SET firstname = '$fname', lastname = '$lname', course = '$course', section = '$section', eligibility = '$eligibility' WHERE stud_employee_no = '$borrowerNo'";
                                    mysqli_query($conn, $sql);

                                    header('location: ../main.php#borrowerStudent');

                                }

                            } 
                            
                            // if faculty type
                            else {
                                $query = "SELECT * FROM borrowers_tbl WHERE stud_employee_no = '$borrowerNo'";
                                $result3 = mysqli_fetch_assoc(mysqli_query($conn, $query));

                                if($result3['firstname'] == $fname && $result3['lastname'] == $lname && $result3['course'] == $course && $result3['eligibility'] == $eligibility) {
                                    echo "<div class='succmessage p-0 rounded text-center text-dark'> <p> No Changes Detected. </p> </div>";
                                } else {
                                    $sql3 = "UPDATE borrowers_tbl SET firstname = '$fname', lastname = '$lname', course = '$course', eligibility = '$eligibility' WHERE stud_employee_no = '$borrowerNo'";
                                    mysqli_query($conn, $sql3);

                                    header('location: ../main.php#borrowerFaculty');
                                }

                            }
                            

                        }
                    }
                       
                           
                    
                ?>
                <div class="row">
                    <div class="col">
                        <div class="form-floating mb-3">
                        <input type="text" class="form-control" name="fname" placeholder="First Name" value="<?php echo $result['firstname'];?>" required>
                        <label for="floatingInput">First Name</label>
                        </div>
                    </div>

                    <div class="col">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" name="lname" placeholder="Last Name" value="<?php echo $result['lastname'];?>" required>
                            <label for="floatingInput">Last Name</label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    

                    <div class="col">
                        <select name="course" class="form-select" aria-label="Default select example">
                            <option value="false">Select Course</option>
                            <?php
                                $sql = "SELECT * FROM course_tbl ORDER BY course";
                                $result2 = mysqli_query($conn, $sql);

                                while ($res = mysqli_fetch_assoc($result2)) {
                                    if($result['course'] == $res['course']) {
                                        echo "<option value='" . $res['course'] . "'selected>" . $res['course'] . "</option>";
                                    } else {
                                        echo "<option value='" . $res['course'] . "'>" . $res['course'] . "</option>";
                                    }
                                    
                                }

                            ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <?php
                        $sec = $result['section'];
                        if($result['borrowers_type'] == 'student') {
                            echo "<div class='col'>
                            <div class='form-floating mb-3'>
                                <input type='text' class='form-control' value='$sec' name='section' placeholder='Section ( Only required for student )'>
                                <label for='floatingInput'>Section <span style='font-size: 0.8em;'>( required for student )</span></label>
                            </div>
                        </div>";
                        }
                        
                    ?>
                    

                    <div class="col">
                        <select name="eligibility" class="form-select" aria-label="Default select example">
                            <option value="false">Set Eligibility</option>
                            <?php
                                if ($result['eligibility'] == "eligible") {
                                    echo "<option value='eligible' selected >Eligible</option>
                                    <option value='ineligible'>Ineligible</option>";
                                } else {
                                    echo "<option value='eligible'>Eligible</option>
                                    <option value='ineligible' selected>Ineligible</option>";
                                }

                            ?>
                        </select>
                    </div>
                </div>
                <button type="submit" name="updateborrowerSubmit" class="btn btn-primary d-inline-block w-100">Update Borrower</button>
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