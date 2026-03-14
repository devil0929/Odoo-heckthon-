<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != "OWNER"){
    header("Location: index.php");
    exit();
}

$owner_id = $_SESSION['owner_id'];

if(isset($_GET['id']) && isset($_GET['action'])){

    $id = $_GET['id'];
    $action = $_GET['action'];

    // Security: only update owner's store
    $check = mysqli_query($conn, "SELECT * FROM stores WHERE id='$id' AND owner_id='$owner_id'");
    if(mysqli_num_rows($check) == 0){
        echo "<script>alert('Invalid Store Access!'); window.location.href='view_stores.php';</script>";
        exit();
    }

    if($action == "active" || $action == "inactive"){
        mysqli_query($conn, "UPDATE stores SET status='$action' WHERE id='$id'");
        echo "<script>alert('Store Status Updated!'); window.location.href='view_stores.php';</script>";
        exit();
    }
}

header("Location: view_stores.php");
exit();
?>
