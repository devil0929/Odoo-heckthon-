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

// Owner role check
if ($_SESSION['role'] != "OWNER") {
    die("
        <h2 style='font-family:Arial; color:red; text-align:center; margin-top:50px;'>
            ❌ Access Denied
        </h2>
        <p style='font-family:Arial; text-align:center;'>
            You are not allowed to access this page.
        </p>
        <div style='text-align:center; margin-top:20px;'>
            <a href='index.php' style='background:#2563eb; padding:10px 18px; color:white; text-decoration:none; border-radius:6px;'>
                🔑 Go to Login
            </a>
        </div>
    ");
}

$owner_id = $_SESSION['owner_id'];

// Block / Unblock action
if (isset($_GET['action']) && isset($_GET['id'])) {
    $emp_id = $_GET['id'];
    $action = $_GET['action'];

    if ($action == "block") {
        mysqli_query($conn, "UPDATE users SET status='blocked' WHERE id='$emp_id' AND owner_id='$owner_id'");
    }

    if ($action == "unblock") {
        mysqli_query($conn, "UPDATE users SET status='active' WHERE id='$emp_id' AND owner_id='$owner_id'");
    }

    header("Location: employees.php");
    exit();
}

// Fetch employees list
$query = "SELECT users.*, stores.store_name 
          FROM users 
          LEFT JOIN stores ON users.store_id = stores.id
          WHERE users.owner_id='$owner_id' AND users.role='EMPLOYEE'
          ORDER BY users.created_at DESC";

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Employees - ShopMatrix</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
        }

        .header {
            background: #1e293b;
            color: white;
            padding: 15px;
            font-size: 20px;
        }

        .container {
            width: 90%;
            margin: 20px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
        }

        h2 {
            margin: 0 0 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #334155;
            color: white;
            padding: 10px;
            text-align: left;
        }

        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .status {
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 6px;
            display: inline-block;
        }

        .active { background: #dcfce7; color: #166534; }
        .pending { background: #fef9c3; color: #854d0e; }
        .rejected { background: #fee2e2; color: #991b1b; }
        .blocked { background: #e0e7ff; color: #3730a3; }

        .btn {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            color: white;
        }

        .btn-block {
            background: #dc2626;
        }

        .btn-unblock {
            background: #16a34a;
        }

        .back-btn {
            display: inline-block;
            margin-bottom: 15px;
            background: #2563eb;
            padding: 8px 14px;
            border-radius: 6px;
            color: white;
            text-decoration: none;
        }

        .empty {
            text-align: center;
            padding: 20px;
            color: gray;
        }
    </style>
</head>
<body>

<div class="header">
    ShopMatrix - Employees
</div>

<div class="container">

    <a class="back-btn" href="owner_dashboard.php">⬅ Back to Dashboard</a>

    <h2>All Employees</h2>

    <table>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Store</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                $status_class = $row['status'];

                echo "<tr>";
                echo "<td>".$row['name']."</td>";
                echo "<td>".$row['email']."</td>";
                echo "<td>".$row['mobile']."</td>";
                echo "<td>".($row['store_name'] ? $row['store_name'] : "Not Assigned")."</td>";
                echo "<td><span class='status $status_class'>".$row['status']."</span></td>";

                echo "<td>";

                if ($row['status'] == "active") {
                    echo "<a class='btn btn-block' href='employees.php?action=block&id=".$row['id']."'>Block</a>";
                } 
                elseif ($row['status'] == "blocked") {
                    echo "<a class='btn btn-unblock' href='employees.php?action=unblock&id=".$row['id']."'>Unblock</a>";
                } 
                else {
                    echo "-";
                }

                echo "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6' class='empty'>No employees found.</td></tr>";
        }
        ?>

    </table>

</div>

</body>
</html>
