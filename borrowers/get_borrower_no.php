<?php
    session_start();
    require_once('../connection.php');

    $_SESSION['borrowerid'] = $_POST['borrowerid'];
    $_SESSION['update_action'] = $_POST['action'];

    header('location: edit_borrower.php');


?>