<?php
session_start();
include("db.php");
include("send_otp.php"); // PHPMailer function

$msg = "";

if(isset($_POST['send_otp'])){

    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone    = mysqli_real_escape_string($conn, $_POST['phone']);
    $address  = mysqli_real_escape_string($conn, $_POST['address']);

    // IMAGE UPLOAD (TEMP STORE)
    $image = "";
    if(!empty($_FILES['image']['name'])){
        $image = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$image);
    }

    // CHECK EMAIL
    $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($check) > 0){
        $msg = "Email already exists!";
    } else {

        // SAVE IN SESSION
        $_SESSION['reg_data'] = [
            'name'=>$name,
            'email'=>$email,
            'password'=>$password,
            'phone'=>$phone,
            'address'=>$address,
            'image'=>$image
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
<title>Register</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-orange-100 to-orange-200 min-h-screen flex items-center justify-center">

<div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-md">

<h2 class="text-3xl font-bold text-center text-orange-500 mb-6">Create Account</h2>

<?php if($msg){ ?>
<p class="text-center text-red-500 mb-3"><?php echo $msg; ?></p>
<?php } ?>

<form method="POST" enctype="multipart/form-data" class="space-y-3">

<input type="text" name="name" placeholder="Full Name"
class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-orange-400" required>

<input type="email" name="email" placeholder="Email Address"
class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-orange-400" required>

<input type="password" name="password" placeholder="Password"
class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-orange-400" required>

<input type="text" name="phone" placeholder="Phone Number"
class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-orange-400" required>

<textarea name="address" placeholder="Address"
class="w-full border p-3 rounded-lg focus:ring-2 focus:ring-orange-400"></textarea>

<label class="text-sm font-semibold text-gray-600">Profile Photo</label>
<input type="file" name="image"
class="w-full border p-2 rounded-lg">

<button name="send_otp"
class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-lg font-semibold transition">
Send OTP
</button>

</form>

<p class="text-center mt-4 text-sm">
Already have an account?
<a href="login.php" class="text-blue-500 font-semibold">Login</a>
</p>

</div>

</body>
</html>