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
$user = mysqli_fetch_assoc(mysqli_query($conn,"
SELECT * FROM users 
WHERE user_id='$user_id'
"));

// CART
$cart = mysqli_query($conn,"
SELECT 
    c.*, 
    f.name
FROM cart c
JOIN admin_food_items f 
ON f.food_id = c.food_id
WHERE c.user_id='$user_id'
");

if(mysqli_num_rows($cart) == 0){

    echo "
    <div class='min-h-screen flex items-center justify-center'>
        <div class='bg-white p-10 rounded-3xl shadow-xl text-center'>
            <h2 class='text-3xl font-bold text-gray-700 mb-3'>
                🛒 Cart is Empty
            </h2>
            <p class='text-gray-500 mb-6'>
                Add delicious food to continue.
            </p>
            <a href='menu.php'
            class='bg-orange-500 text-white px-6 py-3 rounded-xl hover:bg-orange-600'>
                Browse Menu
            </a>
        </div>
    </div>
    ";

    include("assets/footer.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Checkout - QuickBites</title>

<script src="https://cdn.tailwindcss.com"></script>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body class="bg-gradient-to-br from-orange-50 via-white to-orange-100 min-h-screen">

<div class="max-w-7xl mx-auto px-4 py-10">

<!-- PAGE HEADER -->
<div class="text-center mb-10">

<h1 class="text-5xl font-extrabold text-gray-800 mb-3">
Checkout
</h1>

<p class="text-gray-500 text-lg">
Complete your order securely and quickly
</p>

</div>

<div class="grid lg:grid-cols-3 gap-8">

<!-- LEFT SECTION -->
<div class="lg:col-span-2 space-y-8">

<!-- DELIVERY DETAILS -->
<div class="bg-white rounded-3xl shadow-xl border border-orange-100 p-8">

<div class="flex items-center gap-4 mb-6">

<div class="w-14 h-14 bg-orange-100 rounded-2xl flex items-center justify-center text-3xl">
📦
</div>

<div>

<h2 class="text-2xl font-bold text-gray-800">
Delivery Details
</h2>

<p class="text-gray-500">
Enter your delivery information
</p>

</div>

</div>

<form id="orderForm" method="POST" action="place_order.php">

<div class="grid md:grid-cols-2 gap-5">

<div>

<label class="block text-sm font-semibold text-gray-600 mb-2">
Full Name
</label>

<input type="text"
name="name"
value="<?php echo htmlspecialchars($user['name']); ?>"
class="w-full border border-gray-200 p-4 rounded-2xl focus:ring-2 focus:ring-orange-400 outline-none"
required>

</div>

<div>

<label class="block text-sm font-semibold text-gray-600 mb-2">
Phone Number
</label>

<input type="text"
name="phone"
value="<?php echo htmlspecialchars($user['phone']); ?>"
class="w-full border border-gray-200 p-4 rounded-2xl focus:ring-2 focus:ring-orange-400 outline-none"
required>

</div>

</div>

<div class="mt-5">

<label class="block text-sm font-semibold text-gray-600 mb-2">
Delivery Address
</label>

<textarea name="address"
rows="4"
class="w-full border border-gray-200 p-4 rounded-2xl focus:ring-2 focus:ring-orange-400 outline-none"
required><?php echo htmlspecialchars($user['address']); ?></textarea>

</div>

<!-- PAYMENT METHOD -->
<div class="mt-8">

<h3 class="text-xl font-bold text-gray-800 mb-5">
💳 Payment Method
</h3>

<div class="grid md:grid-cols-2 gap-5">

<!-- COD -->
<label class="cursor-pointer">

<input type="radio"
name="payment"
value="COD"
class="hidden peer"
checked>

<div class="border-2 border-gray-200 peer-checked:border-orange-500 rounded-2xl p-5 transition hover:shadow-md">

<div class="flex justify-between items-center">

<div>

<h4 class="font-bold text-lg">
Cash on Delivery
</h4>

<p class="text-sm text-gray-500">
Pay after delivery
</p>

</div>

<div class="text-3xl">
💵
</div>

</div>

</div>

</label>

<!-- ONLINE -->
<label class="cursor-pointer">

<input type="radio"
name="payment"
value="ONLINE"
class="hidden peer">

<div class="border-2 border-gray-200 peer-checked:border-orange-500 rounded-2xl p-5 transition hover:shadow-md">

<div class="flex justify-between items-center">

<div>

<h4 class="font-bold text-lg">
Pay Online
</h4>

<p class="text-sm text-gray-500">
UPI, Cards, Wallets
</p>

</div>

<div class="text-3xl">
💳
</div>

</div>

</div>

</label>

</div>

</div>

<!-- PLACE ORDER BUTTON -->
<button type="submit"
class="w-full mt-8 bg-orange-500 hover:bg-orange-600 text-white py-4 rounded-2xl text-lg font-bold shadow-lg transition">

Place Order

</button>

</form>

</div>

</div>

<!-- RIGHT SECTION -->
<div>

<div class="bg-white rounded-3xl shadow-xl border border-orange-100 p-6 sticky top-24">

<h2 class="text-2xl font-bold text-gray-800 mb-6">
🧾 Order Summary
</h2>

<div class="space-y-4">

<?php

$total = 0;

mysqli_data_seek($cart, 0);

while($c = mysqli_fetch_assoc($cart)){

    $sub = $c['price'] * $c['quantity'];

    $total += $sub;
?>

<div class="flex justify-between items-center bg-gray-50 p-4 rounded-2xl">

<div>

<h4 class="font-bold text-gray-800">
<?php echo $c['name']; ?>
</h4>

<p class="text-sm text-gray-500">
Quantity: <?php echo $c['quantity']; ?>
</p>

<?php if(!empty($c['variant'])){ ?>

<p class="text-xs text-orange-500">
Variant: <?php echo $c['variant']; ?>
</p>

<?php } ?>

</div>

<div class="font-bold text-orange-500 text-lg">
₹<?php echo $sub; ?>
</div>

</div>

<?php } ?>

</div>

<?php
$gst = round($total * 0.18, 2);
$grand_total = $total + $gst;
?>

<hr class="my-6">

<div class="space-y-4 text-sm">

<div class="flex justify-between text-gray-600">
<span>Subtotal</span>
<span>₹<?php echo $total; ?></span>
</div>

<div class="flex justify-between text-gray-600">
<span>GST (18%)</span>
<span>₹<?php echo $gst; ?></span>
</div>

<div class="flex justify-between text-green-600">
<span>Delivery Fee</span>
<span>FREE</span>
</div>

<hr>

<div class="flex justify-between text-2xl font-bold text-gray-800">

<span>Total</span>

<span class="text-orange-500">
₹<?php echo $grand_total; ?>
</span>

</div>

</div>

</div>

</div>

</div>

</div>

<!-- RAZORPAY -->
<script>

document.getElementById("orderForm").addEventListener("submit", function(e){

    let payment =
    document.querySelector('input[name="payment"]:checked').value;

    if(payment === "ONLINE"){

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

                name: "QuickBites",

                description: "Food Order Payment",

                image: "https://cdn-icons-png.flaticon.com/512/1046/1046784.png",

                order_id: data.id,

                theme: {
                    color: "#f97316"
                },

                handler: function (response){

                    fetch("verify_payment.php", {

                        method: "POST",

                        headers: {
                            "Content-Type":"application/json"
                        },

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

</body>
</html>