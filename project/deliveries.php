<?php

$products = ["Steel Rod","Office Chair","LED Bulb","Laptop Stand","Wood Table"];
$customers = ["ABC Traders","Metro Store","City Mart","Raj Enterprises","Global Retail"];

?>

<!DOCTYPE html>
<html>
<head>

<title>Delivery Orders</title>
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
background:#dc2626;
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

.out{
color:#dc2626;
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
<h2>Delivery Orders (Outgoing Stock)</h2>
</div>

<div class="container">

<!-- Delivery Form -->

<div class="card">

<h3>Create Delivery Order</h3>

<form method="POST">

<select name="customer" required>
<option value="">Select Customer</option>

<?php
foreach($customers as $c){
echo "<option>$c</option>";
}
?>

</select>

<select name="product" required>
<option value="">Select Product</option>

<?php
foreach($products as $p){
echo "<option>$p</option>";
}
?>

</select>

<input type="number" name="qty" placeholder="Quantity" required>

<button type="submit">Deliver Product</button>

</form>

</div>

<!-- Delivery History -->

<div class="card">

<h3>Recent Deliveries</h3>

<table>

<tr>
<th>Date</th>
<th>Customer</th>
<th>Product</th>
<th>Quantity</th>
<th>Status</th>
</tr>

<?php

for($i=0;$i<7;$i++){

$product=$products[array_rand($products)];
$customer=$customers[array_rand($customers)];
$qty=rand(5,40);

echo "<tr>

<td>".date("d M Y")."</td>
<td>$customer</td>
<td>$product</td>
<td>$qty</td>
<td class='out'>Delivered</td>

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