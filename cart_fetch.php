<?php
if (session_status() === PHP_SESSION_NONE) session_start();

include("db.php");

$user_id = $_SESSION['user_id'] ?? 0;

if(!$user_id){

    echo "
    <p class='text-red-500 text-center p-4'>
        Login required
    </p>
    ";

    exit;
}

// FETCH CART
$cart = mysqli_query($conn,"
SELECT c.*, f.name 
FROM cart c
JOIN admin_food_items f 
ON f.food_id=c.food_id
WHERE c.user_id='$user_id'
");

$total = 0;

if(mysqli_num_rows($cart) == 0){

    echo "
    <div class='text-center py-10 text-gray-500'>
        🛒 Your cart is empty
    </div>
    ";

    exit;
}
?>

<script>

// UPDATE CART
function updateCart(id, change){

    let fd = new FormData();

    fd.append("update", true);
    fd.append("id", id);
    fd.append("change", change);

    fetch("cart_action.php", {

        method: "POST",

        body: fd

    })

    .then(res => res.text())

    .then(data => {

        document.getElementById("cartBox").innerHTML = data;

    });

}

// REMOVE ITEM
function removeItem(id){

    if(!confirm("Remove this item from cart?")){
        return;
    }

    let fd = new FormData();

    fd.append("remove", id);

    fetch("cart_action.php", {

        method: "POST",

        body: fd

    })

    .then(res => res.text())

    .then(data => {

        document.getElementById("cartBox").innerHTML = data;

    });

}

</script>

<script src="https://cdn.tailwindcss.com"></script>

<div class="bg-white rounded-2xl shadow-lg p-5">

<!-- HEADER -->
<div class="flex items-center justify-between mb-5">

<h2 class="text-xl font-bold flex items-center gap-2">
🛒 Your Cart
</h2>

<span class="bg-orange-100 text-orange-600 px-3 py-1 rounded-full text-sm font-semibold">
<?php echo mysqli_num_rows($cart); ?> Items
</span>

</div>

<!-- ITEMS -->
<div class="space-y-4">

<?php

while($c = mysqli_fetch_assoc($cart)){

    $sub = $c['price'] * $c['quantity'];

    $total += $sub;
?>

<div class="border rounded-2xl p-4 hover:shadow-md transition bg-gray-50">

<div class="flex justify-between items-start gap-4">

<!-- LEFT -->
<div class="flex-1">

<h3 class="font-bold text-gray-800 text-lg">
<?php echo $c['name']; ?>
</h3>

<?php if(!empty($c['variant'])){ ?>

<p class="text-sm text-orange-500 mt-1">
<?php echo $c['variant']; ?>
</p>

<?php } ?>

<p class="text-sm text-gray-500 mt-2">
₹<?php echo $c['price']; ?> × <?php echo $c['quantity']; ?>
</p>

</div>

<!-- QTY -->
<div class="flex items-center gap-2 bg-white rounded-xl px-2 py-1 shadow">

<button onclick="updateCart(<?php echo $c['cart_id']; ?>,-1)"
class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-orange-100 text-lg font-bold">

−

</button>

<span class="w-8 text-center font-bold">
<?php echo $c['quantity']; ?>
</span>

<button onclick="updateCart(<?php echo $c['cart_id']; ?>,1)"
class="w-8 h-8 rounded-lg bg-gray-100 hover:bg-orange-100 text-lg font-bold">

+

</button>

</div>

<!-- PRICE -->
<div class="text-right">

<p class="font-bold text-lg text-gray-800">
₹<?php echo $sub; ?>
</p>

<button onclick="removeItem(<?php echo $c['cart_id']; ?>)"
class="text-sm text-red-500 hover:text-red-700 hover:underline mt-2">

🗑 Remove

</button>

</div>

</div>

</div>

<?php } ?>

</div>

<?php

$gst = round($total * 0.18, 2);

$grand_total = $total + $gst;

?>

<!-- TOTAL -->
<div class="mt-6 border-t pt-5 space-y-3">

<div class="flex justify-between text-gray-600">

<span>Subtotal</span>

<span>₹<?php echo $total; ?></span>

</div>

<div class="flex justify-between text-gray-600">

<span>Delivery</span>

<span class="text-green-600 font-semibold">
FREE
</span>

</div>

<div class="flex justify-between text-gray-600">

<span>GST (18%)</span>

<span>
₹<?php echo $gst; ?>
</span>

</div>

<hr>

<div class="flex justify-between text-2xl font-bold">

<span>Total</span>

<span class="text-orange-500">
₹<?php echo $grand_total; ?>
</span>

</div>

</div>

<!-- CHECKOUT -->
<a href="checkout.php"
class="block mt-6 bg-orange-500 hover:bg-orange-600 transition text-white text-center py-4 rounded-2xl font-bold shadow-lg">

Proceed to Checkout →

</a>

</div>