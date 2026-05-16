<?php
session_start();

include("db.php");
include("send_otp.php");

$msg = "";

// SEND OTP
if(isset($_POST['send_otp'])){

    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone    = mysqli_real_escape_string($conn, $_POST['phone']);
    $address  = mysqli_real_escape_string($conn, $_POST['address']);

    // IMAGE UPLOAD
    $image = "";

    if(!empty($_FILES['image']['name'])){

        $image = time() . "_" . basename($_FILES['image']['name']);

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "uploads/".$image
        );
    }

    // CHECK EMAIL
    $check = mysqli_query($conn,"
    SELECT * FROM users
    WHERE email='$email'
    ");

    if(mysqli_num_rows($check) > 0){

        $msg = "Email already exists!";

    } else {

        // STORE SESSION
        $_SESSION['reg_data'] = [

            'name'     => $name,
            'email'    => $email,
            'password' => $password,
            'phone'    => $phone,
            'address'  => $address,
            'image'    => $image

        ];

        // OTP
        $otp = rand(100000,999999);

        $_SESSION['otp'] = $otp;

        if(sendOTP($email, $otp)){

            header("Location: verify_otp.php");
            exit();

        } else {

            $msg = "Failed to send OTP!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>

<title>Register - QuickBites</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gradient-to-br from-orange-50 via-white to-orange-100 min-h-screen">

<div class="min-h-screen flex items-center justify-center px-4 py-10">

<!-- CARD -->
<div class="w-full max-w-lg bg-white rounded-3xl shadow-2xl p-8">

<!-- LOGO -->
<div class="text-center mb-8">

<div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">

<span class="text-4xl">
🍔
</span>

</div>

<h1 class="text-4xl font-extrabold text-gray-800 mb-2">
Create Account
</h1>

<p class="text-gray-500">
Join QuickBites and order delicious food online
</p>

</div>

<!-- ERROR -->
<?php if($msg){ ?>

<div class="bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-2xl mb-6 text-center">

<?php echo $msg; ?>

</div>

<?php } ?>

<!-- FORM -->
<form method="POST"
enctype="multipart/form-data"
class="space-y-5">

<!-- PROFILE -->
<div class="text-center">

<img id="preview"
src="https://via.placeholder.com/120"
class="w-28 h-28 rounded-full object-cover border-4 border-orange-200 shadow-lg mx-auto mb-4">

<label class="inline-block bg-orange-500 hover:bg-orange-600 text-white px-5 py-2 rounded-xl cursor-pointer transition font-semibold">

Upload Photo

<input type="file"
name="image"
accept="image/*"
onchange="previewImage(event)"
class="hidden">

</label>

</div>

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

<!-- PASSWORD -->
<div>

<label class="block text-sm font-semibold text-gray-600 mb-2">
Password
</label>

<input type="password"
name="password"
placeholder="Enter your password"
class="w-full border border-gray-200 p-4 rounded-2xl focus:ring-2 focus:ring-orange-400 outline-none transition"
required>

</div>

<!-- PHONE -->
<div>

<label class="block text-sm font-semibold text-gray-600 mb-2">
Phone Number
</label>

<input type="text"
name="phone"
placeholder="Enter your phone number"
class="w-full border border-gray-200 p-4 rounded-2xl focus:ring-2 focus:ring-orange-400 outline-none transition"
required>

</div>

<!-- ADDRESS -->
<div>

<label class="block text-sm font-semibold text-gray-600 mb-2">
Address
</label>

<textarea name="address"
rows="3"
placeholder="Enter your address"
class="w-full border border-gray-200 p-4 rounded-2xl focus:ring-2 focus:ring-orange-400 outline-none transition resize-none"></textarea>

</div>

<!-- BUTTON -->
<button type="submit"
name="send_otp"
class="w-full bg-orange-500 hover:bg-orange-600 text-white py-4 rounded-2xl text-lg font-bold shadow-lg transition">

Send OTP 🚀

</button>

</form>

<!-- LOGIN -->
<p class="text-center mt-8 text-gray-500">

Already have an account?

<a href="login.php"
class="text-orange-500 font-bold hover:underline">

Login

</a>

</p>

</div>

</div>

<!-- IMAGE PREVIEW -->
<script>

function previewImage(event){

    const reader = new FileReader();

    reader.onload = function(){

        document.getElementById('preview').src = reader.result;

    }

    reader.readAsDataURL(event.target.files[0]);

}

</script>

</body>
</html>