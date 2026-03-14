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

$user_id  = $_SESSION['user_id'];
$owner_id = $_SESSION['owner_id'];
$store_id = $_SESSION['store_id'];


// Mark notification as read
if (isset($_GET['markread'])) {
    $mark_id = $_GET['markread'];

    mysqli_query($conn, "UPDATE notifications 
                         SET is_read=1 
                         WHERE id='$mark_id' AND user_id='$user_id' AND target='EMPLOYEE'");

    header("Location: employee_notifications.php");
    exit();
}


// Mark all as read
if (isset($_GET['markall'])) {
    mysqli_query($conn, "UPDATE notifications 
                         SET is_read=1 
                         WHERE user_id='$user_id' AND target='EMPLOYEE'");

    header("Location: employee_notifications.php");
    exit();
}


// Fetch notifications (ONLY EMPLOYEE)
$notiQuery = "SELECT * FROM notifications 
              WHERE user_id='$user_id' AND target='EMPLOYEE'
              ORDER BY created_at DESC";

$notiResult = mysqli_query($conn, $notiQuery);


// Unread count
$unreadNoti = mysqli_fetch_assoc(mysqli_query($conn, 
"SELECT COUNT(*) as total FROM notifications 
 WHERE user_id='$user_id' AND target='EMPLOYEE' AND is_read=0"
))['total'];

?>

<!DOCTYPE html>
<html>
<head>
    <title>Employee Notifications - ShopMatrix</title>
    <style>
        body{
            margin:0;
            font-family:Arial;
            background:#f4f6f9;
        }

        .header{
            background:#1e293b;
            color:white;
            padding:15px;
            font-size:20px;
        }

        .container{
            width:90%;
            margin:20px auto;
            background:white;
            padding:20px;
            border-radius:12px;
            box-shadow:0px 2px 12px rgba(0,0,0,0.08);
        }

        .topbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:15px;
            gap:10px;
        }

        .badge{
            background:#dc2626;
            color:white;
            padding:5px 12px;
            border-radius:20px;
            font-size:13px;
        }

        .back-btn{
            background:#2563eb;
            padding:8px 14px;
            border-radius:8px;
            color:white;
            text-decoration:none;
            font-size:14px;
        }

        .markall-btn{
            background:#16a34a;
            padding:8px 14px;
            border-radius:8px;
            color:white;
            text-decoration:none;
            font-size:14px;
        }

        .noti-box{
            border:1px solid #ddd;
            padding:15px;
            border-radius:10px;
            margin-bottom:12px;
        }

        .unread{
            background:#eff6ff;
            border-left:6px solid #2563eb;
        }

        .title{
            font-weight:bold;
            font-size:16px;
            margin-bottom:6px;
        }

        .msg{
            color:#444;
            margin-bottom:10px;
        }

        .time{
            font-size:12px;
            color:gray;
            margin-bottom:10px;
        }

        .btn{
            padding:7px 14px;
            border-radius:8px;
            text-decoration:none;
            font-size:13px;
            color:white;
            margin-right:6px;
            display:inline-block;
        }

        .btn-read{ background:#64748b; }

        .type-tag{
            display:inline-block;
            padding:4px 10px;
            border-radius:15px;
            font-size:12px;
            background:#e2e8f0;
            color:#333;
            margin-bottom:8px;
        }

        .empty{
            text-align:center;
            color:gray;
            padding:20px;
        }
    </style>
</head>
<body>

<div class="header">
    ShopMatrix - Employee Notifications
</div>

<div class="container">

    <div class="topbar">
        <a class="back-btn" href="employee_dashboard.php">⬅ Back</a>

        <div class="badge">Unseen: <?php echo $unreadNoti; ?></div>

        <?php if($unreadNoti > 0){ ?>
            <a class="markall-btn" href="employee_notifications.php?markall=1">✔ Mark All Read</a>
        <?php } ?>
    </div>

    <h2>All Notifications</h2>

    <?php
    if (mysqli_num_rows($notiResult) > 0) {

        while ($row = mysqli_fetch_assoc($notiResult)) {

            $boxClass = ($row['is_read'] == 0) ? "noti-box unread" : "noti-box";

            echo "<div class='$boxClass'>";

            echo "<div class='type-tag'>Type: ".$row['type']."</div>";

            echo "<div class='title'>".$row['title']."</div>";
            echo "<div class='msg'>".$row['message']."</div>";
            echo "<div class='time'>📅 ".$row['created_at']."</div>";

            // Mark as read button
            if ($row['is_read'] == 0) {
                echo "<a class='btn btn-read' href='employee_notifications.php?markread=".$row['id']."'>Mark as Read</a>";
            }

            echo "</div>";
        }

    } else {
        echo "<div class='empty'>No notifications found.</div>";
    }
    ?>

</div>

</body>
</html>
