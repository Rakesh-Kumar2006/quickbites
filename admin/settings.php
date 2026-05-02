<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM settings WHERE id=1"));

if(isset($_POST['save'])){

    $name  = $_POST['site_name'];
    $email = $_POST['contact_email'];
    $phone = $_POST['contact_phone'];

    if(!empty($_FILES['logo']['name'])){
        $logo = $_FILES['logo']['name'];
        move_uploaded_file($_FILES['logo']['tmp_name'], "uploads/".$logo);

        mysqli_query($conn, "
        UPDATE settings SET site_name='$name', contact_email='$email',
        contact_phone='$phone', logo='$logo' WHERE id=1
        ");
    } else {
        mysqli_query($conn, "
        UPDATE settings SET site_name='$name', contact_email='$email',
        contact_phone='$phone' WHERE id=1
        ");
    }

    header("Location: settings.php");
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Settings</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex">
<?php include("sidebar.php"); ?>

<div id="mainContent" class="flex-1 md:ml-64">
<?php include("navbar.php"); ?>

<main class="p-6 max-w-lg">

<h2 class="text-xl font-bold mb-4">⚙️ Settings</h2>

<form method="POST" enctype="multipart/form-data" class="space-y-3">

<input type="text" name="site_name" value="<?php echo $data['site_name']; ?>" class="w-full border p-2 rounded">

<input type="email" name="contact_email" value="<?php echo $data['contact_email']; ?>" class="w-full border p-2 rounded">

<input type="text" name="contact_phone" value="<?php echo $data['contact_phone']; ?>" class="w-full border p-2 rounded">

<img src="uploads/<?php echo $data['logo']; ?>" class="w-20">

<input type="file" name="logo" class="w-full border p-2 rounded">

<button name="save" class="bg-blue-500 text-white px-4 py-2 rounded w-full">
Save Settings
</button>

</form>

</main>
</div>
</div>
</body>
</html>