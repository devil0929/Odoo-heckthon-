<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != "OWNER"){
    header("Location: index.php");
    exit();
}

$owner_id = $_SESSION['owner_id'];
$msg = "";

if(isset($_POST['add_store'])){

    $store_name = mysqli_real_escape_string($conn, $_POST['store_name']);
    $store_code = mysqli_real_escape_string($conn, $_POST['store_code']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $city = mysqli_real_escape_string($conn, $_POST['city']);
    $state = mysqli_real_escape_string($conn, $_POST['state']);

    // Check store code unique
    $check = mysqli_query($conn, "SELECT * FROM stores WHERE store_code='$store_code'");
    if(mysqli_num_rows($check) > 0){
        $msg = "Store Code already exists! Use another code.";
    } else {

        $sql = "INSERT INTO stores (owner_id, store_name, store_code, address, city, state, status)
                VALUES ('$owner_id', '$store_name', '$store_code', '$address', '$city', '$state', 'active')";

        if(mysqli_query($conn, $sql)){
            echo "<script>
                alert('Store Added Successfully!');
                window.location.href='view_stores.php';
            </script>";
            exit();
        } else {
            $msg = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Store - ShopMatrix</title>
    <style>
        body{
            font-family: Arial;
            background:#f4f6f9;
            margin:0;
            padding:0;
        }
        .box{
            width:420px;
            margin:80px auto;
            background:white;
            padding:25px;
            border-radius:15px;
            box-shadow:0px 0px 12px rgba(0,0,0,0.15);
        }
        h2{
            text-align:center;
            margin-bottom:20px;
        }
        input, textarea{
            width:100%;
            padding:10px;
            margin:8px 0;
            border:1px solid #ccc;
            border-radius:10px;
        }
        button{
            width:100%;
            padding:12px;
            background:#28a745;
            border:none;
            border-radius:12px;
            color:white;
            font-size:16px;
            cursor:pointer;
        }
        button:hover{
            background:#1f7a33;
        }
        .msg{
            text-align:center;
            color:red;
            margin-bottom:10px;
        }
        .back{
            display:block;
            text-align:center;
            margin-top:15px;
            text-decoration:none;
            color:#2d89ef;
            font-weight:bold;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>➕ Add New Store</h2>

    <?php if($msg!=""){ echo "<div class='msg'>$msg</div>"; } ?>

    <form method="POST">
        <input type="text" name="store_name" placeholder="Store Name" required>
        <input type="text" name="store_code" placeholder="Store Code (Unique)" required>

        <textarea name="address" placeholder="Store Address"></textarea>

        <input type="text" name="city" placeholder="City">
        <input type="text" name="state" placeholder="State">

        <button type="submit" name="add_store">Add Store</button>
    </form>

    <a class="back" href="view_stores.php">← Back to Stores</a>
</div>

</body>
</html>
