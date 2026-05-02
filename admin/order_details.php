<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// ✅ SAFE ID FETCH
$id = $_GET['id'] ?? 0;

if(!$id){
    echo "<p class='text-red-500 p-6'>Invalid Order ID</p>";
    exit;
}

// ORDER INFO
$order = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT o.*, u.name AS user_name, u.phone, u.address
FROM orders o
JOIN users u ON o.user_id = u.user_id
WHERE o.order_id='$id'
"));

if(!$order){
    echo "<p class='text-red-500 p-6'>Order not found</p>";
    exit;
}

// ORDER ITEMS
$items = mysqli_query($conn, "
SELECT oi.*, f.name
FROM order_items oi
JOIN admin_food_items f ON oi.food_id = f.food_id
WHERE oi.order_id='$id'
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Order Details</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex">

<?php include("sidebar.php"); ?>

<div id="mainContent" class="flex-1 md:ml-64">

<?php include("navbar.php"); ?>

<main class="p-6">

<!-- HEADER -->
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold">📦 Order #<?php echo $order['order_id']; ?></h2>

    <a href="orders.php"
    class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300 text-sm">
    ← Back
    </a>
</div>

<!-- CUSTOMER -->
<div class="bg-white p-5 rounded-xl shadow mb-5">

<h3 class="font-semibold text-lg mb-2">👤 Customer Details</h3>

<p><strong>Name:</strong> <?php echo $order['user_name'] ?? 'N/A'; ?></p>
<p><strong>Phone:</strong> <?php echo $order['phone'] ?? '-'; ?></p>
<p><strong>Address:</strong> <?php echo $order['address'] ?? '-'; ?></p>

</div>

<!-- ORDER INFO -->
<div class="bg-white p-5 rounded-xl shadow mb-5">

<h3 class="font-semibold text-lg mb-2">📋 Order Info</h3>

<?php
$status = $order['order_status'] ?? 'Pending';

$color = match($status){
    'pending' => 'bg-yellow-100 text-yellow-700',
    'confirmed' => 'bg-blue-100 text-blue-700',
    'delivered' => 'bg-green-100 text-green-700',
    default => 'bg-gray-100'
};
?>

<div class="flex justify-between items-center">

<div>
<p><strong>Order Date:</strong> <?php echo $order['created_at'] ?? ''; ?></p>
<p><strong>Payment:</strong> <?php echo ucfirst($order['payment_method'] ?? ''); ?></p>
<p><strong>Payment Status:</strong> <?php echo $order['payment_status'] ?? ''; ?></p>
</div>

<span class="px-3 py-1 rounded-full text-sm <?php echo $color; ?>">
<?php echo ucfirst($status); ?>
</span>

</div>

</div>

<!-- ITEMS -->
<div class="bg-white p-5 rounded-xl shadow">

<h3 class="font-semibold text-lg mb-3">🍔 Order Items</h3>

<table class="w-full text-sm">

<thead>
<tr class="bg-gray-200 text-left">
<th class="p-2">Item</th>
<th>Variant</th>
<th>Qty</th>
<th>Price</th>
<th>Total</th>
</tr>
</thead>

<tbody>

<?php 
$total = 0;
while($i = mysqli_fetch_assoc($items)){ 
    $sub = $i['price'] * $i['quantity'];
    $total += $sub;
?>

<tr class="border-b hover:bg-gray-50">

<td class="p-2 font-medium"><?php echo $i['name']; ?></td>

<td>
<?php echo $i['variant'] ?? '-'; ?>
</td>

<td><?php echo $i['quantity']; ?></td>

<td>₹<?php echo $i['price']; ?></td>

<td class="font-semibold">₹<?php echo $sub; ?></td>

</tr>

<?php } ?>

</tbody>

</table>

<!-- TOTAL -->
<div class="mt-4 text-right space-y-1">

<p class="text-sm text-gray-600">
Subtotal: ₹<?php echo $total; ?>
</p>

<?php
$gst = round($total * 0.18, 2);
$grand_total = $total + $gst;
?>

<p class="text-sm text-gray-600">
GST (18%): ₹<?php echo $gst; ?>
</p>

<p class="text-lg font-bold">
Total: ₹<?php echo $grand_total; ?>
</p>

</div>

</div>

</main>

</div>
</div>

</body>
</html>