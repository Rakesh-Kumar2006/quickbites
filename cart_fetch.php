<?php
if (session_status() === PHP_SESSION_NONE) session_start();
include("db.php");

$user_id = $_SESSION['user_id'] ?? 0;

if(!$user_id){
    echo "<p class='text-red-500'>Login required</p>";
    exit;
}

$cart = mysqli_query($conn,"
SELECT c.*, f.name 
FROM cart c
JOIN admin_food_items f ON f.food_id=c.food_id
WHERE c.user_id='$user_id'
");

$total = 0;

if(mysqli_num_rows($cart) == 0){
    echo "<div class='text-center py-10 text-gray-500'>
            🛒 Your cart is empty
          </div>";
    exit;
}
?>

<script src="https://cdn.tailwindcss.com"></script>

<div class="bg-white rounded-xl shadow p-4">

<h2 class="text-lg font-bold mb-4 flex items-center gap-2">
🛒 Your Cart
</h2>

<?php while($c = mysqli_fetch_assoc($cart)){
    $sub = $c['price'] * $c['quantity'];
    $total += $sub;
?>

<!-- ITEM -->
<div class="flex justify-between items-center border-b py-4">

    <!-- LEFT -->
    <div class="flex-1">
        <p class="font-semibold text-gray-800">
            <?php echo $c['name']; ?>
        </p>

        <p class="text-xs text-gray-500">
            <?php echo $c['variant']; ?>
        </p>

        <p class="text-sm font-semibold text-gray-700 mt-1">
            ₹<?php echo $c['price']; ?> × <?php echo $c['quantity']; ?>
        </p>
    </div>

    <!-- CENTER QTY -->
    <div class="flex items-center gap-2 bg-gray-100 rounded-lg px-2 py-1">

        <button onclick="updateCart(<?php echo $c['cart_id']; ?>,-1)"
        class="px-2 text-lg font-bold text-gray-600 hover:text-black">
            −
        </button>

        <span class="w-6 text-center font-semibold">
            <?php echo $c['quantity']; ?>
        </span>

        <button onclick="updateCart(<?php echo $c['cart_id']; ?>,1)"
        class="px-2 text-lg font-bold text-gray-600 hover:text-black">
            +
        </button>

    </div>

    <!-- RIGHT -->
    <div class="text-right ml-4">

        <p class="font-bold text-gray-800">
            ₹<?php echo $sub; ?>
        </p>

        <button onclick="removeItem(<?php echo $c['cart_id']; ?>)"
        class="text-xs text-red-500 hover:underline">
            Remove
        </button>

    </div>

</div>

<?php } ?>
<?php
$gst = round($total * 0.18, 2);
$grand_total = $total + $gst;
?>

<!-- TOTAL -->
<div class="mt-4 space-y-2">

<div class="flex justify-between text-sm text-gray-600">
    <span>Subtotal</span>
    <span>₹<?php echo $total; ?></span>
</div>

<div class="flex justify-between text-sm text-gray-600">
    <span>Delivery</span>
    <span class="text-green-600">FREE</span>
</div>

<div class="flex justify-between text-sm text-gray-600">
    <span>GST (18%)</span>
    <span>₹<?php echo $gst; ?></span>
</div>

<hr>

<div class="flex justify-between text-lg font-bold">
    <span>Total Payable</span>
    <span class="text-black-500">₹<?php echo $grand_total; ?></span>
</div>

</div>
<!-- BUTTON -->
<a href="checkout.php"
class="block mt-4 bg-orange-500 hover:bg-orange-600 text-white text-center py-3 rounded-xl font-semibold shadow">
Proceed to Checkout →
</a>

</div>