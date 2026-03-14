<?php
session_start();
include("db.php");

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != "OWNER"){
    header("Location: index.php");
    exit();
}

$owner_id = $_SESSION['owner_id'];

// fetch stores
$stores = mysqli_query($conn, "SELECT * FROM stores WHERE owner_id='$owner_id' ORDER BY id DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stores - ShopMatrix</title>
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

        .logo span{color:#2d89ef;}

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

        .header{
            background:white;
            padding:15px 25px;
            display:flex;
            justify-content:space-between;
            align-items:center;
            box-shadow:0px 2px 10px rgba(0,0,0,0.08);
        }

        .logout{
            background:red;
            color:white;
            padding:8px 14px;
            border-radius:10px;
            text-decoration:none;
            font-size:14px;
        }

        .container{
            padding:25px;
        }

        .topbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:15px;
        }

        .btn{
            background:#28a745;
            color:white;
            padding:10px 15px;
            border-radius:10px;
            text-decoration:none;
            font-size:14px;
        }

        .btn:hover{
            background:#1f7a33;
        }

        table{
            width:100%;
            border-collapse:collapse;
            background:white;
            border-radius:15px;
            overflow:hidden;
            box-shadow:0px 2px 12px rgba(0,0,0,0.08);
        }

        th, td{
            padding:12px;
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

        .active{background:green;}
        .inactive{background:gray;}

        .action-btn{
            padding:6px 10px;
            border-radius:8px;
            text-decoration:none;
            font-size:13px;
            color:white;
        }

        .disable{background:orange;}
        .enable{background:#2d89ef;}
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
            <a href="employee_requests.php">👨‍💼 Employees</a>
            <a href="notifications.php">🔔 Notifications</a>
            <a href="#">⚙️ Settings</a>
        </div>
    </div>

    <!-- Main -->
    <div class="main">

        <!-- Header -->
        <div class="header">
            <h2>🏬 Store Management</h2>
            <a class="logout" href="logout.php">Logout</a>
        </div>

        <div class="container">

            <div class="topbar">
                <h3>All Stores</h3>
                <a class="btn" href="add_store.php">➕ Add Store</a>
            </div>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Store Name</th>
                    <th>Store Code</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>

                <?php
                if(mysqli_num_rows($stores) > 0){
                    while($row = mysqli_fetch_assoc($stores)){
                ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['store_name']; ?></td>
                        <td><?php echo $row['store_code']; ?></td>
                        <td><?php echo $row['city']; ?></td>
                        <td><?php echo $row['state']; ?></td>

                        <td>
                            <?php if($row['status']=="active"){ ?>
                                <span class="status active">Active</span>
                            <?php } else { ?>
                                <span class="status inactive">Inactive</span>
                            <?php } ?>
                        </td>

                        <td>
                            <?php if($row['status']=="active"){ ?>
                                <a class="action-btn disable"
                                   href="store_action.php?id=<?php echo $row['id']; ?>&action=inactive"
                                   onclick="return confirm('Are you sure you want to disable this store?')">
                                   Disable
                                </a>
                            <?php } else { ?>
                                <a class="action-btn enable"
                                   href="store_action.php?id=<?php echo $row['id']; ?>&action=active"
                                   onclick="return confirm('Are you sure you want to activate this store?')">
                                   Activate
                                </a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='7'>No Stores Found</td></tr>";
                }
                ?>

            </table>

        </div>
    </div>
</div>

</body>
</html>
