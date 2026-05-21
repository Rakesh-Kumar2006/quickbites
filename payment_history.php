<?php
session_start();

include("db.php");
include("assets/navbar.php");

$user_id = $_SESSION['user_id'] ?? 0;

if(!$user_id){

    header("Location: login.php");
    exit();
}

// FETCH PAYMENTS
$payments = mysqli_query($conn,"
SELECT 
    p.*,
    o.grand_total,
    o.order_status
FROM payments p

LEFT JOIN orders o
ON p.order_id = o.order_id

LEFT JOIN users u
ON o.user_id = u.user_id

WHERE o.user_id='$user_id'

ORDER BY p.payment_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>

<title>Payment History - QuickBites</title>

<script src="https://cdn.tailwindcss.com"></script>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body class="bg-gradient-to-br from-orange-50 via-white to-orange-100 min-h-screen">

<div class="max-w-7xl mx-auto px-4 py-10">

<!-- TOP -->
<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-5 mb-10">

<div>

<h1 class="text-5xl font-extrabold text-gray-800">
💳 Payment History
</h1>

<p class="text-gray-500 mt-2 text-lg">
View all your payments and transactions
</p>

</div>

<a href="orders.php"
class="inline-flex items-center gap-2 bg-white hover:bg-orange-500 hover:text-white transition px-6 py-4 rounded-2xl shadow-lg font-bold">

← Back to Orders

</a>

</div>

<?php if(mysqli_num_rows($payments) == 0){ ?>

<!-- EMPTY -->
<div class="bg-white rounded-3xl shadow-xl p-16 text-center border border-orange-100">

<div class="text-7xl mb-5">
💳
</div>

<h2 class="text-3xl font-bold text-gray-700 mb-3">
No Payments Found
</h2>

<p class="text-gray-500 mb-8">
Looks like you haven’t made any payments yet.
</p>

<a href="home.php"
class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-2xl font-bold shadow-lg transition">

Order Food

</a>

</div>

<?php } else { ?>

<!-- PAYMENTS -->
<div class="space-y-6">

<?php while($p = mysqli_fetch_assoc($payments)){ ?>

<?php

$paymentStatus = strtolower($p['payment_status']);

$statusColor = "bg-gray-100 text-gray-600";

if($paymentStatus == 'paid'){

    $statusColor = "bg-green-100 text-green-700";

}
elseif($paymentStatus == 'pending'){

    $statusColor = "bg-yellow-100 text-yellow-700";

}
elseif($paymentStatus == 'failed'){

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
Payment #<?php echo $p['payment_id']; ?>
</h2>

<span class="px-4 py-2 rounded-full text-sm font-bold <?php echo $statusColor; ?>">

<?php echo ucfirst($p['payment_status']); ?>

</span>

</div>

<p class="text-gray-500 mb-2">
🧾 Order ID:
<span class="font-semibold text-gray-700">
#<?php echo $p['order_id']; ?>
</span>
</p>

<p class="text-gray-500 mb-2">
💳 Payment Method:
<span class="font-semibold text-gray-700">
<?php echo strtoupper($p['payment_method']); ?>
</span>
</p>

<p class="text-gray-500">
📅 Payment Date:
<?php echo date("d M Y, h:i A", strtotime($p['payment_date'])); ?>
</p>

</div>

<!-- RIGHT -->
<div class="text-right">

<p class="text-gray-500 text-sm mb-1">
Total Paid
</p>

<h3 class="text-4xl font-extrabold text-orange-500">
₹<?php echo $p['grand_total']; ?>
</h3>

<p class="text-sm text-gray-500 mt-3">
Order Status:
<span class="font-semibold text-gray-700">
<?php echo ucfirst(str_replace('_',' ',$p['order_status'])); ?>
</span>
</p>

</div>

</div>

<!-- TRANSACTION -->
<div class="mt-6 bg-gray-50 rounded-2xl p-5 border border-gray-100">

<p class="text-gray-500 text-sm mb-2">
Transaction ID
</p>

<p class="font-bold text-gray-800 break-all">

<?php
if(!empty($p['transaction_id'])){

    echo $p['transaction_id'];

} else {

    echo "N/A";
}
?>

</p>

</div>

<!-- BUTTONS -->
<div class="mt-6 flex flex-col md:flex-row gap-4">

<a href="order_details.php?id=<?php echo $p['order_id']; ?>"
class="flex-1 bg-orange-500 hover:bg-orange-600 text-white text-center py-4 rounded-2xl font-bold shadow-lg transition">

View Order →

</a>

<a href="invoice.php?order_id=<?php echo $p['order_id']; ?>"
target="_blank"
class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 text-center py-4 rounded-2xl font-bold transition">

Download Invoice 🧾

</a>

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