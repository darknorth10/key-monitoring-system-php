<?php
    session_start();
    
    $_SESSION['borrowRoom'] = $_POST['getroomid'];

    header('location: borrow.php');

?>
