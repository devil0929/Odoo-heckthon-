<?php
// employee_demo.php = Employee Demo Dashboard (Random Data)

$totalProducts   = rand(20, 300);
$totalSales      = rand(20000, 250000);
$lowStock        = rand(0, 15);
$transitPending  = rand(0, 12);
$unreadNoti      = rand(0, 10);

// Random store data
$storeNames = ["Alpha Store", "Prime Hub", "Matrix Store", "QuickMart", "Nova Outlet"];
$cities = ["Ahmedabad", "Surat", "Vadodara", "Rajkot", "Gandhinagar"];

$storeName = $storeNames[array_rand($storeNames)];
$city = $cities[array_rand($cities)];
$storeCode = "SMX" . rand(100,999);

// Random employee generator
$firstNames = ["Amit", "Jay", "Kunal", "Ravi", "Neel", "Harsh", "Vikas", "Sagar"];
$lastNames  = ["Patel", "Shah", "Mehta", "Joshi", "Rathod", "Desai", "Trivedi", "Modi"];

function randomEmployee($firstNames, $lastNames){
    $fname = $firstNames[array_rand($firstNames)];
    $lname = $lastNames[array_rand($lastNames)];
    $name  = $fname . " " . $lname;

    $email = strtolower($fname) . "." . strtolower($lname) . rand(10,99) . "@demo.com";
    $mobile = "9" . rand(100000000, 999999999);

    return [
        "name" => $name,
        "email" => $email,
        "mobile" => $mobile
    ];
}

// Main demo employee
$mainEmp = randomEmployee($firstNames, $lastNames);

// Random employee list (5 employees)
$employees = [];
for($i=0; $i<5; $i++){
    $employees[] = randomEmployee($firstNames, $lastNames);
}

// Notifications random list
$notifications = [
    ["Stock Alert", "Some products are running low in stock.", "Unread"],
    ["Transfer Update", "New stock transfer request received.", "Unread"],
    ["Owner Message", "Please update today's sales entry.", "Read"],
    ["Task Reminder", "Complete pending work list by 6 PM.", "Unread"],
    ["Inventory Check", "Monthly stock verification pending.", "Read"]
];

shuffle($notifications);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Demo Dashboard - ShopMatrix</title>
    <style>
        body{
            margin:0;
            font-family: Arial;
            background:#f2f5fa;
        }
        .layout{ display:flex; }

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

        .logo span{ color:#f97316; }

        .menu a{
            display:block;
            padding:12px 20px;
            color:#cfd6e4;
            text-decoration:none;
            font-size:15px;
        }

        .menu a:hover{
            background:#f97316;
            color:white;
        }

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

        .header input{
            width:300px;
            padding:10px;
            border-radius:10px;
            border:1px solid #ccc;
        }

        .header-right{
            display:flex;
            align-items:center;
            gap:10px;
        }

        .noti{
            background:#f97316;
            color:white;
            padding:6px 12px;
            border-radius:20px;
            font-size:13px;
        }

        .btn{
            padding:8px 14px;
            border-radius:10px;
            text-decoration:none;
            font-size:14px;
            color:white;
            font-weight:bold;
        }

        .btn-owner{ background:#2563eb; }
        .btn-emp{ background:#f97316; }
        .btn-login{ background:green; }

        .container{ padding:25px; }

        .demo-note{
            background:#fff3cd;
            padding:12px;
            border-radius:12px;
            border:1px solid #ffeeba;
            margin-bottom:15px;
            color:#856404;
            font-size:14px;
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
            cursor:pointer;
            transition:0.2s;
        }

        .card:hover{ transform:scale(1.03); }

        .card h2{
            margin:0;
            font-size:28px;
            color:#f97316;
        }

        .card p{
            margin-top:6px;
            color:#555;
        }

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

        th{ background:#f4f6f9; }

        .status{
            padding:5px 10px;
            border-radius:12px;
            font-size:12px;
            color:white;
        }

        .unread{background:red;}
        .read{background:green;}

        .link-btn{
            display:inline-block;
            margin-top:12px;
            background:#16a34a;
            padding:10px 16px;
            border-radius:10px;
            color:white;
            text-decoration:none;
            font-weight:bold;
        }
    </style>
</head>

<body>

<div class="layout">

    <div class="sidebar">
        <div class="logo">Shop<span>Matrix</span></div>

        <div class="menu">
            <a href="employee_demo.php">📊 Employee Demo Dashboard</a>
            <a href="index.php">🏬 Owner Demo Dashboard</a>
            <a href="login.php">🔑 Login</a>

            <hr style="border:0;border-top:1px solid #333;margin:15px 0;">

            <a href="login.php">📦 Inventory</a>
            <a href="login.php">💰 Sales</a>
            <a href="login.php">📌 Stock Transfer</a>
            <a href="login.php">🔔 Notifications</a>
        </div>
    </div>

    <div class="main">

        <div class="header">
            <div>
                <b>Store:</b> <?php echo $storeName; ?> (<?php echo $storeCode; ?>)
            </div>

            <input type="text" placeholder="Search anything...">

            <div class="header-right">
                <div class="noti">🔔 <?php echo $unreadNoti; ?></div>

                <a class="btn btn-owner" href="index.php">Owner Demo</a>
   
                <a class="btn btn-login" href="login.php">Login</a>
            </div>
        </div>

        <div class="container">

            <div class="demo-note">
                ⚠️ This is a DEMO Employee Dashboard.  
                <b>To manage real data, please login.</b>
            </div>

            <div class="welcome">
                <h2>Welcome, <?php echo $mainEmp['name']; ?> 👋</h2>
                <p><b>Email:</b> <?php echo $mainEmp['email']; ?> | <b>Mobile:</b> <?php echo $mainEmp['mobile']; ?></p>
                <p><b>Store:</b> <?php echo $storeName; ?> | <b>City:</b> <?php echo $city; ?></p>
            </div>

            <div class="cards">

                <div class="card" onclick="window.location='login.php'">
                    <h2><?php echo $totalProducts; ?></h2>
                    <p>Total Products</p>
                </div>

                <div class="card" onclick="window.location='login.php'">
                    <h2>₹<?php echo number_format($totalSales); ?></h2>
                    <p>Monthly Sales</p>
                </div>

                <div class="card" onclick="window.location='login.php'">
                    <h2><?php echo $lowStock; ?></h2>
                    <p>Low Stock Alerts</p>
                </div>

                <div class="card" onclick="window.location='login.php'">
                    <h2><?php echo $transitPending; ?></h2>
                    <p>Transit Pending</p>
                </div>

                <div class="card" onclick="window.location='login.php'">
                    <h2><?php echo $unreadNoti; ?></h2>
                    <p>Unread Notifications</p>
                </div>

            </div>

            <!-- Random Employees List -->
            <div class="section">
                <h3>👥 Employees Working in This Store (Demo)</h3>

                <table>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Status</th>
                    </tr>

                    <?php foreach($employees as $emp){ ?>
                        <tr>
                            <td><?php echo $emp['name']; ?></td>
                            <td><?php echo $emp['email']; ?></td>
                            <td><?php echo $emp['mobile']; ?></td>
                            <td><span class="status read">Active</span></td>
                        </tr>
                    <?php } ?>
                </table>

                <a class="link-btn" href="login.php">Login to Manage Employees</a>
            </div>

            <!-- Latest Notifications -->
            <div class="section">
                <h3>🔔 Latest Notifications (Demo)</h3>

                <table>
                    <tr>
                        <th>Title</th>
                        <th>Message</th>
                        <th>Status</th>
                    </tr>

                    <?php
                    for($i=0; $i<5; $i++){
                        $status = ($notifications[$i][2] == "Unread")
                            ? "<span class='status unread'>Unread</span>"
                            : "<span class='status read'>Read</span>";

                        echo "<tr>
                                <td>".$notifications[$i][0]."</td>
                                <td>".$notifications[$i][1]."</td>
                                <td>".$status."</td>
                              </tr>";
                    }
                    ?>
                </table>

                <a class="link-btn" href="login.php">Login to View All Notifications</a>
            </div>

            <div class="section">
                <h3>📌 Daily Store Work Panel (Preview)</h3>
                <p style="color:#666;">
                    Employee can manage only assigned store data:
                    inventory updates, sales entry, stock transfer, pending work and notifications.
                </p>

                <a class="link-btn" href="login.php">Login to Start Working</a>
            </div>

        </div>
    </div>

</div>

</body>
</html>
