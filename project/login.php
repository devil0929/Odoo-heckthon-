<?php
session_start();
include("db.php");

$msg = "";

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // check account exists
    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) == 0){
        $msg = "Account not found! Please register first.";
    } 
    else {

        $row = mysqli_fetch_assoc($result);

        // password check
        if($row['password'] != $password){
            $msg = "Wrong password! Please try again.";
        }
        else{

            // status checks
            if($row['status'] == "pending"){
                $msg = "Your account is pending approval by Owner.";
            }
            else if($row['status'] == "rejected"){
                $msg = "Your account request has been rejected by Owner.";
            }
            else if($row['status'] == "blocked"){
                $msg = "Your account is blocked. Contact Owner.";
            }
            else if($row['status'] == "active"){

                $_SESSION['user_id'] = $row['id'];
                $_SESSION['owner_id'] = $row['owner_id'];
                $_SESSION['store_id'] = $row['store_id'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['name'] = $row['name'];

                // redirect based on role
                if($row['role'] == "OWNER"){
                    header("Location: owner_dashboard.php");
                    exit();
                }else{
                    header("Location: employee_dashboard.php");
                    exit();
                }

            }
            else{
                $msg = "Invalid account status. Contact Admin.";
            }

        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ShopMatrix - Login</title>
    <style>
        body{
            font-family: Arial;
            background:#f4f6f9;
            text-align:center;
        }
        .box{
            width:420px;
            margin:100px auto;
            background:white;
            padding:30px;
            border-radius:12px;
            box-shadow:0px 0px 12px rgba(0,0,0,0.15);
        }
        h1{
            color:#2d89ef;
        }
        p{
            color:#555;
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
        .regbtn{
            display:block;
            text-decoration:none;
            padding:12px;
            margin:10px 0;
            border-radius:8px;
            font-size:15px;
            color:white;
        }
        .owner{
            background:#333;
        }
        .owner:hover{
            background:#111;
        }
        .emp{
            background:#28a745;
        }
        .emp:hover{
            background:#1f7a33;
        }
        .msg{
            background:#ffe0e0;
            color:#b30000;
            padding:10px;
            border-radius:8px;
            font-size:14px;
            margin-bottom:12px;
        }
    </style>
</head>
<body>

<div class="box">
    <h1>inventoryMatrix</h1>
    <p>Multi-Store Inventory, Sales & Transit Management</p>

    <?php if($msg!=""){ ?>
        <div class="msg"><?php echo $msg; ?></div>
    <?php } ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Enter Email" required>
        <input type="password" name="password" placeholder="Enter Password" required>
        <button type="submit" name="login">Login</button>
    </form>

    <hr style="margin:20px 0;">

    <a class="regbtn owner" href="owner_register.php">Manager Registration</a>
    <a class="regbtn emp" href="employee_register.php">Employee Registration</a>
   

</div>

</body>
</html>
