<?php
session_start();
include("db.php");
include("assets/navbar.php");

$order_id = $_GET['id'];

$order = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM orders WHERE order_id='$order_id'"));

$items = mysqli_query($conn,"
SELECT * FROM order_items WHERE order_id='$order_id'
");
?>

<div class="max-w-4xl mx-auto p-6">

<h2 class="text-xl font-bold mb-4">Order #<?php echo $order_id; ?></h2>

<!-- STATUS TRACK -->
<div class="mb-6">
<p class="font-semibold">Status:</p>

<?php
$status = $order['order_status'];
?>

<div class="flex gap-4 mt-2">

<span class="<?php echo $status=='Pending'?'text-green-600 font-bold':''; ?>">📦 Pending</span>
<span class="<?php echo $status=='Preparing'?'text-green-600 font-bold':''; ?>">👨‍🍳 Preparing</span>
<span class="<?php echo $status=='Out for Delivery'?'text-green-600 font-bold':''; ?>">🚚 Out</span>
<span class="<?php echo $status=='Delivered'?'text-green-600 font-bold':''; ?>">✅ Delivered</span>

</div>
</div>

<!-- ITEMS -->
<?php while($i = mysqli_fetch_assoc($items)){ ?>

<div class="flex justify-between border-b py-2">
<span><?php echo $i['name']; ?> x <?php echo $i['quantity']; ?></span>
<span>₹<?php echo $i['price'] * $i['quantity']; ?></span>
</div>

<?php } ?>

<div class="mt-4 font-bold">
Total: ₹<?php echo $order['total_amount']; ?>
</div>

</div>

<?php include("assets/footer.php"); ?>