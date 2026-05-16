<?php
session_start();

include("db.php");
include("assets/navbar.php");

$user_id = $_SESSION['user_id'] ?? 0;

if(!$user_id){

    header("Location: login.php");
    exit();
}

// FETCH ORDERS
$orders = mysqli_query($conn,"
SELECT * FROM orders
WHERE user_id='$user_id'
ORDER BY order_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>

<title>My Orders - QuickBites</title>

<script src="https://cdn.tailwindcss.com"></script>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body class="bg-gradient-to-br from-orange-50 via-white to-orange-100 min-h-screen">

<div class="max-w-6xl mx-auto px-4 py-10">

<!-- TOP -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-10">

<div>

<h1 class="text-5xl font-extrabold text-gray-800">
📦 My Orders
</h1>

<p class="text-gray-500 mt-2 text-lg">
Track and manage your food orders
</p>

</div>

<a href="home.php"
class="inline-flex items-center gap-2 bg-white hover:bg-orange-500 hover:text-white transition px-6 py-4 rounded-2xl shadow-lg font-bold">

← Back to Home

</a>

</div>

<?php if(mysqli_num_rows($orders) == 0){ ?>

<!-- EMPTY -->
<div class="bg-white rounded-3xl shadow-xl p-16 text-center border border-orange-100">

<div class="text-7xl mb-5">
🛒
</div>

<h2 class="text-3xl font-bold text-gray-700 mb-3">
No Orders Yet
</h2>

<p class="text-gray-500 mb-8">
Looks like you haven't placed any order yet.
</p>

<a href="home.php"
class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-2xl font-bold shadow-lg transition">

Browse Restaurants

</a>

</div>

<?php } else { ?>

<!-- ORDERS -->
<div class="space-y-6">

<?php while($o = mysqli_fetch_assoc($orders)){ ?>

<?php

$status = strtolower($o['order_status']);

$statusColor = "bg-gray-100 text-gray-600";

if($status == 'pending'){
    $statusColor = "bg-yellow-100 text-yellow-700";
}
elseif($status == 'preparing'){
    $statusColor = "bg-blue-100 text-blue-700";
}
elseif($status == 'out for delivery'){
    $statusColor = "bg-purple-100 text-purple-700";
}
elseif($status == 'delivered'){
    $statusColor = "bg-green-100 text-green-700";
}
elseif($status == 'cancelled'){
    $statusColor = "bg-red-100 text-red-700";
}

?>

<div class="bg-white rounded-3xl shadow-xl hover:shadow-2xl transition border border-orange-100 overflow-hidden">

<div class="p-8">

<div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

<!-- LEFT -->
<div>

<div class="flex items-center gap-3 mb-3">

<h2 class="text-2xl font-bold text-gray-800">
Order #<?php echo $o['order_id']; ?>
</h2>

<span class="px-4 py-2 rounded-full text-sm font-bold <?php echo $statusColor; ?>">

<?php echo ucfirst($o['order_status']); ?>

</span>

</div>

<p class="text-gray-500 mb-2">
🕒 Ordered on:
<?php echo date("d M Y, h:i A", strtotime($o['created_at'])); ?>
</p>

<p class="text-gray-500">
📍 Address:
<?php echo $o['address']; ?>
</p>

</div>

<!-- RIGHT -->
<div class="text-right">

<p class="text-gray-500 text-sm mb-1">
Total Amount
</p>

<h3 class="text-4xl font-extrabold text-orange-500">
₹<?php echo $o['grand_total']; ?>
</h3>

<p class="text-sm text-gray-500 mt-2">
Payment:
<span class="font-semibold">
<?php echo strtoupper($o['payment_method']); ?>
</span>
</p>

</div>

</div>

<!-- BOTTOM -->
<div class="mt-8 flex flex-col md:flex-row gap-4">

<a href="order_details.php?id=<?php echo $o['order_id']; ?>"
class="flex-1 bg-orange-500 hover:bg-orange-600 text-white text-center py-4 rounded-2xl font-bold shadow-lg transition">

View Order Details →

</a>

<?php if($status != 'delivered'){ ?>

<a href="order_details.php?id=<?php echo $o['order_id']; ?>"
class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-center py-4 rounded-2xl font-bold transition">

Track Order 🚚

</a>

<?php } ?>

</div>

</div>

</div>

<?php } ?>

</div>

<?php } ?>

</div>

<?php include("assets/footer.php"); ?>

</body>
</html>