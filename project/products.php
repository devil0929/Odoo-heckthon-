<?php
include("db.php");

$productNames = ["Steel Rod","Office Chair","Laptop Stand","LED Bulb","Wood Table","Plastic Box"];
$categories = ["Hardware","Furniture","Electronics","Lighting","Storage"];

?>

<!DOCTYPE html>
<html>
<head>

<title>Products</title>
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
display:flex;
justify-content:space-between;
align-items:center;
}

/* Button */

.add-btn{
background:#16a34a;
color:white;
padding:10px 15px;
border-radius:8px;
text-decoration:none;
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

.stock{
font-weight:bold;
color:#2563eb;
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
<a href="move_history.php">📜 Stock History</a>
<a href="profile.php">👤 Profile</a>

</div>

</div>

<div class="main">

<div class="header">

<h2>Products</h2>

<a class="add-btn" href="product_form.php">+ Add Product</a>

</div>

<div class="container">

<div class="card">

<table>

<tr>
<th>ID</th>
<th>Product Name</th>
<th>SKU</th>
<th>Category</th>
<th>Stock</th>
<th>Action</th>
</tr>

<?php

for($i=1;$i<=8;$i++){

$product=$productNames[array_rand($productNames)];
$cat=$categories[array_rand($categories)];
$stock=rand(10,200);
$sku="SKU".rand(1000,9999);

echo "<tr>

<td>$i</td>
<td>$product</td>
<td>$sku</td>
<td>$cat</td>
<td class='stock'>$stock</td>

<td>
<a href='product_form.php'>Edit</a> |
<a href='#'>Delete</a>
</td>

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