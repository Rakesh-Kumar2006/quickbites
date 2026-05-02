<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// FETCH DATA
$data = mysqli_query($conn, "
SELECT * FROM contact_messages 
ORDER BY message_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Contact Messages</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

<?php include("sidebar.php"); ?>

<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

<div id="mainContent" class="flex-1 flex flex-col md:ml-64">

<?php include("navbar.php"); ?>

<main class="p-6 overflow-y-auto">

<h2 class="text-2xl font-bold mb-4">📩 Contact Messages</h2>

<div class="bg-white rounded-xl shadow overflow-x-auto">

<table class="w-full text-sm">

<thead class="bg-gray-200">
<tr>
<th class="p-3">#</th>
<th>Name</th>
<th>Email</th>
<th>Message</th>
<th>Date</th>
</tr>
</thead>

<tbody>

<?php while($row = mysqli_fetch_assoc($data)){ ?>

<tr class="border-b hover:bg-gray-50">

<td class="p-3"><?php echo $row['message_id']; ?></td>

<td class="font-semibold"><?php echo $row['name']; ?></td>

<td><?php echo $row['email']; ?></td>

<td class="max-w-xs truncate"><?php echo $row['message']; ?></td>

<td><?php echo date("d M Y", strtotime($row['created_at'])); ?></td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</main>
</div>
</div>

<script src="assets/js/sidebar.js" defer></script>
<script src="assets/js/navbar.js" defer></script>

</body>
</html>