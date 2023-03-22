<?php
$host = 'localhost';
$username = 'root';
$password = 'root';
$database = 'key_monitoring_db';

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    echo mysqli_error($con);
}

?>