<?php
$host = "sql312.infinityfree.com";
$user = "if0_41111932";
$pass = "Jayesh17021977";
$dbname = "if0_41111932_shopmatrix_db";
$port = 3306;

$conn = new mysqli($host, $user, $pass, $dbname, $port);

if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>
