<?php
include("db.php");

if (isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // 🔐 secure
    $phone = $_POST['phone'];

    // Image Upload
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $folder = "uploads/" . $image;

    // Check email exists
    $check = "SELECT * FROM admin_users WHERE email='$email'";
    $result = mysqli_query($conn, $check);

    if (mysqli_num_rows($result) > 0) {
        $error = "Email already exists!";
    } else {

        move_uploaded_file($tmp_name, $folder);

        $query = "INSERT INTO admin_users (name, email, password, phone, profile_image)
                  VALUES ('$name', '$email', '$password', '$phone', '$image')";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Registration Successful'); window.location='login.php';</script>";
        } else {
            $error = "Something went wrong!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Register - Quick Bite</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-blue-100 to-indigo-200 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-3xl shadow-xl w-96">
    
    <h2 class="text-3xl font-bold text-center text-gray-800 mb-2">
        🍔 Quick Bite
    </h2>
    
    <h2 class="text-3xl font-bold text-center text-gray-700 mb-6">
        Admin Register
    </h2>

    <?php if(isset($error)) { ?>
        <p class="text-red-500 text-center mb-4"><?php echo $error; ?></p>
    <?php } ?>

    <form method="POST" enctype="multipart/form-data">

        <input type="text" name="name" placeholder="Full Name"
            class="w-full mb-3 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400" required>

        <input type="email" name="email" placeholder="Email"
            class="w-full mb-3 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400" required>

        <input type="password" name="password" placeholder="Password"
            class="w-full mb-3 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400" required>

        <input type="text" name="phone" placeholder="Phone"
            class="w-full mb-3 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400" required>

        <!-- Image Upload -->
        <input type="file" name="image"
            class="w-full mb-4 px-2 py-2 border rounded-lg bg-gray-50">

        <button type="submit" name="register"
            class="w-full bg-gradient-to-r from-blue-500 to-indigo-500 text-white py-2 rounded-lg hover:opacity-90 transition">
            Register
        </button>
    </form>

    <p class="text-center mt-4 text-gray-600">
        Already have an account?
        <a href="login.php" class="text-blue-600 font-semibold hover:underline">
            Login Here
        </a>
    </p>
</div>

</body>
</html>