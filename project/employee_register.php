<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("db.php");

$msg = "";

// Fetch owners list
$owners = mysqli_query($conn, "SELECT id, business_name, owner_name FROM owners ORDER BY id DESC");

if(isset($_POST['register'])){

    $owner_id  = mysqli_real_escape_string($conn, $_POST['owner_id']);
    $store_id  = mysqli_real_escape_string($conn, $_POST['store_id']);
    $name      = mysqli_real_escape_string($conn, $_POST['name']);
    $email     = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile    = mysqli_real_escape_string($conn, $_POST['mobile']);
    $password  = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);

    if($password != $cpassword){
        $msg = "Password and Confirm Password not match!";
    } 
    else {

        // Check if email already exists
        $checkUser = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
        if(mysqli_num_rows($checkUser) > 0){
            $msg = "This Email already registered!";
        } 
        else {

            // Insert employee user (pending)
            $sql = "INSERT INTO users (owner_id, store_id, name, email, mobile, password, role, status)
                    VALUES ('$owner_id', '$store_id', '$name', '$email', '$mobile', '$password', 'EMPLOYEE', 'pending')";

            if(mysqli_query($conn, $sql)){

                $user_id = mysqli_insert_id($conn);

                // Notification to owner
                $title = "New Employee Request";
                $message = "$name requested to join your store.";
                $type = "employee_request";

mysqli_query($conn,"INSERT INTO notifications(owner_id,user_id,title,message,type,reference_id,target)VALUES('$owner_id','$user_id','New Employee Request','$name requested to join your store.','employee_request','$user_id','OWNER')");


                echo "<script>
                alert('Employee Registered Successfully! Wait for Owner Approval.');
                window.location.href='index.php';
                </script>";
                exit();

            } 
            else {
                $msg = "Registration Failed! Error: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ShopMatrix - Employee Registration</title>
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
            color:#28a745;
        }
        input, select{
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
            background:#28a745;
            border:none;
            border-radius:8px;
            color:white;
            font-size:16px;
            cursor:pointer;
            margin-top:10px;
        }
        button:hover{
            background:#1f7a33;
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

    <script>
        function loadStores(ownerId){
            if(ownerId==""){
                document.getElementById("store_id").innerHTML = "<option value=''>Select Store</option>";
                return;
            }

            var xhr = new XMLHttpRequest();
            xhr.open("GET","get_stores.php?owner_id="+ownerId,true);
            xhr.onload = function(){
                document.getElementById("store_id").innerHTML = this.responseText;
            }
            xhr.send();
        }
    </script>

</head>
<body>

<div class="box">
    <h1>Employee Registration</h1>

    <?php if($msg!=""){ ?>
        <div class="err"><?php echo $msg; ?></div>
    <?php } ?>

    <form method="POST">

        <!-- Owner Select -->
        <select name="owner_id" required onchange="loadStores(this.value)">
            <option value="">Select warehouse location</option>
            <?php while($o = mysqli_fetch_assoc($owners)){ ?>
                <option value="<?php echo $o['id']; ?>">
                    <?php echo $o['business_name']." (".$o['owner_name'].")"; ?>
                </option>
            <?php } ?>
        </select>

        <!-- Store Select -->
        <select name="store_id" id="store_id" required>
            <option value="">manager name </option>
        </select>

        <input type="text" name="name" placeholder="Employee Name" required>
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
