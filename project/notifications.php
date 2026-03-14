<?php
session_start();
include("db.php");

// Session check
if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || !isset($_SESSION['owner_id'])) {
    die("
        <h2 style='font-family:Arial; color:red; text-align:center; margin-top:50px;'>
            ❌ Session Expired / Not Logged In
        </h2>
        <p style='font-family:Arial; text-align:center;'>
            Please login again to continue.
        </p>
        <div style='text-align:center; margin-top:20px;'>
            <a href='index.php' style='background:#2563eb; padding:10px 18px; color:white; text-decoration:none; border-radius:6px;'>
                🔑 Go to Login
            </a>
        </div>
    ");
}

if ($_SESSION['role'] != "OWNER") {
    die("
        <h2 style='font-family:Arial; color:red; text-align:center; margin-top:50px;'>
            ❌ Access Denied
        </h2>
        <p style='font-family:Arial; text-align:center;'>
            Only Owner can access this page.
        </p>
    ");
}

$owner_id = $_SESSION['owner_id'];


// Approve / Reject Employee request from notification
if (isset($_GET['action']) && isset($_GET['ref']) && isset($_GET['noti_id'])) {

    $action = $_GET['action'];
    $emp_id = $_GET['ref'];
    $noti_id = $_GET['noti_id'];

    // Verify employee exists
    $empQuery = mysqli_query($conn, "SELECT * FROM users WHERE id='$emp_id' AND owner_id='$owner_id'");
    $empData = mysqli_fetch_assoc($empQuery);

    if ($empData) {

        if ($action == "approve_emp") {

            // Activate employee
            mysqli_query($conn, "UPDATE users SET status='active' WHERE id='$emp_id'");

            // Mark notification as read
            mysqli_query($conn, "UPDATE notifications SET is_read=1 WHERE id='$noti_id' AND owner_id='$owner_id'");

            // Send notification to employee (target EMPLOYEE)
            $title = "Approved by Owner";
            $message = "Your employee request has been approved. You can now login.";

            mysqli_query($conn, "INSERT INTO notifications(owner_id,user_id,title,message,type,reference_id,is_read,target)
                                VALUES('$owner_id','$emp_id','$title','$message','employee_approved',NULL,0,'EMPLOYEE')");
        }

        if ($action == "reject_emp") {

            // Reject employee
            mysqli_query($conn, "UPDATE users SET status='rejected' WHERE id='$emp_id'");

            // Mark notification as read
            mysqli_query($conn, "UPDATE notifications SET is_read=1 WHERE id='$noti_id' AND owner_id='$owner_id'");

            // Send notification to employee (target EMPLOYEE)
            $title = "Rejected by Owner";
            $message = "Sorry, your employee request has been rejected.";

            mysqli_query($conn, "INSERT INTO notifications(owner_id,user_id,title,message,type,reference_id,is_read,target)
                                VALUES('$owner_id','$emp_id','$title','$message','employee_rejected',NULL,0,'EMPLOYEE')");
        }
    }

    header("Location: notifications.php");
    exit();
}


// Mark notification as read manually
if (isset($_GET['markread'])) {
    $mark_id = $_GET['markread'];
    mysqli_query($conn, "UPDATE notifications SET is_read=1 WHERE id='$mark_id' AND owner_id='$owner_id'");
    header("Location: notifications.php");
    exit();
}


// Fetch OWNER notifications only
$notiQuery = "SELECT * FROM notifications 
              WHERE owner_id='$owner_id' AND target='OWNER'
              ORDER BY created_at DESC";
$notiResult = mysqli_query($conn, $notiQuery);


// Unread count OWNER notifications only
$unreadNoti = mysqli_fetch_assoc(mysqli_query($conn, 
"SELECT COUNT(*) as total FROM notifications 
 WHERE owner_id='$owner_id' AND target='OWNER' AND is_read=0"
))['total'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notifications - ShopMatrix</title>
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
        }

        .badge{
            background:#dc2626;
            color:white;
            padding:5px 10px;
            border-radius:20px;
            font-size:13px;
        }

        .back-btn{
            background:#2563eb;
            padding:8px 14px;
            border-radius:8px;
            color:white;
            text-decoration:none;
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

        .btn-approve{ background:#16a34a; }
        .btn-reject{ background:#dc2626; }
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
    ShopMatrix - Notifications (Owner)
</div>

<div class="container">

    <div class="topbar">
        <a class="back-btn" href="owner_dashboard.php">⬅ Back</a>
        <div class="badge">Unseen: <?php echo $unreadNoti; ?></div>
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

            // Employee request actions
            if ($row['type'] == "employee_request" && $row['is_read'] == 0) {

                $emp_id = $row['reference_id'];
                $noti_id = $row['id'];

                echo "<a class='btn btn-approve' href='notifications.php?action=approve_emp&ref=$emp_id&noti_id=$noti_id'>Approve</a>";
                echo "<a class='btn btn-reject' href='notifications.php?action=reject_emp&ref=$emp_id&noti_id=$noti_id'>Reject</a>";
            }

            // Mark as read button
            if ($row['is_read'] == 0) {
                echo "<a class='btn btn-read' href='notifications.php?markread=".$row['id']."'>Mark as Read</a>";
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
