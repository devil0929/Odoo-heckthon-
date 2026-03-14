<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("db.php");

$msg = "";

if(isset($_POST['register'])){

    $business_name = mysqli_real_escape_string($conn, $_POST['business_name']);
    $owner_name    = mysqli_real_escape_string($conn, $_POST['owner_name']);
    $email         = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile        = mysqli_real_escape_string($conn, $_POST['mobile']);
    $password      = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword     = mysqli_real_escape_string($conn, $_POST['cpassword']);

    if($password != $cpassword){
        $msg = "Password and Confirm Password not match!";
    } 
    else {

        // Check if owner already exists
        $checkOwner = mysqli_query($conn, "SELECT * FROM owners WHERE email='$email' OR mobile='$mobile'");
        if(mysqli_num_rows($checkOwner) > 0){
            $msg = "Owner already registered with this Email or Mobile!";
        } 
        else {

            // Check if email already exists in users
            $checkUser = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
            if(mysqli_num_rows($checkUser) > 0){
                $msg = "This Email already exists in system!";
            }
            else {

                // Insert into owners table
                $sql1 = "INSERT INTO owners (business_name, owner_name, email, mobile, password) 
                         VALUES ('$business_name','$owner_name','$email','$mobile','$password')";

                if(mysqli_query($conn, $sql1)){

                    $owner_id = mysqli_insert_id($conn);

                    // Insert into users table as OWNER
                    $sql2 = "INSERT INTO users (owner_id, store_id, name, email, mobile, password, role, status)
                             VALUES ('$owner_id', NULL, '$owner_name', '$email', '$mobile', '$password', 'OWNER', 'active')";

                    if(mysqli_query($conn, $sql2)){

                        echo "<script>
                        alert('Owner Registered Successfully! Now you can Login.');
                        window.location.href='index.php';
                        </script>";
                        exit();

                    } 
                    else {
                        $msg = "Error in users table: " . mysqli_error($conn);
                    }

                } 
                else {
                    $msg = "Error in owners table: " . mysqli_error($conn);
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ShopMatrix - Owner Registration</title>
    <style>
        body{
            font-family: Arial;
            background:#f4f6f9;
            text-align:center;
        }
        .box{
            width:450px;
            margin:70px auto;
            background:white;
            padding:30px;
            border-radius:12px;
            box-shadow:0px 0px 12px rgba(0,0,0,0.15);
        }
        h1{
            color:#2d89ef;
        }
        input{
            width:90%;
            padding:12px;
            margin:10px 0;
            border-radius:8px;
            border:1px solid #ccc;
            font-size:15px;
        }
        button{
            width:95%;
            padding:12px;
            background:#2d89ef;
            border:none;
            border-radius:8px;
            color:white;
            font-size:16px;
            cursor:pointer;
            margin-top:10px;
        }
        button:hover{
            background:#1b5fa7;
        }
        .err{
            background:#ffe0e0;
            color:#b30000;
            padding:10px;
            border-radius:8px;
            font-size:14px;
            margin-bottom:12px;
        }
        a{
            text-decoration:none;
            color:#2d89ef;
        }
    </style>
</head>
<body>

<div class="box">
    <h1>warehouse  Registration</h1>

    <?php if($msg!=""){ ?>
        <div class="err"><?php echo $msg; ?></div>
    <?php } ?>

    <form method="POST">
        <input type="text" name="business_name" placeholder="warehouse place" required>
        <input type="text" name="owner_name" placeholder="manager Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="text" name="mobile" placeholder="Mobile Number" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="cpassword" placeholder="Confirm Password" required>

        <button type="submit" name="register">Register</button>
    </form>

    <p style="margin-top:15px;">
        Already have account? <a href="index.php">Login Here</a>
    </p>

</div>

</body>
</html>
