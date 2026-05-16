<?php
session_start();
include("db.php");
include("send_otp.php");

$msg = "";

// VERIFY OTP
if(isset($_POST['verify'])){

    if($_POST['otp'] == $_SESSION['otp']){

        $data = $_SESSION['reg_data'];

        mysqli_query($conn,"
        INSERT INTO users(name,email,password,phone,address,image,status)
        VALUES(
            '{$data['name']}',
            '{$data['email']}',
            '{$data['password']}',
            '{$data['phone']}',
            '{$data['address']}',
            '{$data['image']}',
            'active'
        )
        ");

        unset($_SESSION['otp']);
        unset($_SESSION['reg_data']);

        header("Location: login.php?msg=registered");
        exit();

    } else {
        $msg = "Invalid OTP!";
    }
}

// RESEND OTP
if(isset($_POST['resend'])){

    $otp = rand(100000,999999);

    $_SESSION['otp'] = $otp;

    if(sendOTP($_SESSION['reg_data']['email'], $otp)){
        $msg = "New OTP sent successfully!";
    } else {
        $msg = "Failed to resend OTP!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Verify OTP - QuickBites</title>

<script src="https://cdn.tailwindcss.com"></script>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body class="min-h-screen bg-gradient-to-r from-green-100 via-white to-green-200 flex items-center justify-center px-4">

<div class="w-full max-w-5xl bg-white rounded-3xl shadow-2xl overflow-hidden grid md:grid-cols-2">

    <!-- LEFT SIDE -->
    <div class="hidden md:flex flex-col justify-center bg-green-500 text-white p-10 relative">

        <h1 class="text-5xl font-bold mb-6">
            OTP Verification
        </h1>

        <p class="text-lg leading-8 mb-8">
            Please verify your email address by entering the OTP sent to your email.
            This helps keep your account secure.
        </p>

        <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?q=80&w=1200&auto=format&fit=crop"
        class="rounded-2xl shadow-lg object-cover h-72 w-full">

        <div class="absolute top-5 left-5 bg-white/20 px-4 py-2 rounded-full text-sm backdrop-blur">
            🔐 Secure Verification
        </div>

    </div>

    <!-- RIGHT SIDE -->
    <div class="p-8 md:p-12 flex flex-col justify-center">

        <div class="text-center mb-8">

            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="text-4xl">📩</span>
            </div>

            <h2 class="text-4xl font-bold text-gray-800">
                Verify OTP
            </h2>

            <p class="text-gray-500 mt-2">
                Enter the 6-digit code sent to your email
            </p>

        </div>

        <?php if($msg){ ?>

        <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded-xl mb-5 text-center">
            <?php echo $msg; ?>
        </div>

        <?php } ?>

        <!-- OTP FORM -->
        <form method="POST" class="space-y-5">

            <div>

                <label class="block text-gray-700 font-semibold mb-2">
                    OTP Code
                </label>

                <input type="text"
                name="otp"
                maxlength="6"
                placeholder="Enter 6-digit OTP"
                class="w-full border border-gray-300 p-4 rounded-xl text-center text-2xl tracking-[10px] focus:outline-none focus:ring-2 focus:ring-green-400"
                required>

            </div>

            <!-- VERIFY BUTTON -->
            <button name="verify"
            class="w-full bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl font-bold text-lg shadow-lg transition duration-300">

                Verify & Register

            </button>

        </form>

        <!-- RESEND OTP -->
        <form method="POST" class="mt-4">

            <button name="resend"
            class="w-full border border-green-500 text-green-600 py-3 rounded-xl font-semibold hover:bg-green-50 transition">

                🔄 Resend OTP

            </button>

        </form>

        <!-- TIMER -->
        <div class="text-center mt-5 text-gray-500">

            OTP expires in:
            <span id="timer" class="font-bold text-green-600">
                60
            </span>
            seconds

        </div>

        <!-- BACK BUTTON -->
        <button onclick="history.back()"
        class="mt-6 w-full border border-gray-300 py-3 rounded-xl hover:bg-gray-100 transition">

            ← Back

        </button>

    </div>

</div>

<!-- TIMER SCRIPT -->
<script>

let timeLeft = 60;

const timer = document.getElementById("timer");

const countdown = setInterval(() => {

    timeLeft--;

    timer.innerText = timeLeft;

    if(timeLeft <= 0){
        clearInterval(countdown);
        timer.innerText = "Expired";
    }

}, 1000);

</script>

</body>
</html>