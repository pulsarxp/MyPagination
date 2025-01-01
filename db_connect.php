<?php
// db_connect.php
$host = "*****";
$username = "*****";
$password = "*****";
$database = "*****";

$conn = mysqli_connect($host, $username, $password, $database);
mysqli_set_charset($conn, "utf8");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    die();
}
?>