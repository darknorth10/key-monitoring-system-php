<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Key Monitoring Sytem</title>

    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400&family=Poppins:wght@300&display=swap" rel="stylesheet">
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">

    <!-- custom styles -->
    <link rel="stylesheet" href="css/styles.css">
</head>

<body class="bg-light">
    <!-- header -->
    <nav class="navbar bg-dark" data-bs-theme="dark">
        <div class="container-fluid p-1">
            <a class="navbar-brand" href="#" style="font-family: 'Poppins'; font-size:0.9rem; letter-spacing:1px;">
            <img src="assets/images/key.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top mx-3">
            Key Monitoring
            </a>
        </div>
    </nav>

    <!-- main container -->
    <div class="main container d-flex justify-content-center">
         <!-- login form -->
        <form method="post" class="card bg-white p-4 mt-5 shadow" id="loginform">

            <!-- login image -->
            <div class="imgcontainer w-100 py-2 d-inline-flex justify-content-center" style="height:150px;">
                <img src="assets/images/shield.png" class="h-75">
            </div>
            <!-- php script -->
            <?php
                    session_start();

                    require 'connection.php';

                    if (isset($_POST['loginbtn'])) {

                        $username = mysqli_real_escape_string($conn, $_POST['username']);
                        $password = mysqli_real_escape_string($conn, $_POST['password']);

                        if ( empty($username) || empty($password)) {
                            echo "<p class='err_text text-danger text-center p-2 rounded'>All Fields are required</p>";
                        } else {
                            $query = "SELECT * FROM user_tbl WHERE username = '$username' AND password = '$password'";

                            $result = mysqli_query($conn, $query);

                            if ( mysqli_num_rows($result)) {
                                $results = mysqli_fetch_assoc($result);

                                if ($results['status'] == 'active') {
                                   
                                    $_SESSION['user'] = $results['username'];
                                    $_SESSION['fullname'] = $results['first_name'] . " " . $results['last_name'];

                                    header('location: main.php');

                                } else {
                                    echo "<p class='err_text text-danger text-center p-2 rounded'>User is inactive</p>";

                                }
                                
                            } else {
                                echo "<p class='err_text text-danger text-center p-2 rounded'>Username or Password is incorrect</p>";
                            }
                        }
                        
                    }
                    
                ?>

            <div class="mb-3">
                <input type="text" class="form-control rounded-pill" id="username" name="username" placeholder="Username / ID" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control rounded-pill" placeholder="Password" id="password">
                <div id="passwordHelpBlock" class="form-text px-3 py-2 d-none">
                    Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
                </div>
            </div>
           
            <button type="submit" name="loginbtn" class="submitbtn btn text-white my-3" style="background-color: #4A8FE7;" >Log In</button>
        </form>
    </div>


    <!-- bootstarp bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>