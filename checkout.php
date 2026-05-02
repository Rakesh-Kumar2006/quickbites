<?php
session_start();
include("db.php");
include("assets/navbar.php");

$user_id = $_SESSION['user_id'] ?? 0;

if(!$user_id){
    header("Location: login.php");
    exit();
}

// USER
$user = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM users WHERE user_id='$user_id'"));

// CART
$cart = mysqli_query($conn,"
SELECT c.*, f.name 
FROM cart c
JOIN admin_food_items f ON f.food_id=c.food_id
WHERE c.user_id='$user_id'
");

if(mysqli_num_rows($cart) == 0){
    echo "<div class='p-10 text-center text-gray-500'>Cart is empty</div>";
    include("assets/footer.php");
    exit;
}
?>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<div class="max-w-7xl mx-auto px-6 py-10">

<div class="grid md:grid-cols-3 gap-8">

<!-- LEFT -->
<div class="md:col-span-2 bg-white p-8 rounded-3xl shadow-xl border">

<h2 class="text-2xl font-bold mb-6">📦 Delivery Details</h2>

<form id="orderForm" method="POST" action="place_order.php">

<div class="grid md:grid-cols-2 gap-4">

<input type="text" name="name" value="<?php echo $user['name']; ?>"
class="border p-3 rounded-xl" required>

<input type="text" name="phone" value="<?php echo $user['phone']; ?>"
class="border p-3 rounded-xl" required>

</div>

<textarea name="address"
class="w-full border p-3 rounded-xl mt-4"
required><?php echo $user['address']; ?></textarea>

<!-- PAYMENT -->
<div class="mt-6">

<p class="font-semibold mb-2">💳 Payment Method</p>

<label class="flex gap-2">
<input type="radio" name="payment" value="cod" checked>
Cash on Delivery
</label>

<label class="flex gap-2">
<input type="radio" name="payment" value="online">
Pay Online (Razorpay)
</label>

</div>

<button type="submit"
class="w-full mt-6 bg-orange-500 text-white py-3 rounded-xl">
Place Order
</button>

</form>

</div>

<!-- RIGHT -->
<div class="bg-white p-6 rounded-3xl shadow-xl border sticky top-24">

<h2 class="font-bold text-lg mb-4">🧾 Order Summary</h2>

<div class="space-y-3">

<?php 
$total = 0;
mysqli_data_seek($cart, 0);

while($c = mysqli_fetch_assoc($cart)){
    $sub = $c['price'] * $c['quantity'];
    $total += $sub;
?>

<div class="flex justify-between text-sm">
<span><?php echo $c['name']; ?> x <?php echo $c['quantity']; ?></span>
<span>₹<?php echo $sub; ?></span>
</div>

<?php } ?>

</div>

<?php
$gst = round($total * 0.18, 2);
$grand_total = $total + $gst;
?>

<hr class="my-3">

<div class="text-sm space-y-1">

<div class="flex justify-between">
<span>Subtotal</span>
<span>₹<?php echo $total; ?></span>
</div>

<div class="flex justify-between">
<span>GST (18%)</span>
<span>₹<?php echo $gst; ?></span>
</div>

<div class="flex justify-between font-bold">
<span>Total</span>
<span>₹<?php echo $grand_total; ?></span>
</div>

</div>

</div>

</div>
</div>

<!-- JS -->
<script>
document.getElementById("orderForm").addEventListener("submit", function(e){

    let payment = document.querySelector('input[name="payment"]:checked').value;

    if(payment === "online"){
        e.preventDefault();

        fetch("create_order.php")
        .then(res => res.json())
        .then(data => {

            if(data.error){
                alert(data.error);
                return;
            }

            var options = {
                key: "rzp_test_SipD325fcq3F72",
                amount: data.amount,
                currency: "INR",
                name: "QuickBite",
                order_id: data.id,

                handler: function (response){

                    fetch("verify_payment.php", {
                        method: "POST",
                        headers: {"Content-Type":"application/json"},
                        body: JSON.stringify(response)
                    })
                    .then(() => {
                        document.getElementById("orderForm").submit();
                    });
                }
            };

            new Razorpay(options).open();
        });
    }
});
</script>

<?php include("assets/footer.php"); ?>