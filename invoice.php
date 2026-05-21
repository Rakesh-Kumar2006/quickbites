<?php
session_start();

include("db.php");

$order_id = $_GET['order_id'] ?? 0;

if(!$order_id){
    die("Invalid Order");
}

// ORDER
$order = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM orders
WHERE order_id='$order_id'
"));

if(!$order){
    die("Order not found");
}

// ITEMS
$items = mysqli_query($conn,"
SELECT * FROM order_items
WHERE order_id='$order_id'
");

// PAYMENT
$payment = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM payments
WHERE order_id='$order_id'
"));

?>

<!DOCTYPE html>
<html>
<head>

<title>Invoice #<?php echo $order_id; ?></title>

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 p-10">

<div class="max-w-4xl mx-auto bg-white shadow-2xl rounded-3xl overflow-hidden">

<!-- HEADER -->
<div class="bg-orange-500 text-white p-8">

<div class="flex justify-between items-center">

<div>

<h1 class="text-4xl font-extrabold">
QuickBites
</h1>

<p class="mt-2 text-orange-100">
Food Delivery Invoice
</p>

</div>

<div class="text-right">

<h2 class="text-2xl font-bold">
Invoice
</h2>

<p class="mt-2">
Order #<?php echo $order_id; ?>
</p>

</div>

</div>

</div>

<!-- BODY -->
<div class="p-8">

<!-- INFO -->
<div class="grid md:grid-cols-2 gap-8 mb-10">

<div>

<h3 class="font-bold text-lg mb-3">
Customer Details
</h3>

<p>
<b>Address:</b><br>
<?php echo $order['address']; ?>
</p>

</div>

<div>

<h3 class="font-bold text-lg mb-3">
Payment Details
</h3>

<p>
<b>Method:</b>
<?php echo strtoupper($payment['payment_method'] ?? 'COD'); ?>
</p>

<p class="mt-2">
<b>Status:</b>
<?php echo ucfirst($payment['payment_status'] ?? 'Pending'); ?>
</p>

<p class="mt-2">
<b>Transaction ID:</b><br>
<?php echo $payment['transaction_id'] ?? 'N/A'; ?>
</p>

</div>

</div>

<!-- ITEMS -->
<h3 class="font-bold text-xl mb-5">
Ordered Items
</h3>

<div class="overflow-x-auto">

<table class="w-full border">

<thead class="bg-gray-100">

<tr>

<th class="p-4 text-left">
Item
</th>

<th class="p-4 text-center">
Qty
</th>

<th class="p-4 text-right">
Price
</th>

<th class="p-4 text-right">
Total
</th>

</tr>

</thead>

<tbody>

<?php while($i = mysqli_fetch_assoc($items)){ 

$total = $i['price'] * $i['quantity'];

?>

<tr class="border-t">

<td class="p-4">
<?php echo $i['name']; ?>
</td>

<td class="p-4 text-center">
<?php echo $i['quantity']; ?>
</td>

<td class="p-4 text-right">
₹<?php echo $i['price']; ?>
</td>

<td class="p-4 text-right font-semibold">
₹<?php echo $total; ?>
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<!-- BILL -->
<div class="mt-10 ml-auto max-w-md">

<div class="space-y-4 text-lg">

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
<span class="text-green-600">
FREE
</span>
</div>

<hr>

<div class="flex justify-between text-3xl font-extrabold text-orange-500">

<span>Total</span>

<span>
₹<?php echo $order['grand_total']; ?>
</span>

</div>

</div>

</div>

<!-- FOOT -->
<div class="mt-12 flex justify-between items-center">

<p class="text-gray-500">
Thank you for ordering with QuickBites ❤️
</p>

<button onclick="window.print()"
class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-2xl font-bold shadow-lg transition">

Download Invoice 🧾

</button>



</div>

<!-- BACK BUTTON -->
<div class="max-w-4xl mx-auto mb-6">

<a href="payment_history.php"
class="inline-flex items-center gap-2 bg-white hover:bg-orange-500 hover:text-white transition px-6 py-3 rounded-2xl shadow-lg font-bold">

← Back to Payment History

</a>

</div>

</div>

</div>

</body>
</html>