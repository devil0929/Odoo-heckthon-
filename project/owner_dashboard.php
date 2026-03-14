<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != "OWNER"){
    header("Location: index.php");
    exit();
}

$owner_id = $_SESSION['owner_id'];

// Owner info
$ownerInfo = mysqli_query($conn, "SELECT * FROM owners WHERE id='$owner_id'");
$ownerRow = mysqli_fetch_assoc($ownerInfo);

// Total stores
$totalStores = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM stores WHERE owner_id='$owner_id'"))['total'];

// Total products (future inventory table, abhi 0)
$totalProducts = 0;

// Monthly sales (future sales table, abhi 0)
$monthlySales = 0;

// Monthly profit (future profit calculation)
$monthlyProfit = 0;

// Low stock alerts (future)
$lowStock = 0;

// Active employees
$totalEmployees = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE owner_id='$owner_id' AND role='EMPLOYEE' AND status='active'"))['total'];

// Pending employees
$pendingEmployees = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users WHERE owner_id='$owner_id' AND role='EMPLOYEE' AND status='pending'"))['total'];

// Unread notifications
$unreadNoti = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM notifications WHERE owner_id='$owner_id' AND is_read=0 AND target='OWNER'"))['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Owner Dashboard - ShopMatrix</title>
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

        /* Tables */
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

        .pending{background:orange;}
        .active{background:green;}

    </style>
</head>
<body>

<div class="layout">

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">Shop<span>Matrix</span></div>

        <div class="menu">
            <a href="owner_dashboard.php">📊 Dashboard</a>
            <a href="view_stores.php">🏬 Stores</a>
            <a href="#">📦 Inventory</a>
            <a href="#">🛒 Purchase</a>
            <a href="#">💰 Sales</a>
            <a href="#">📌 Stock Movement (Transit Log)</a>
            <a href="employees.php">👨‍💼 Employees</a>
            <a href="#">📑 Reports</a>
            <a href="notifications.php">🔔 Notifications</a>
            <a href="#">⚙️ Settings</a>
        </div>
    </div>

    <!-- Main -->
    <div class="main">

        <!-- Header -->
        <div class="header">
            <div>
                <b>Store Selector:</b>
                <select style="padding:8px;border-radius:10px;">
                    <option>All Stores</option>
                </select>
            </div>

            <input type="text" placeholder="Search anything...">

            <div class="header-right">
                <div class="noti">🔔 <?php echo $unreadNoti; ?></div>
                <a class="logout" href="logout.php">Logout</a>
            </div>
        </div>

        <!-- Content -->
        <div class="container">

            <div class="welcome">
                <h2>Welcome, <?php echo $ownerRow['owner_name']; ?> 👋</h2>
                <p><b>Business:</b> <?php echo $ownerRow['business_name']; ?></p>
                <p><b>Email:</b> <?php echo $ownerRow['email']; ?> | <b>Mobile:</b> <?php echo $ownerRow['mobile']; ?></p>
            </div>

            <div class="cards">
                <div class="card">
                    <h2><?php echo $totalStores; ?></h2>
                    <p>Total Stores</p>
                </div>

                <div class="card">
                    <h2><?php echo $totalProducts; ?></h2>
                    <p>Total Products</p>
                </div>

                <div class="card">
                    <h2>₹<?php echo $monthlySales; ?></h2>
                    <p>Monthly Sales</p>
                </div>

                <div class="card">
                    <h2>₹<?php echo $monthlyProfit; ?></h2>
                    <p>Monthly Profit</p>
                </div>

                <div class="card">
                    <h2><?php echo $lowStock; ?></h2>
                    <p>Low Stock Alerts</p>
                </div>

                <div class="card">
                    <h2><?php echo $pendingEmployees; ?></h2>
                    <p>Pending Employee Requests</p>
                </div>
            </div>

            <!-- Pending Employees Table -->
            <div class="section">
                <h3>👨‍💼 Pending Employee Requests</h3>

                <table>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Status</th>
                    </tr>

                    <?php
                    $pendingList = mysqli_query($conn, "SELECT * FROM users WHERE owner_id='$owner_id' AND role='EMPLOYEE' AND status='pending' ORDER BY id DESC LIMIT 5");

                    if(mysqli_num_rows($pendingList) > 0){
                        while($emp = mysqli_fetch_assoc($pendingList)){
                    ?>
                        <tr>
                            <td><?php echo $emp['name']; ?></td>
                            <td><?php echo $emp['email']; ?></td>
                            <td><?php echo $emp['mobile']; ?></td>
                            <td><span class="status pending">Pending</span></td>
                        </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='4'>No Pending Requests</td></tr>";
                    }
                    ?>
                </table>

                <br>
                <a href="employee_requests.php" style="text-decoration:none;color:#2d89ef;font-weight:bold;">
                    View All Requests →
                </a>
            </div>

            <!-- Stock Movement Section (Future placeholder) -->
            <div class="section">
                <h3>📌 Stock Movement (Transit Log)</h3>
                <p style="color:#666;">This module will track item transfers between stores (In Transit / Delivered / Returned).</p>
            </div>

        </div>
    </div>

</div>

</body>
</html>
