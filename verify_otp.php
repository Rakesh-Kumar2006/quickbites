<?php
session_start();
include("db.php");

$msg = "";

if(isset($_POST['verify'])){

    if($_POST['otp'] == $_SESSION['otp']){

        $data = $_SESSION['reg_data'];

        mysqli_query($conn,"
        INSERT INTO users(name,email,password,phone,address,status)
        VALUES(
            '{$data['name']}',
            '{$data['email']}',
            '{$data['password']}',
            '{$data['phone']}',
            '{$data['address']}',
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
?>

<script src="https://cdn.tailwindcss.com"></script>

<div class="min-h-screen flex items-center justify-center bg-gray-100">

<form method="POST" class="bg-white p-6 rounded-xl shadow w-96">

<h2 class="text-xl font-bold mb-4 text-center">Verify OTP</h2>

<?php if($msg){ ?>
<p class="text-red-500 text-center"><?php echo $msg; ?></p>
<?php } ?>

<input type="text" name="otp" placeholder="Enter OTP"
class="w-full border p-2 mb-3 rounded" required>

<button name="verify"
class="w-full bg-green-500 text-white py-2 rounded">
Verify & Register
</button>

</form>
</div>