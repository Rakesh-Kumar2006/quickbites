<?php
session_start();
include("db.php");

$msg = "";

if(isset($_POST['send_message'])){

    $name  = mysqli_real_escape_string($conn, $_POST['name']);
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
<title>Contact Us</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-orange-100 to-orange-200 min-h-screen">

<!-- NAVBAR -->
<?php include("assets/navbar.php"); ?>

<div class="flex items-center justify-center py-12 px-4">

<div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-5xl grid md:grid-cols-2 gap-8">

<!-- LEFT -->
<div class="space-y-6">

<h2 class="text-3xl font-bold text-orange-500">Contact Us</h2>

<p class="text-gray-600">
Have questions or feedback? Send us a message!
</p>

<div class="space-y-2 text-gray-700">
<p>📍 jamnagar, Gujarat</p>
<p>📞 +91 98986 06330</p>
<p>✉ quickbites@gmail.com</p>
</div>

</div>

<!-- RIGHT FORM -->
<div>

<?php if($msg){ ?>
<p class="bg-green-100 text-green-700 p-3 rounded mb-4">
<?php echo $msg; ?>
</p>
<?php } ?>

<form method="POST" class="space-y-4">

<input type="text" name="name" placeholder="Your Name"
class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-orange-400" required>

<input type="email" name="email" placeholder="Your Email"
class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-orange-400" required>

<textarea name="message" rows="5" placeholder="Your Message"
class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-orange-400" required></textarea>

<button name="send_message"
class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-lg font-semibold">
Send Message
</button>

</form>

</div>

</div>

</div>

<!-- FOOTER -->
<?php include("assets/footer.php"); ?>

</body>
</html>