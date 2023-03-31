<?php
session_start();
require_once('../connection.php');

$_SESSION['userid'] = $_POST['userid'];
$_SESSION['update_action'] = $_POST['action'];

if ($_SESSION['update_action'] == 'updateUser') {
    header('location: edit_user.php');
} elseif ($_SESSION['update_action'] == "resetPass") {
    header('location: reset_password.php');

} else {
    header('location: ../main.php');
}


?>