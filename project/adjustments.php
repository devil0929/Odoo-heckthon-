<?php

$products = ["Steel Rod","Office Chair","LED Bulb","Laptop Stand","Wood Table"];
$locations = ["Main Warehouse","Rack A","Rack B","Production Floor"];

?>

<!DOCTYPE html>
<html>
<head>

<title>Stock Adjustments</title>
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
margin-bottom:20px;
}

/* Form */

input,select{
width:100%;
padding:10px;
margin-bottom:10px;
border-radius:8px;
border:1px solid #ccc;
}

button{
background:#f59e0b;
color:white;
padding:10px 18px;
border:none;
border-radius:8px;
cursor:pointer;
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

.adjust{
color:#f59e0b;
font-weight:bold;
}

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
<h2>Stock Adjustments</h2>
</div>

<div class="container">

<!-- Adjustment Form -->

<div class="card">

<h3>Adjust Stock</h3>

<form method="POST">

<select name="product" required>
<option value="">Select Product</option>

<?php
foreach($products as $p){
echo "<option>$p</option>";
}
?>

</select>

<select name="location" required>
<option value="">Select Location</option>

<?php
foreach($locations as $l){
echo "<option>$l</option>";
}
?>

</select>

<input type="number" name="system_stock" placeholder="System Stock">

<input type="number" name="physical_stock" placeholder="Physical Count">

<button type="submit">Adjust Stock</button>

</form>

</div>

<!-- Adjustment History -->

<div class="card">

<h3>Recent Adjustments</h3>

<table>

<tr>
<th>Date</th>
<th>Product</th>
<th>Location</th>
<th>System</th>
<th>Physical</th>
<th>Adjustment</th>
</tr>

<?php

for($i=0;$i<6;$i++){

$product=$products[array_rand($products)];
$location=$locations[array_rand($locations)];

$system=rand(50,120);
$physical=rand(40,120);

$adjust=$physical-$system;

echo "<tr>

<td>".date("d M Y")."</td>
<td>$product</td>
<td>$location</td>
<td>$system</td>
<td>$physical</td>
<td class='adjust'>$adjust</td>

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