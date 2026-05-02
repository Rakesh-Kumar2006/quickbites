<?php
session_start();
include("db.php");

$msg = "";

if(isset($_POST['login'])){

    $email = $_POST['email'];
    $password = $_POST['password'];

    $q = mysqli_query($conn,"SELECT * FROM users WHERE email='$email' AND status='active'");

    if(mysqli_num_rows($q) > 0){

        $user = mysqli_fetch_assoc($q);

        if(password_verify($password, $user['password'])){

            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['name'];

            header("Location: home.php");
            exit();

        } else {
            $msg = "Wrong password!";
        }

    } else {
        $msg = "User not found!";
    }
}
?>

<script src="https://cdn.tailwindcss.com"></script>

<div class="min-h-screen flex items-center justify-center bg-gray-100">

<form method="POST" class="bg-white p-6 rounded-xl shadow w-96">

<h2 class="text-2xl font-bold mb-4 text-center">Login</h2>

<?php if($msg){ ?>
<p class="text-center text-red-500 mb-2"><?php echo $msg; ?></p>
<?php } ?>

<input type="email" name="email" placeholder="Email"
class="w-full border p-2 mb-3 rounded" required>

<input type="password" name="password" placeholder="Password"
class="w-full border p-2 mb-3 rounded" required>

<button name="login"
class="w-full bg-orange-500 text-white py-2 rounded hover:bg-orange-600">
Login
</button>

<p class="text-center mt-3">
New user?
<a href="register.php" class="text-blue-500">Register</a>
</p>

</form>
</div>