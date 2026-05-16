<?php
session_start();

include("db.php");
include("assets/navbar.php");

$user_id = $_SESSION['user_id'] ?? 0;

if(!$user_id){

    header("Location: login.php");
    exit();
}

$msg = "";

// SUBMIT COMPLAINT
if(isset($_POST['submit_complaint'])){

    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    $issue_type = mysqli_real_escape_string($conn, $_POST['issue_type']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    mysqli_query($conn,"
    INSERT INTO complaints(
        order_id,
        user_id,
        issue_type,
        message,
        created_at
    )
    VALUES(
        '$order_id',
        '$user_id',
        '$issue_type',
        '$message',
        NOW()
    )
    ");

    $msg = "Complaint submitted successfully!";
}

// USER ORDERS
$orders = mysqli_query($conn,"
SELECT * FROM orders
WHERE user_id='$user_id'
ORDER BY order_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>

<title>Raise Complaint - QuickBites</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gradient-to-br from-orange-50 via-white to-orange-100 min-h-screen">



<div class="max-w-5xl mx-auto px-4 py-10">

<!-- BACK -->
<a href="orders.php"
class="inline-flex items-center gap-2 bg-white hover:bg-orange-500 hover:text-white transition px-6 py-3 rounded-2xl shadow-lg font-bold mb-8">

← Back to Orders

</a>

<!-- TOP -->
<div class="text-center mb-10">

<div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-5 shadow-lg">

<span class="text-5xl">
⚠️
</span>

</div>

<h1 class="text-5xl font-extrabold text-gray-800 mb-3">
Raise Complaint
</h1>

<p class="text-gray-500 text-lg max-w-2xl mx-auto">
Facing issues with your order? Let us know and our support team
will resolve it quickly.
</p>

</div>

<!-- SUCCESS -->
<?php if($msg){ ?>

<div class="bg-green-100 border border-green-300 text-green-700 px-6 py-4 rounded-2xl mb-8 text-center shadow">

✅ <?php echo $msg; ?>

</div>

<?php } ?>

<!-- CARD -->
<div class="bg-white rounded-3xl shadow-2xl overflow-hidden grid lg:grid-cols-2">

<!-- LEFT -->
<div class="hidden lg:flex relative">

<img src="uploads/complaint.jpg"
class="w-full h-full object-cover"
onerror="this.src='https://images.unsplash.com/photo-1520607162513-77705c0f0d4a?q=80&w=1200&auto=format&fit=crop'">

<div class="absolute inset-0 bg-black/40"></div>

<div class="absolute bottom-10 left-10 text-white z-10">

<h2 class="text-4xl font-extrabold mb-4">
Customer Support 💬
</h2>

<p class="text-lg text-gray-200 max-w-sm">
Your satisfaction matters to us. Report delivery,
food, or service issues instantly.
</p>

</div>

</div>

<!-- RIGHT -->
<div class="p-8 lg:p-10">

<h2 class="text-3xl font-bold text-gray-800 mb-8">
Complaint Form
</h2>

<form method="POST" class="space-y-6">

<!-- ORDER -->
<div>

<label class="block text-sm font-semibold text-gray-600 mb-2">
Select Order
</label>

<select name="order_id"
class="w-full border border-gray-200 p-4 rounded-2xl focus:ring-2 focus:ring-orange-400 outline-none transition"
required>

<option value="">
Choose Order
</option>

<?php while($o = mysqli_fetch_assoc($orders)){ ?>

<option value="<?php echo $o['order_id']; ?>">

Order #<?php echo $o['order_id']; ?>
- ₹<?php echo $o['grand_total']; ?>

</option>

<?php } ?>

</select>

</div>

<!-- ISSUE TYPE -->
<div>

<label class="block text-sm font-semibold text-gray-600 mb-2">
Issue Type
</label>

<select name="issue_type"
class="w-full border border-gray-200 p-4 rounded-2xl focus:ring-2 focus:ring-orange-400 outline-none transition"
required>

<option value="">
Select Issue
</option>

<option value="late">
Late Delivery
</option>

<option value="rude">
Rude Behaviour
</option>

<option value="wrong_order">
Wrong Order
</option>

<option value="other">
Other
</option>

</select>

</div>

<!-- MESSAGE -->
<div>

<label class="block text-sm font-semibold text-gray-600 mb-2">
Complaint Message
</label>

<textarea name="message"
rows="6"
placeholder="Describe your issue..."
class="w-full border border-gray-200 p-4 rounded-2xl focus:ring-2 focus:ring-orange-400 outline-none transition resize-none"
required></textarea>

</div>

<!-- BUTTON -->
<button type="submit"
name="submit_complaint"
class="w-full bg-red-500 hover:bg-red-600 text-white py-4 rounded-2xl text-lg font-bold shadow-lg transition">

Submit Complaint 🚨

</button>

</form>

</div>

</div>

</div>

<!-- FOOTER -->
<?php include("assets/footer.php"); ?>

</body>
</html>