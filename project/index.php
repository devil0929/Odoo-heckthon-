<?php

$products = rand(120,300);
$lowStock = rand(5,20);
$pendingReceipts = rand(2,10);
$pendingDeliveries = rand(1,8);
$internalTransfers = rand(1,6);

$productNames = ["Steel Rod","Office Chair","Laptop Stand","LED Bulb","Wood Table","Plastic Box"];
$warehouses = ["Main Warehouse","Rack A","Rack B","Production Floor","Warehouse 2"];

?>

<!DOCTYPE html>
<html>
<head>

<title>CoreInventory Dashboard</title>
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
font-size:15px;
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
display:flex;
justify-content:space-between;
align-items:center;
box-shadow:0px 2px 10px rgba(0,0,0,0.08);
}

.header input{
width:280px;
padding:9px;
border-radius:8px;
border:1px solid #ccc;
}

.badge{
background:#16a34a;
color:white;
padding:6px 10px;
border-radius:20px;
font-size:12px;
}

/* Container */

.container{
padding:25px;
}

/* Cards */

.cards{
display:grid;
grid-template-columns:repeat(auto-fit,minmax(200px,1fr));
gap:15px;
}

.card{
background:white;
padding:20px;
border-radius:14px;
box-shadow:0px 2px 12px rgba(0,0,0,0.08);
cursor:pointer;
}

.card:hover{
transform:scale(1.03);
transition:0.2s;
}

.card h2{
margin:0;
font-size:26px;
color:#3b82f6;
}

.card p{
margin-top:6px;
color:#555;
}

/* Table Section */

.section{
margin-top:25px;
background:white;
padding:20px;
border-radius:14px;
box-shadow:0px 2px 12px rgba(0,0,0,0.08);
}

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

</style>

</head>

<body>

<div class="layout">

<!-- Sidebar -->

<div class="sidebar">

<div class="logo">Core<span>Inventory</span></div>

<div class="menu">

<a href="#">📊 Dashboard</a>
<a href="products.php">📦 Products</a>
<a href="receipts.php">📥 Receipts</a>
<a href="deliveries.php">📤 Deliveries</a>
<a href="transfers.php">🔄 Transfers</a>
<a href="adjustments.php">⚖️ Adjustments</a>
<a href="move_history.php">📜 Stock History</a>
<a href="warehouses.php">🏬 Warehouses</a>
<a href="profile.php">👤 Profile</a>

</div>

</div>

<div class="main">

<!-- Header -->

<div class="header">

<div>
<b>Inventory Manager Dashboard</b>
<span class="badge">LIVE DEMO</span>
</div>

<input type="text" placeholder="Search Product / SKU">

</div>

<div class="container">

<h2>Inventory Overview</h2>

<div class="cards">

<div class="card">
<h2><?php echo $products; ?></h2>
<p>Total Products</p>
</div>

<div class="card">
<h2><?php echo $lowStock; ?></h2>
<p>Low Stock Items</p>
</div>

<div class="card">
<h2><?php echo $pendingReceipts; ?></h2>
<p>Pending Receipts</p>
</div>

<div class="card">
<h2><?php echo $pendingDeliveries; ?></h2>
<p>Pending Deliveries</p>
</div>

<div class="card">
<h2><?php echo $internalTransfers; ?></h2>
<p>Internal Transfers</p>
</div>

</div>

<div class="section">

<h3>Recent Inventory Movements</h3>

<table>

<tr>
<th>Product</th>
<th>Operation</th>
<th>Quantity</th>
<th>Location</th>
</tr>

<?php

for($i=0;$i<6;$i++){

$product=$productNames[array_rand($productNames)];
$warehouse=$warehouses[array_rand($warehouses)];
$qty=rand(5,60);

$ops=["Receipt","Delivery","Transfer","Adjustment"];
$operation=$ops[array_rand($ops)];

echo "<tr>
<td>$product</td>
<td>$operation</td>
<td>$qty</td>
<td>$warehouse</td>
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