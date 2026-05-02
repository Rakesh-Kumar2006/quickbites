<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

// FETCH ADMIN DATA
$admin = mysqli_fetch_assoc(mysqli_query($conn, "
SELECT * FROM admin_users WHERE admin_id='$admin_id'
"));

$success = "";

// 🔥 UPDATE PROFILE
if(isset($_POST['update_profile'])){

    $name  = $_POST['name'];
    $email = $_POST['email'];

    // IMAGE
    if(!empty($_FILES['image']['name'])){
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/".$image);

        mysqli_query($conn, "
        UPDATE admin_users SET name='$name', email='$email', image='$image'
        WHERE admin_id='$admin_id'
        ");

        $_SESSION['admin_image'] = $image;

    } else {
        mysqli_query($conn, "
        UPDATE admin_users SET name='$name', email='$email'
        WHERE admin_id='$admin_id'
        ");
    }

    $_SESSION['admin_name'] = $name;
    $success = "Profile Updated Successfully";
}

// 🔥 CHANGE PASSWORD
if(isset($_POST['change_password'])){

    $old = $_POST['old_password'];
    $new = $_POST['new_password'];

    if($old == $admin['password']){

        mysqli_query($conn, "
        UPDATE admin_users SET password='$new'
        WHERE admin_id='$admin_id'
        ");

        $success = "Password Changed Successfully";

    } else {
        $success = "Wrong Old Password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Profile</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

<?php include("sidebar.php"); ?>

<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

<div id="mainContent" class="flex-1 flex flex-col md:ml-64">

<?php include("navbar.php"); ?>

<main class="p-6 overflow-y-auto flex justify-center">

<div class="bg-white p-6 rounded-xl shadow w-full max-w-xl">

<h2 class="text-xl font-bold mb-4 text-center">👤 Profile</h2>

<?php if($success){ ?>
<div class="bg-green-100 text-green-700 p-2 rounded mb-3 text-center">
<?php echo $success; ?>
</div>
<?php } ?>

<!-- PROFILE IMAGE -->
<div class="flex justify-center mb-4">
<img src="uploads/<?php echo $admin['image'] ?? 'default.png'; ?>"
class="w-24 h-24 rounded-full object-cover border">
</div>

<!-- UPDATE PROFILE -->
<form method="POST" enctype="multipart/form-data" class="space-y-3">

<input type="text" name="name"
value="<?php echo $admin['name']; ?>"
class="w-full border p-2 rounded" required>

<input type="email" name="email"
value="<?php echo $admin['email']; ?>"
class="w-full border p-2 rounded" required>

<input type="file" name="image"
class="w-full border p-2 rounded">

<button name="update_profile"
class="w-full bg-blue-500 text-white py-2 rounded">
Update Profile
</button>

</form>

<hr class="my-5">

<!-- CHANGE PASSWORD -->
<form method="POST" class="space-y-3">

<input type="password" name="old_password"
placeholder="Old Password"
class="w-full border p-2 rounded" required>

<input type="password" name="new_password"
placeholder="New Password"
class="w-full border p-2 rounded" required>

<button name="change_password"
class="w-full bg-yellow-500 text-white py-2 rounded">
Change Password
</button>

</form>

<hr class="my-5">

<!-- 🔥 LOGOUT BUTTON -->
<a href="logout.php"
class="block text-center bg-red-500 text-white py-2 rounded hover:bg-red-600">
🚪 Logout
</a>

</div>

</main>
</div>
</div>

<script src="assets/js/sidebar.js" defer></script>
<script src="assets/js/navbar.js" defer></script>

</body>
</html>