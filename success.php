<?php
include("assets/navbar.php");

$order_id = $_GET['order_id'] ?? 0;
?>

<div class="min-h-screen flex items-center justify-center">

<div class="bg-white p-10 rounded-xl shadow text-center">

<h2 class="text-2xl font-bold text-green-600 mb-2">
✅ Order Placed Successfully!
</h2>

<p class="text-gray-500 mb-4">
Your Order ID: #<?php echo $order_id; ?>
</p>

<a href="home.php"
class="bg-orange-500 text-white px-6 py-2 rounded">
Back to Home
</a>

</div>

</div>

<?php include("assets/footer.php"); ?>