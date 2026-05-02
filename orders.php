<?php
session_start();
include("db.php");
include("assets/navbar.php");

$user_id = $_SESSION['user_id'] ?? 0;

$orders = mysqli_query($conn,"
SELECT * FROM orders 
WHERE user_id='$user_id' 
ORDER BY order_id DESC
");
?>

<script src="https://cdn.tailwindcss.com"></script>

<div class="max-w-5xl mx-auto p-6">

<h2 class="text-2xl font-bold mb-6">📦 My Orders</h2>

<?php if(mysqli_num_rows($orders)==0){ ?>
<p class="text-gray-500">No orders yet</p>
<?php } ?>

<?php while($o = mysqli_fetch_assoc($orders)){ ?>

<div class="bg-white p-4 rounded-xl shadow mb-4">

<div class="flex justify-between">
    <div>
        <p class="font-bold">Order #<?php echo $o['order_id']; ?></p>
        <p class="text-sm text-gray-500"><?php echo $o['created_at']; ?></p>
    </div>

    <div class="text-right">
        <p class="font-semibold text-orange-500">₹<?php echo $o['total_amount']; ?></p>
        <p class="text-sm">
            <?php echo $o['order_status']; ?>
        </p>
    </div>
</div>

<a href="order_details.php?id=<?php echo $o['order_id']; ?>"
class="text-blue-500 text-sm mt-2 inline-block">
View Details →
</a>

</div>

<?php } ?>

</div>

<?php include("assets/footer.php"); ?>