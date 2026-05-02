<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$type = $_GET['type'] ?? 'reviews';

// 🔥 FETCH REVIEWS
$reviews = mysqli_query($conn, "
SELECT r.*, u.name AS user_name, f.name AS food_name
FROM food_reviews r
LEFT JOIN users u ON r.user_id = u.user_id
LEFT JOIN admin_food_items f ON r.food_id = f.food_id
ORDER BY r.review_id DESC
");

// 🔥 FETCH COMPLAINTS
$complaints = mysqli_query($conn, "
SELECT c.*, u.name AS user_name
FROM delivery_complaints c
LEFT JOIN users u ON c.user_id = u.user_id
ORDER BY c.complaint_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Reviews & Complaints</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

<?php include("sidebar.php"); ?>

<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

<div id="mainContent" class="flex-1 flex flex-col md:ml-64">

<?php include("navbar.php"); ?>

<main class="p-6 overflow-y-auto">

<h2 class="text-2xl font-bold mb-4">⭐ Reviews & Complaints</h2>

<!-- 🔥 SWITCH -->
<div class="flex gap-3 mb-6">
<a href="?type=reviews"
class="px-4 py-2 rounded <?php echo $type=='reviews'?'bg-blue-500 text-white':'bg-gray-200'; ?>">
Food Reviews
</a>

<a href="?type=complaints"
class="px-4 py-2 rounded <?php echo $type=='complaints'?'bg-red-500 text-white':'bg-gray-200'; ?>">
Delivery Complaints
</a>
</div>

<!-- ================= REVIEWS ================= -->
<?php if($type=='reviews'){ ?>

<div class="grid md:grid-cols-2 gap-4">

<?php while($r = mysqli_fetch_assoc($reviews)){ ?>

<div class="bg-white p-4 rounded-xl shadow">

<div class="flex justify-between items-center mb-2">
<h3 class="font-bold"><?php echo $r['food_name']; ?></h3>

<span class="text-yellow-500 font-bold">
⭐ <?php echo $r['rating']; ?>/5
</span>
</div>

<p class="text-gray-700 mb-2"><?php echo $r['comment']; ?></p>

<div class="text-sm text-gray-500">
👤 <?php echo $r['user_name']; ?> • <?php echo $r['created_at']; ?>
</div>

</div>

<?php } ?>

</div>

<?php } ?>

<!-- ================= COMPLAINTS ================= -->
<?php if($type=='complaints'){ ?>

<div class="space-y-4">

<?php while($c = mysqli_fetch_assoc($complaints)){ ?>

<div class="bg-white p-4 rounded-xl shadow">

<div class="flex justify-between mb-2">
<h3 class="font-semibold">Order #<?php echo $c['order_id']; ?></h3>

<span class="px-2 py-1 text-xs rounded
<?php
if($c['issue_type']=='late') echo 'bg-yellow-100 text-yellow-600';
elseif($c['issue_type']=='rude') echo 'bg-red-100 text-red-600';
elseif($c['issue_type']=='wrong_order') echo 'bg-purple-100 text-purple-600';
else echo 'bg-gray-100';
?>">
<?php echo ucfirst(str_replace('_',' ',$c['issue_type'])); ?>
</span>
</div>

<p class="text-gray-700 mb-2"><?php echo $c['message']; ?></p>

<div class="text-sm text-gray-500">
👤 <?php echo $c['user_name']; ?> • <?php echo $c['created_at']; ?>
</div>

</div>

<?php } ?>

</div>

<?php } ?>

</main>
</div>
</div>

<script src="assets/js/sidebar.js" defer></script>
<script src="assets/js/navbar.js" defer></script>

</body>
</html>