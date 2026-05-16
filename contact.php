<?php
session_start();
include("db.php");

$msg = "";

if(isset($_POST['send_message'])){

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    mysqli_query($conn,"
    INSERT INTO contact_messages(name,email,message,created_at)
    VALUES('$name','$email','$message',NOW())
    ");

    $msg = "Message sent successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Contact Us - QuickBites</title>

<script src="https://cdn.tailwindcss.com"></script>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body class="bg-gradient-to-br from-orange-50 via-white to-orange-100 min-h-screen">

<!-- NAVBAR -->
<?php include("assets/navbar.php"); ?>

<!-- BACK BUTTON -->
<div class="max-w-7xl mx-auto px-4 pt-6">

<a href="home.php"
class="inline-flex items-center gap-2 bg-white hover:bg-orange-500 hover:text-white transition px-6 py-3 rounded-2xl shadow-lg font-bold">

← Back to Home

</a>

</div>

<div class="max-w-7xl mx-auto px-4 py-12">

<!-- TOP -->
<div class="text-center mb-12">

<h1 class="text-5xl font-extrabold text-gray-800 mb-4">
📞 Contact Us
</h1>

<p class="text-gray-500 text-lg max-w-2xl mx-auto">
We’d love to hear from you. Send us your questions,
feedback, or support requests anytime.
</p>

</div>

<div class="grid lg:grid-cols-2 gap-10 items-center">

<!-- LEFT SIDE -->
<div class="space-y-8">

<!-- IMAGE -->
<div class="rounded-3xl overflow-hidden shadow-2xl">

<img src="uploads/contact.jpg"
class="w-full h-[450px] object-cover"
onerror="this.src='https://via.placeholder.com/800x450?text=QuickBites+Contact'">

</div>

<!-- CONTACT INFO -->
<div class="grid md:grid-cols-3 gap-5">

<!-- ADDRESS -->
<div class="bg-white rounded-2xl shadow-lg p-6 text-center border border-orange-100">

<div class="text-4xl mb-3">
📍
</div>

<h3 class="font-bold text-lg text-gray-800 mb-2">
Location
</h3>

<p class="text-gray-500 text-sm">
Jamnagar, Gujarat
</p>

</div>

<!-- PHONE -->
<div class="bg-white rounded-2xl shadow-lg p-6 text-center border border-orange-100">

<div class="text-4xl mb-3">
📞
</div>

<h3 class="font-bold text-lg text-gray-800 mb-2">
Phone
</h3>

<p class="text-gray-500 text-sm">
+91 98986 06330
</p>

</div>

<!-- EMAIL -->
<div class="bg-white rounded-2xl shadow-lg p-6 text-center border border-orange-100">

<div class="text-4xl mb-3">
✉️
</div>

<h3 class="font-bold text-lg text-gray-800 mb-2">
Email
</h3>

<p class="text-gray-500 text-sm break-all">
quickbites@gmail.com
</p>

</div>

</div>

</div>

<!-- RIGHT SIDE -->
<div class="bg-white rounded-3xl shadow-2xl p-8 border border-orange-100">

<div class="mb-8">

<h2 class="text-3xl font-bold text-gray-800 mb-2">
Send a Message
</h2>

<p class="text-gray-500">
Fill the form below and we’ll get back to you soon.
</p>

</div>

<!-- SUCCESS MESSAGE -->
<?php if($msg){ ?>

<div class="bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-2xl mb-6">

✅ <?php echo $msg; ?>

</div>

<?php } ?>

<!-- FORM -->
<form method="POST" class="space-y-6">

<!-- NAME -->
<div>

<label class="block text-sm font-semibold text-gray-600 mb-2">
Full Name
</label>

<input type="text"
name="name"
placeholder="Enter your full name"
class="w-full border border-gray-200 p-4 rounded-2xl focus:ring-2 focus:ring-orange-400 outline-none transition"
required>

</div>

<!-- EMAIL -->
<div>

<label class="block text-sm font-semibold text-gray-600 mb-2">
Email Address
</label>

<input type="email"
name="email"
placeholder="Enter your email"
class="w-full border border-gray-200 p-4 rounded-2xl focus:ring-2 focus:ring-orange-400 outline-none transition"
required>

</div>

<!-- MESSAGE -->
<div>

<label class="block text-sm font-semibold text-gray-600 mb-2">
Your Message
</label>

<textarea name="message"
rows="6"
placeholder="Write your message here..."
class="w-full border border-gray-200 p-4 rounded-2xl focus:ring-2 focus:ring-orange-400 outline-none transition resize-none"
required></textarea>

</div>

<!-- BUTTON -->
<button type="submit"
name="send_message"
class="w-full bg-orange-500 hover:bg-orange-600 text-white py-4 rounded-2xl text-lg font-bold shadow-lg transition">

Send Message 🚀

</button>

</form>

</div>

</div>

</div>

<!-- FOOTER -->
<?php include("assets/footer.php"); ?>

</body>
</html>