<?php
session_start();
include("db.php");

error_reporting(E_ALL);
ini_set('display_errors', 1);

$user_id = $_SESSION['user_id'] ?? 0;

if(!$user_id){
    header("Location: login.php");
    exit();
}

// FETCH USER
$result = mysqli_query($conn, "SELECT * FROM users WHERE user_id='$user_id'");
$user = mysqli_fetch_assoc($result);

if(!$user){
    die("User not found");
}

$msg = "";

// UPDATE PROFILE
if(isset($_POST['update_profile'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    mysqli_query($conn,"
        UPDATE users 
        SET name='$name', email='$email', phone='$phone', address='$address'
        WHERE user_id='$user_id'
    ");

    $msg = "Profile updated successfully!";
}

// UPLOAD PHOTO
if(isset($_POST['upload_photo'])){
    if(!empty($_FILES['photo']['name'])){
        $file = $_FILES['photo'];
        $filename = time() . "_" . basename($file['name']);
        $target = "uploads/" . $filename;

        if(move_uploaded_file($file['tmp_name'], $target)){
            mysqli_query($conn,"
                UPDATE users 
                SET image='$filename' 
                WHERE user_id='$user_id'
            ");
            $msg = "Profile photo updated!";
        } else {
            $msg = "Upload failed!";
        }
    }
}

// CHANGE PASSWORD
if(isset($_POST['change_password'])){
    $old = $_POST['old_password'];
    $new = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    if(password_verify($old, $user['password'])){
        mysqli_query($conn,"
            UPDATE users 
            SET password='$new' 
            WHERE user_id='$user_id'
        ");
        $msg = "Password changed successfully!";
    } else {
        $msg = "Old password incorrect!";
    }
}

// IMAGE
$photo = !empty($user['image']) 
    ? "uploads/" . $user['image'] 
    : "https://via.placeholder.com/150";
?>
<!DOCTYPE html>
<html>
<head>
<title>Profile</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<!-- ✅ NAVBAR -->
<?php include("assets/navbar.php"); ?>

<div class="p-6">

<!-- 🔙 BACK BUTTON -->
<button onclick="history.back()"
class="mb-4 bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800">
← Back
</button>

<div class="max-w-5xl mx-auto grid md:grid-cols-3 gap-6">

<!-- LEFT PROFILE -->
<div class="bg-white p-6 rounded-xl shadow text-center">

<img src="<?php echo $photo; ?>"
class="w-32 h-32 rounded-full mx-auto border object-cover mb-4">

<h2 class="text-xl font-bold">
<?php echo htmlspecialchars($user['name']); ?>
</h2>

<p class="text-gray-500">
<?php echo htmlspecialchars($user['email']); ?>
</p>

<form method="POST" enctype="multipart/form-data" class="mt-4">
<input type="file" name="photo" class="text-sm mb-2">
<button name="upload_photo"
class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
Upload Photo
</button>
</form>

</div>

<!-- RIGHT -->
<div class="md:col-span-2 space-y-6">

<?php if($msg){ ?>
<p class="bg-green-100 text-green-700 p-3 rounded">
<?php echo $msg; ?>
</p>
<?php } ?>

<!-- UPDATE INFO -->
<div class="bg-white p-6 rounded-xl shadow">

<h3 class="font-bold mb-4">Edit Profile</h3>

<form method="POST">

<input type="text" name="name"
value="<?php echo htmlspecialchars($user['name']); ?>"
class="w-full border p-2 mb-3 rounded" placeholder="Name">

<input type="email" name="email"
value="<?php echo htmlspecialchars($user['email']); ?>"
class="w-full border p-2 mb-3 rounded" placeholder="Email">

<input type="text" name="phone"
value="<?php echo htmlspecialchars($user['phone']); ?>"
class="w-full border p-2 mb-3 rounded" placeholder="Phone">

<textarea name="address"
class="w-full border p-2 mb-3 rounded"><?php echo htmlspecialchars($user['address']); ?></textarea>

<button name="update_profile"
class="bg-green-500 text-white px-4 py-2 rounded">
Update Profile
</button>

</form>

</div>

<!-- CHANGE PASSWORD -->
<div class="bg-white p-6 rounded-xl shadow">

<h3 class="font-bold mb-4">Change Password</h3>

<form method="POST">

<input type="password" name="old_password"
class="w-full border p-2 mb-3 rounded"
placeholder="Old Password" required>

<input type="password" name="new_password"
class="w-full border p-2 mb-3 rounded"
placeholder="New Password" required>

<button name="change_password"
class="bg-red-500 text-white px-4 py-2 rounded">
Change Password
</button>

</form>

</div>

</div>

</div>

</div>

<!-- ✅ FOOTER -->
<?php include("assets/footer.php"); ?>

</body>
</html>