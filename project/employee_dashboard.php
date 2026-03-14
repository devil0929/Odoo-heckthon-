<?php
session_start();
include("db.php");

// Session check
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role'])) {
    die("
        <h2 style='font-family:Arial;color:red;text-align:center;margin-top:50px;'>
            ❌ Session Expired / Not Logged In
        </h2>
        <p style='font-family:Arial;text-align:center;'>
            Please login again.
        </p>
        <div style='text-align:center; margin-top:20px;'>
            <a href='index.php' style='background:#2563eb;padding:10px 18px;color:white;text-decoration:none;border-radius:8px;'>
                🔑 Go to Login
            </a>
        </div>
    ");
}

// Only Employee access
if ($_SESSION['role'] != "EMPLOYEE") {
    die("
        <h2 style='font-family:Arial;color:red;text-align:center;margin-top:50px;'>
            ❌ Access Denied
        </h2>
        <p style='font-family:Arial;text-align:center;'>
            Only Employee can access this page.
        </p>
    ");
}

// Store assigned check
if (!isset($_SESSION['store_id']) || $_SESSION['store_id'] == "" || $_SESSION['store_id'] == 0) {
    die("
        <h2 style='font-family:Arial;color:red;text-align:center;margin-top:50px;'>
            ❌ Store Not Assigned
        </h2>
        <p style='font-family:Arial;text-align:center;'>
            Please contact Owner to assign you a store.
        </p>
    ");
}

$user_id  = $_SESSION['user_id'];
$owner_id = $_SESSION['owner_id'];
$store_id = $_SESSION['store_id'];


// Employee info
$empInfo = mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id' AND role='EMPLOYEE'");
$empRow = mysqli_fetch_assoc($empInfo);

if (!$empRow) {
    die("<h2 style='color:red;text-align:center;margin-top:50px;'>Invalid Employee Access.</h2>");
}

// Store info (employee can access only own owner store)
$storeInfo = mysqli_query($conn, "SELECT * FROM stores WHERE id='$store_id' AND owner_id='$owner_id'");
$storeRow = mysqli_fetch_assoc($storeInfo);

if (!$storeRow) {
    die("<h2 style='color:red;text-align:center;margin-top:50px;'>Invalid Store Access.</h2>");
}


// Notifications count (ONLY EMPLOYEE notifications)
$unreadNoti = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT COUNT(*) as total FROM notifications 
 WHERE user_id='$user_id' AND target='EMPLOYEE' AND is_read=0 AND target='EMPLOYEE'"
))['total'];


// Dashboard placeholders (future modules)
$totalSales = 0;
$totalPurchase = 0;
$totalProducts = 0;
$lowStock = 0;
$transitPending = 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Dashboard - ShopMatrix</title>
    <style>
        body{
            margin:0;
            font-family: Arial;
            background:#f2f5fa;
        }

        .layout{
            display:flex;
        }

        /* Sidebar */
        .sidebar{
            width:240px;
            background:#1c1f2b;
            height:100vh;
            padding:20px 0;
            position:fixed;
            left:0;
            top:0;
        }

        .logo{
            color:white;
            font-size:22px;
            font-weight:bold;
            padding:0 20px 20px 20px;
        }

        .logo span{
            color:#2d89ef;
        }

        .menu a{
            display:block;
            padding:12px 20px;
            color:#cfd6e4;
            text-decoration:none;
            font-size:15px;
        }

        .menu a:hover{
            background:#2d89ef;
            color:white;
        }

        /* Main content */
        .main{
            margin-left:240px;
            width:100%;
        }

        /* Header */
        .header{
            background:white;
            padding:15px 25px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            box-shadow:0px 2px 10px rgba(0,0,0,0.08);
        }

        .header input{
            width:350px;
            padding:10px;
            border-radius:10px;
            border:1px solid #ccc;
        }

        .header-right{
            display:flex;
            align-items:center;
            gap:15px;
        }

        .noti{
            background:#2d89ef;
            color:white;
            padding:6px 12px;
            border-radius:20px;
            font-size:13px;
        }

        .logout{
            background:red;
            color:white;
            padding:8px 14px;
            border-radius:10px;
            text-decoration:none;
            font-size:14px;
        }

        /* Dashboard cards */
        .container{
            padding:25px;
        }

        .welcome{
            background:white;
            padding:20px;
            border-radius:15px;
            box-shadow:0px 2px 12px rgba(0,0,0,0.08);
            margin-bottom:20px;
        }

        .cards{
            display:grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap:15px;
        }

        .card{
            background:white;
            padding:20px;
            border-radius:15px;
            box-shadow:0px 2px 12px rgba(0,0,0,0.08);
        }

        .card h2{
            margin:0;
            font-size:28px;
            color:#2d89ef;
        }

        .card p{
            margin-top:6px;
            color:#555;
        }

        /* Section */
        .section{
            margin-top:25px;
            background:white;
            padding:20px;
            border-radius:15px;
            box-shadow:0px 2px 12px rgba(0,0,0,0.08);
        }

        table{
            width:100%;
            border-collapse:collapse;
            margin-top:10px;
        }

        th, td{
            padding:10px;
            border-bottom:1px solid #ddd;
            text-align:left;
            font-size:14px;
        }

        th{
            background:#f4f6f9;
        }

        .status{
            padding:5px 10px;
            border-radius:12px;
            font-size:12px;
            color:white;
        }

        .unread{background:red;}
        .read{background:green;}

        .viewall{
            text-decoration:none;
            color:#2d89ef;
            font-weight:bold;
        }
    </style>
</head>
<body>

<div class="layout">

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">Shop<span>Matrix</span></div>

        <div class="menu">
            <a href="employee_dashboard.php">📊 Dashboard</a>
            <a href="#">📦 Inventory</a>
            <a href="#">🛒 Purchase</a>
            <a href="#">💰 Sales</a>
            <a href="#">📌 Stock Movement</a>
            <a href="employee_notifications.php">🔔 Notifications</a>
            <a href="#">⚙️ Profile</a>
        </div>
    </div>

    <!-- Main -->
    <div class="main">

        <!-- Header -->
        <div class="header">
            <div>
                <b>Store:</b> <?php echo $storeRow['store_name']; ?> (<?php echo $storeRow['store_code']; ?>)
            </div>

            <input type="text" placeholder="Search...">

            <div class="header-right">
                <div class="noti">🔔 <?php echo $unreadNoti; ?></div>
                <a class="logout" href="logout.php">Logout</a>
            </div>
        </div>

        <!-- Content -->
        <div class="container">

            <div class="welcome">
                <h2>Welcome, <?php echo $empRow['name']; ?> 👋</h2>
                <p>
                    <b>Email:</b> <?php echo $empRow['email']; ?> |
                    <b>Mobile:</b> <?php echo $empRow['mobile']; ?>
                </p>
                <p>
                    <b>Store:</b> <?php echo $storeRow['store_name']; ?> |
                    <b>City:</b> <?php echo $storeRow['city']; ?>
                </p>
            </div>

            <div class="cards">

                <div class="card">
                    <h2><?php echo $totalProducts; ?></h2>
                    <p>Total Products</p>
                </div>

               

                <div class="card">
                    <h2>₹<?php echo $totalSales; ?></h2>
                    <p>Total Sales</p>
                </div>

                <div class="card">
                    <h2><?php echo $lowStock; ?></h2>
                    <p>Low Stock Alerts</p>
                </div>

                <div class="card">
                    <h2><?php echo $transitPending; ?></h2>
                    <p>Transit Pending</p>
                </div>

                <div class="card">
                    <h2><?php echo $unreadNoti; ?></h2>
                    <p>Unread Notifications</p>
                </div>

            </div>

            <!-- Notification Preview -->
            <div class="section">
                <h3>🔔 Latest Notifications</h3>

                <table>
                    <tr>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>

                    <?php
                    $notiList = mysqli_query($conn,
                        "SELECT * FROM notifications 
                         WHERE user_id='$user_id' AND target='EMPLOYEE'
                         ORDER BY id DESC LIMIT 5"
                    );

                    if(mysqli_num_rows($notiList) > 0){
                        while($noti = mysqli_fetch_assoc($notiList)){
                            $status = ($noti['is_read'] == 0)
                                ? "<span class='status unread'>Unread</span>"
                                : "<span class='status read'>Read</span>";
                    ?>
                        <tr>
                            <td><?php echo $noti['title']; ?></td>
                            <td><?php echo $noti['message']; ?></td>
                            <td><?php echo $status; ?></td>
                            <td><?php echo $noti['created_at']; ?></td>
                        </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='4'>No Notifications Found</td></tr>";
                    }
                    ?>
                </table>

                <br>
                <a class="viewall" href="employee_notifications.php">
                    View All Notifications →
                </a>
            </div>

            <!-- Placeholder -->
            <div class="section">
                <h3>📌 Store Work Panel</h3>
                <p style="color:#666;">
                    This area will show stock movement, purchase, sales and daily tasks for this store only.
                </p>
            </div>

        </div>
    </div>

</div>

</body>
</html>
