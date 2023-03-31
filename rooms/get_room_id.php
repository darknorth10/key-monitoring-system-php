<?php
    require_once('../connection.php');
    session_start();

    $_SESSION['getroomid'] = $_POST['getroomid'];
    header('Location: edit_room.php');
?>