<?php
session_start();
include("db.php");

if (isset($_POST['login'])) {

    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    // Query
    $query = "SELECT * FROM admin_users WHERE email='$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {

        $row = mysqli_fetch_assoc($result);

        // Verify password
        if (password_verify($password, $row['password'])) {

            // 🔐 Secure session
            session_regenerate_id(true);

            // ✅ Store session data
            $_SESSION['admin_id']    = $row['admin_id'];
            $_SESSION['admin_name']  = $row['name'];
            $_SESSION['admin_image'] = $row['profile_image'] ?? 'default.png';

            header("Location: dashboard.php");
            exit();

        } else {
            $error = "Incorrect Password!";
        }

    } else {
        $error = "Email not found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - Quick Bite</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-indigo-200 via-blue-100 to-purple-200 flex items-center justify-center min-h-screen">

<div class="bg-white p-10 rounded-3xl shadow-2xl w-96">

    <!-- Logo -->
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-2">
        🍔 Quick Bite
    </h2>

    <p class="text-center text-gray-500 mb-6">Admin Login Panel</p>

    <!-- Error -->
    <?php if(isset($error)) { ?>
        <div class="bg-red-100 text-red-600 text-center py-2 mb-4 rounded-lg">
            <?php echo $error; ?>
        </div>
    <?php } ?>

    <!-- Form -->
    <form method="POST">

        <!-- Email -->
        <input type="email" name="email" placeholder="Enter Email"
            class="w-full mb-4 px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400"
            required>

        <!-- Password -->
        <input type="password" name="password" placeholder="Enter Password"
            class="w-full mb-4 px-4 py-3 border rounded-xl focus:outline-none focus:ring-2 focus:ring-blue-400"
            required>

        <!-- Button -->
        <button type="submit" name="login"
            class="w-full bg-gradient-to-r from-blue-500 to-indigo-500 text-white py-3 rounded-xl font-semibold hover:opacity-90 transition">
            Login
        </button>

    </form>

    <!-- Register -->
    <p class="text-center mt-6 text-gray-600">
        Don’t have an account?
        <a href="register.php" class="text-blue-600 font-semibold hover:underline">
            Register Here
        </a>
    </p>

</div>

</body>
</html>