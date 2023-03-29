<?php
session_start();
require_once('connection.php');

$_SESSION['userid'] = $_POST['userid'];

header('Location: edit_user.php');

?>