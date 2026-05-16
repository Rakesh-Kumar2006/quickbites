<?php
session_start();
include("db.php");

$msg = "";

if(isset($_POST['login'])){

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $q = mysqli_query($conn,"
        SELECT * FROM users 
        WHERE email='$email' AND status='active'
    ");

    if(mysqli_num_rows($q) > 0){

        $user = mysqli_fetch_assoc($q);

        if(password_verify($password, $user['password'])){

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_image'] = $user['image'];

            header("Location: home.php");
            exit();

        } else {
            $msg = "Incorrect password!";
        }

    } else {
        $msg = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Login - QuickBites</title>
<script src="https://cdn.tailwindcss.com"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="min-h-screen bg-gradient-to-r from-orange-100 via-white to-orange-200 flex items-center justify-center px-4">

<div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden grid md:grid-cols-2">

    <!-- LEFT SIDE -->
    <div class="hidden md:flex flex-col justify-center bg-orange-500 text-white p-10 relative">

        <h1 class="text-5xl font-bold mb-6">
            QuickBites
        </h1>

        <p class="text-lg leading-8 mb-8">
            Order your favorite food online with fast delivery and secure payments.
            Enjoy delicious meals anytime, anywhere.
        </p>

        <img src="uploads/login-banner.jpg"
        class="rounded-2xl shadow-lg object-cover h-72"
        onerror="this.src='https://via.placeholder.com/500x300'">

        <div class="absolute top-5 left-5 bg-white/20 px-4 py-2 rounded-full text-sm backdrop-blur">
            🍔 Fast Delivery
        </div>

    </div>

    <!-- RIGHT SIDE -->
    <div class="p-8 md:p-12 flex flex-col justify-center">

        <div class="text-center mb-8">

            <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-4xl">🍕</span>
            </div>

            <h2 class="text-4xl font-bold text-gray-800">
                Welcome Back
            </h2>

            <p class="text-gray-500 mt-2">
                Login to continue ordering delicious food
            </p>

        </div>

        <?php if($msg){ ?>
        <div class="bg-red-100 border border-red-300 text-red-600 p-3 rounded-lg mb-5 text-center">
            <?php echo $msg; ?>
        </div>
        <?php } ?>

        <form method="POST" class="space-y-5">

            <!-- EMAIL -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    Email Address
                </label>

                <input type="email" 
                name="email" 
                placeholder="Enter your email"
                class="w-full border border-gray-300 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-400 transition"
                required>
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">
                    Password
                </label>

                <input type="password" 
                name="password" 
                placeholder="Enter your password"
                class="w-full border border-gray-300 p-3 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-400 transition"
                required>
            </div>

            <!-- REMEMBER -->
            <div class="flex items-center justify-between text-sm">

                <label class="flex items-center gap-2 text-gray-600">
                    <input type="checkbox">
                    Remember me
                </label>

                <a href="forgot_password.php" class="text-orange-500 hover:underline">
                    Forgot Password?
                </a>

            </div>

            <!-- BUTTON -->
            <button name="login"
            class="w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-xl font-bold text-lg shadow-lg transition duration-300">
                Login
            </button>

        </form>

        <!-- REGISTER -->
        <p class="text-center text-gray-600 mt-6">
            Don’t have an account?
            <a href="register.php" class="text-orange-500 font-semibold hover:underline">
                Register Now
            </a>
        </p>

        <!-- BACK BUTTON -->
        <button onclick="history.back()"
        class="mt-6 w-full border border-gray-300 py-3 rounded-xl hover:bg-gray-100 transition">
            ← Back
        </button>

    </div>

</div>

</body>
</html>