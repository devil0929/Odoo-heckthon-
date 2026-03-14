<?php
include("db.php");

if(isset($_GET['owner_id'])){
    $owner_id = $_GET['owner_id'];

    $stores = mysqli_query($conn, "SELECT id, store_name FROM stores WHERE owner_id='$owner_id' AND status='active'");

    echo "<option value=''>Select Store</option>";

    while($s = mysqli_fetch_assoc($stores)){
        echo "<option value='".$s['id']."'>".$s['store_name']."</option>";
    }
}
?>
