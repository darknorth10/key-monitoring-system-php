<?php
    session_start();
    
    $_SESSION['returnKey'] = $_POST['getroomid'];

    header('location: returnkey.php');

?>
