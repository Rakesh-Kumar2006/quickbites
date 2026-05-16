<?php
session_start();

include("db.php");
include("assets/navbar.php");

$order_id = $_GET['id'] ?? 0;

if(!$order_id){
    die("Invalid Order ID");
}

// ORDER DETAILS
$order = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM orders
WHERE order_id='$order_id'
"));

if(!$order){
    die("Order not found");
}

// ORDER ITEMS
$items = mysqli_query($conn,"
SELECT * FROM order_items
WHERE order_id='$order_id'
");

// DELIVERY DETAILS
$delivery = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT 
    delivery_id,
    order_id,
    admin_id,
    delivery_partner_name,
    delivery_partner_phone,
    status,
    updated_at
FROM admin_delivery
WHERE order_id='$order_id'
ORDER BY delivery_id DESC
LIMIT 1
"));

// SAFETY
if(!$delivery){

    $delivery = [

        'delivery_partner_name' => 'Not Assigned Yet',

        'delivery_partner_phone' => '-',

        'status' => 'Pending'

    ];
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Track Order - QuickBites</title>

<script src="https://cdn.tailwindcss.com"></script>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body class="bg-gradient-to-br from-orange-50 via-white to-orange-100 min-h-screen">

<div class="max-w-5xl mx-auto px-4 py-10">

<!-- HEADER -->
<div class="bg-white rounded-3xl shadow-xl p-8 mb-8 border border-orange-100">

<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

<div>

<h1 class="text-4xl font-extrabold text-gray-800">
📦 Order #<?php echo $order_id; ?>
</h1>

<p class="text-gray-500 mt-2">
Track your order in real-time
</p>

</div>

<div class="bg-orange-100 text-orange-600 px-5 py-3 rounded-2xl font-bold text-lg">

<?php echo ucfirst($order['order_status']); ?>

</div>

</div>

</div>

<!-- STATUS TRACKER -->
<div class="bg-white rounded-3xl shadow-xl p-8 mb-8 border border-orange-100">

<h2 class="text-2xl font-bold text-gray-800 mb-8">
🚚 Order Status
</h2>

<?php
$status = strtolower($order['order_status']);
?>

<div class="grid grid-cols-2 md:grid-cols-4 gap-5">

<!-- PENDING -->
<div class="rounded-2xl p-5 text-center border-2

<?php echo (
$status == 'pending' ||
$status == 'preparing' ||
$status == 'out for delivery' ||
$status == 'delivered'
)

? 'bg-green-50 border-green-500 text-green-600 shadow-lg'

: 'bg-gray-50 border-gray-200 text-gray-400';

?>">

<div class="text-4xl mb-2">
📦
</div>

<p class="font-bold">
Pending
</p>

</div>

<!-- PREPARING -->
<div class="rounded-2xl p-5 text-center border-2

<?php echo (
$status == 'preparing' ||
$status == 'out for delivery' ||
$status == 'delivered'
)

? 'bg-green-50 border-green-500 text-green-600 shadow-lg'

: 'bg-gray-50 border-gray-200 text-gray-400';

?>">

<div class="text-4xl mb-2">
👨‍🍳
</div>

<p class="font-bold">
Preparing
</p>

</div>

<!-- OUT FOR DELIVERY -->
<div class="rounded-2xl p-5 text-center border-2

<?php echo (
$status == 'out for delivery' ||
$status == 'delivered'
)

? 'bg-green-50 border-green-500 text-green-600 shadow-lg'

: 'bg-gray-50 border-gray-200 text-gray-400';

?>">

<div class="text-4xl mb-2">
🚚
</div>

<p class="font-bold">
Out for Delivery
</p>

</div>

<!-- DELIVERED -->
<div class="rounded-2xl p-5 text-center border-2

<?php echo (
$status == 'delivered'
)

? 'bg-green-50 border-green-500 text-green-600 shadow-lg'

: 'bg-gray-50 border-gray-200 text-gray-400';

?>">

<div class="text-4xl mb-2">
✅
</div>

<p class="font-bold">
Delivered
</p>

</div>

</div>

</div>

<!-- DELIVERY PARTNER -->
<div class="bg-white rounded-3xl shadow-xl p-8 mb-8 border border-orange-100">

<h2 class="text-2xl font-bold text-gray-800 mb-6">
🛵 Delivery Partner
</h2>

<div class="grid md:grid-cols-3 gap-5">

<!-- NAME -->
<div class="bg-orange-50 p-6 rounded-2xl">

<p class="text-gray-500 mb-2">
Partner Name
</p>

<h3 class="text-2xl font-bold text-orange-600">
<?php echo $delivery['delivery_partner_name']; ?>
</h3>

</div>

<!-- PHONE -->
<div class="bg-green-50 p-6 rounded-2xl">

<p class="text-gray-500 mb-2">
Phone Number
</p>

<h3 class="text-2xl font-bold text-green-600">
📞 <?php echo $delivery['delivery_partner_phone']; ?>
</h3>

</div>

<!-- STATUS -->
<div class="bg-blue-50 p-6 rounded-2xl">

<p class="text-gray-500 mb-2">
Delivery Status
</p>

<h3 class="text-2xl font-bold text-blue-600">
<?php echo ucfirst($delivery['status']); ?>
</h3>

</div>

</div>

</div>

<!-- ORDER ITEMS -->
<div class="bg-white rounded-3xl shadow-xl p-8 border border-orange-100">

<h2 class="text-2xl font-bold text-gray-800 mb-6">
🍔 Ordered Items
</h2>

<div class="space-y-5">

<?php

$total = 0;

while($i = mysqli_fetch_assoc($items)){

    $sub = $i['price'] * $i['quantity'];

    $total += $sub;
?>

<div class="flex justify-between items-center bg-gray-50 p-5 rounded-2xl">

<div>

<h3 class="font-bold text-lg text-gray-800">
<?php echo $i['name']; ?>
</h3>

<p class="text-gray-500 text-sm mt-1">
Quantity: <?php echo $i['quantity']; ?>
</p>

<?php if(!empty($i['variant'])){ ?>

<p class="text-orange-500 text-sm mt-1">
<?php echo $i['variant']; ?>
</p>

<?php } ?>

</div>

<div class="text-right">

<p class="text-2xl font-bold text-orange-500">
₹<?php echo $sub; ?>
</p>

</div>

</div>

<?php } ?>

</div>

<!-- BILL -->
<div class="mt-8 border-t pt-6">

<div class="space-y-3 text-gray-700">

<div class="flex justify-between">
<span>Subtotal</span>
<span>₹<?php echo $order['total_amount']; ?></span>
</div>

<div class="flex justify-between">
<span>GST</span>
<span>₹<?php echo $order['gst']; ?></span>
</div>

<div class="flex justify-between">
<span>Delivery Fee</span>
<span class="text-green-600 font-semibold">
FREE
</span>
</div>

<hr>

<div class="flex justify-between text-3xl font-bold">

<span>Total</span>

<span class="text-orange-500">
₹<?php echo $order['grand_total']; ?>
</span>

</div>

</div>

</div>

</div>

<!-- BACK BUTTON -->
<div class="mt-8 text-center">

<a href="orders.php"
class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-2xl font-bold shadow-lg transition">

← Back to My Orders

</a>

</div>

</div>

<?php include("assets/footer.php"); ?>

</body>
</html>