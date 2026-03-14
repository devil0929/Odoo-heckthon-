<?php

$products = ["Steel Rod","Office Chair","LED Bulb","Laptop Stand","Wood Table"];
$locations = ["Main Warehouse","Rack A","Rack B","Production Floor"];

$operations = [
["type"=>"IN","label"=>"Receipt"],
["type"=>"OUT","label"=>"Delivery"],
["type"=>"TRANSFER","label"=>"Transfer"],
["type"=>"ADJUST","label"=>"Adjustment"]
];

?>

<!DOCTYPE html>
<html>
<head>

<title>Move History</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<style>

body{
margin:0;
font-family:Arial;
background:#f3f6fb;
}

.layout{
display:flex;
}

/* Sidebar */

.sidebar{
width:240px;
background:#111827;
height:100vh;
padding:20px 0;
position:fixed;
}

.logo{
color:white;
font-size:22px;
font-weight:bold;
padding:0 20px 20px;
}

.logo span{
color:#3b82f6;
}

.menu a{
display:block;
padding:12px 20px;
color:#cfd6e4;
text-decoration:none;
}

.menu a:hover{
background:#3b82f6;
color:white;
}

/* Main */

.main{
margin-left:240px;
width:100%;
}

/* Header */

.header{
background:white;
padding:15px 20px;
box-shadow:0px 2px 10px rgba(0,0,0,0.08);
}

/* Container */

.container{
padding:25px;
}

/* Card */

.card{
background:white;
padding:20px;
border-radius:14px;
box-shadow:0px 2px 12px rgba(0,0,0,0.08);
}

/* Table */

table{
width:100%;
border-collapse:collapse;
margin-top:10px;
}

th,td{
padding:10px;
border-bottom:1px solid #ddd;
font-size:14px;
}

th{
background:#f4f6f9;
}

/* Status Colors */

.in{color:#16a34a;font-weight:bold;}
.out{color:#dc2626;font-weight:bold;}
.transfer{color:#2563eb;font-weight:bold;}
.adjust{color:#f59e0b;font-weight:bold;}

</style>

</head>

<body>

<div class="layout">

<!-- Sidebar -->

<div class="sidebar">

<div class="logo">Core<span>Inventory</span></div>

<div class="menu">

<a href="manager_dashboard.php">📊 Dashboard</a>
<a href="products.php">📦 Products</a>
<a href="receipts.php">📥 Receipts</a>
<a href="deliveries.php">📤 Deliveries</a>
<a href="transfers.php">🔄 Transfers</a>
<a href="adjustments.php">⚖️ Adjustments</a>
<a href="move_history.php">📜 Move History</a>

</div>

</div>

<div class="main">

<div class="header">
<h2>Move History</h2>
</div>

<div class="container">

<div class="card">

<table>

<tr>
<th>Date</th>
<th>Product</th>
<th>Operation</th>
<th>Quantity</th>
<th>Location</th>
</tr>

<?php

for($i=0;$i<10;$i++){

$product = $products[array_rand($products)];
$location = $locations[array_rand($locations)];
$qty = rand(5,80);

$op = $operations[array_rand($operations)];

$type = $op["type"];
$label = $op["label"];

$class="";

if($type=="IN") $class="in";
if($type=="OUT") $class="out";
if($type=="TRANSFER") $class="transfer";
if($type=="ADJUST") $class="adjust";

echo "<tr>

<td>".date("d M Y")."</td>
<td>$product</td>
<td class='$class'>$label</td>
<td>$qty</td>
<td>$location</td>

</tr>";

}

?>

</table>

</div>

</div>

</div>

</div>

</body>
</html>