<?php
session_start();

include("db.php");
include("assets/navbar.php");

$order_id = $_GET['id'] ?? 0;

if(!$order_id){
    die("Invalid Order ID");
}

// CANCEL ORDER
if(isset($_GET['cancel'])){

    mysqli_query($conn,"
    UPDATE orders
    SET order_status='cancelled'
    WHERE order_id='$order_id'
    AND order_status='pending'
    ");

    header("Location: order_details.php?id=".$order_id);
    exit();
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

$status = strtolower($order['order_status']);

$statusBadge = "bg-gray-100 text-gray-600";

if($status == 'pending'){

    $statusBadge = "bg-yellow-100 text-yellow-700";

}
elseif($status == 'preparing'){

    $statusBadge = "bg-blue-100 text-blue-700";

}
elseif($status == 'out_for_delivery'){

    $statusBadge = "bg-purple-100 text-purple-700";

}
elseif($status == 'delivered'){

    $statusBadge = "bg-green-100 text-green-700";

}
elseif($status == 'cancelled'){

    $statusBadge = "bg-red-100 text-red-700";

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

<div class="px-5 py-3 rounded-2xl font-bold text-lg <?php echo $statusBadge; ?>">

<?php echo ucfirst(str_replace('_',' ',$order['order_status'])); ?>

</div>

</div>

</div>

<!-- CANCEL BUTTON -->
<?php if($status == 'pending'){ ?>

<div class="mb-8 text-right">

<a href="order_details.php?id=<?php echo $order_id; ?>&cancel=1"
onclick="return confirm('Are you sure you want to cancel this order?')"
class="bg-red-500 hover:bg-red-600 text-white px-6 py-3 rounded-2xl font-bold shadow-lg transition">

Cancel Order ❌

</a>

</div>

<?php } ?>

<!-- CANCEL STATUS -->
<?php if($status == 'cancelled'){ ?>

<div class="bg-red-100 border border-red-300 text-red-700 p-6 rounded-3xl shadow mb-8 text-center">

<div class="text-6xl mb-4">
❌
</div>

<h2 class="text-3xl font-bold mb-3">
Order Cancelled
</h2>

<p class="text-lg font-semibold">
This order has been cancelled successfully.
</p>

</div>

<?php } ?>

<!-- STATUS TRACKER -->
<?php if($status != 'cancelled'){ ?>

<div class="bg-white rounded-3xl shadow-xl p-8 mb-8 border border-orange-100">

<h2 class="text-2xl font-bold text-gray-800 mb-8">
🚚 Order Status
</h2>

<div class="grid grid-cols-2 md:grid-cols-4 gap-5">

<!-- PENDING -->
<div class="rounded-2xl p-5 text-center border-2

<?php echo (
$status == 'pending' ||
$status == 'preparing' ||
$status == 'out_for_delivery' ||
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
$status == 'out_for_delivery' ||
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
$status == 'out_for_delivery' ||
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

<!-- CANCELLED -->
<div class="rounded-2xl p-5 text-center border-2

<?php echo (
$status == 'cancelled'
)

? 'bg-red-50 border-red-500 text-red-600 shadow-lg'

: 'bg-gray-50 border-gray-200 text-gray-400';

?>">

<div class="text-4xl mb-2">
❌
</div>

<p class="font-bold">
Cancelled
</p>

</div>

</div>

</div>


<?php } ?>

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
<?php echo ucfirst(str_replace('_',' ',$delivery['status'])); ?>
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

while($i = mysqli_fetch_assoc($items)){

    $sub = $i['price'] * $i['quantity'];
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