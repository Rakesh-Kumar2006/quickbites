<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// 🔥 MARK ALL AS READ
if(isset($_GET['read'])){
    mysqli_query($conn, "
    UPDATE admin_notifications 
    SET status='read' 
    WHERE status='unread'
    ");
}

// 🔥 FETCH NOTIFICATIONS
$notifications = mysqli_query($conn, "
SELECT * FROM admin_notifications
ORDER BY notification_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Notifications</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

<?php include("sidebar.php"); ?>

<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

<div id="mainContent" class="flex-1 flex flex-col md:ml-64">

<?php include("navbar.php"); ?>

<main class="p-6 overflow-y-auto">

<h2 class="text-2xl font-bold mb-4">🔔 Notifications</h2>

<!-- MARK ALL -->
<a href="?read=1"
class="bg-blue-500 text-white px-4 py-2 rounded text-sm">
Mark all as read
</a>

<div class="mt-4 space-y-3">

<?php while($n = mysqli_fetch_assoc($notifications)){ ?>

<div class="p-4 rounded-xl shadow flex justify-between items-center
<?php echo $n['status']=='unread' ? 'bg-yellow-100' : 'bg-gray-100'; ?>">

<div>
<p class="font-medium"><?php echo $n['message']; ?></p>

<p class="text-xs text-gray-500">
Order #<?php echo $n['order_id']; ?> • <?php echo $n['created_at']; ?>
</p>
</div>

<!-- STATUS BADGE -->
<span class="px-2 py-1 text-xs rounded
<?php echo $n['status']=='unread' ? 'bg-red-500 text-white' : 'bg-green-500 text-white'; ?>">
<?php echo ucfirst($n['status']); ?>
</span>

</div>

<?php } ?>

</div>

</main>
</div>
</div>

<script src="assets/js/sidebar.js" defer></script>
<script src="assets/js/navbar.js" defer></script>

</body>
</html>