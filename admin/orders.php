<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// ✅ UPDATE STATUS (SAFE)
if(isset($_POST['update_status'])){
    $order_id = $_POST['order_id'] ?? 0;
    $status   = $_POST['status'] ?? '';

    if($order_id && $status){
        mysqli_query($conn, "UPDATE orders SET order_status='$status' WHERE order_id='$order_id'");
    }
}

// FETCH ORDERS
$orders = mysqli_query($conn, "
SELECT o.*, u.name AS user_name, r.name AS restaurant_name
FROM orders o
LEFT JOIN users u ON o.user_id = u.user_id
LEFT JOIN admin_restaurants r ON o.hotel_id = r.hotel_id
ORDER BY o.order_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Orders</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

<!-- SIDEBAR -->
<?php include("sidebar.php"); ?>

<!-- MAIN -->
<div id="mainContent" class="flex-1 flex flex-col md:ml-64">

<?php include("navbar.php"); ?>

<main class="p-6 overflow-y-auto">

<div class="flex justify-between items-center mb-4">
    <h2 class="text-2xl font-bold">📦 Orders</h2>

    <button onclick="location.reload()"
    class="bg-blue-500 text-white px-4 py-2 rounded-lg text-sm">
    🔄 Refresh
    </button>
</div>

<div class="bg-white rounded-xl shadow overflow-x-auto">

<table class="w-full text-sm">

<thead class="bg-gray-200 text-left">
<tr>
    <th class="p-3">#ID</th>
    <th>User</th>
    <th>Restaurant</th>
    <th>Total</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>

<tbody>

<?php while($o = mysqli_fetch_assoc($orders)){ 

    $status = strtolower($o['order_status'] ?? 'pending');
?>

<tr class="border-b hover:bg-gray-50">

<td class="p-3 font-semibold">#<?php echo $o['order_id']; ?></td>

<td><?php echo $o['user_name'] ?? 'Guest'; ?></td>

<td><?php echo $o['restaurant_name'] ?? '-'; ?></td>

<td>₹<?php echo $o['total_amount']; ?></td>

<td>
<span class="px-2 py-1 text-xs rounded-full
<?php
if($status=='pending') echo 'bg-yellow-100 text-yellow-600';
elseif($status=='confirmed') echo 'bg-blue-100 text-blue-600';
elseif($status=='delivered') echo 'bg-green-100 text-green-600';
else echo 'bg-gray-100';
?>">
<?php echo ucfirst($status); ?>
</span>
</td>

<td class="flex gap-2 items-center">

<!-- ✅ VIEW BUTTON (IMPORTANT FIX) -->
<a href="order_details.php?id=<?php echo $o['order_id']; ?>"
class="bg-gray-200 px-2 py-1 text-xs rounded hover:bg-gray-300">
View
</a>

<!-- UPDATE FORM -->
<form method="POST" class="flex gap-2">

<input type="hidden" name="order_id" value="<?php echo $o['order_id']; ?>">

<select name="status" class="border p-1 rounded text-xs">
<option value="pending" <?php if($status=='pending') echo 'selected'; ?>>Pending</option>
<option value="confirmed" <?php if($status=='confirmed') echo 'selected'; ?>>Confirmed</option>
<option value="delivered" <?php if($status=='delivered') echo 'selected'; ?>>Delivered</option>
</select>

<button name="update_status"
class="bg-green-500 text-white px-2 py-1 text-xs rounded">
Update
</button>

</form>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</main>

</div>
</div>

</body>
</html>