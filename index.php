<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Key Monitoring Sytem</title>

    <!-- google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@300;400;500&display=swap" rel="stylesheet">
    <!-- bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">

    <!-- custom styles -->
    <link rel="stylesheet" href="css/styles.css">
</head>
<body class="bg-light">
<nav class="navbar bg-dark" data-bs-theme="dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">
      <img src="/docs/5.3/assets/brand/bootstrap-logo.svg" alt="Logo" width="30" height="24" class="d-inline-block align-text-top">
      Key Monitoring
    </a>
  </div>
</nav>
    <div class="main container d-flex justify-content-center">
        <form method="post" class="card bg-white p-4 mt-5 shadow-sm" id="loginform">
            <h3 class="formtitle px-2 py-3" style="color: #092327;">Welcome back, Please Login</h3>
            <div class="mb-3">
                <label for="username" class="form-label">Username / ID</label>
                <input type="text" class="form-control" id="username" name="username" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your username with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Password</label>
                <input type="password" class="form-control" id="exampleInputPassword1">
                <div id="passwordHelpBlock" class="form-text">
                    Your password must be 8-20 characters long, contain letters and numbers, and must not contain spaces, special characters, or emoji.
                </div>
            </div>
           
            <button type="submit" class="submitbtn btn text-white" style="background-color: #092327;" >Log In</button>
        </form>
    </div>



    <!-- bootstarp bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>