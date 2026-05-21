<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// ✅ UPDATE STATUS
if(isset($_POST['update_status'])){

    $order_id = $_POST['order_id'] ?? 0;
    $status   = $_POST['status'] ?? '';

    if($order_id && $status){

        mysqli_query($conn,"
        UPDATE orders
        SET order_status='$status'
        WHERE order_id='$order_id'
        ");
    }
}

// ✅ FETCH ORDERS FROM DATABASE
$orders = mysqli_query($conn, "
SELECT 
    o.*,
    u.name AS user_name,
    r.name AS restaurant_name
FROM orders o

LEFT JOIN users u
ON o.user_id = u.user_id

LEFT JOIN admin_restaurants r
ON o.hotel_id = r.hotel_id

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

<!-- TOP -->
<div class="flex justify-between items-center mb-6">

<h2 class="text-3xl font-bold">
📦 Orders
</h2>

<button onclick="location.reload()"
class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-xl text-sm shadow">

🔄 Refresh

</button>

</div>

<!-- TABLE -->
<div class="bg-white rounded-2xl shadow overflow-x-auto">

<table class="w-full text-sm">

<thead class="bg-gray-200 text-left">

<tr>

<th class="p-4">#ID</th>
<th>User</th>
<th>Restaurant</th>
<th>Total</th>
<th>Payment</th>
<th>Status</th>
<th>Created</th>
<th>Action</th>

</tr>

</thead>

<tbody>

<?php while($o = mysqli_fetch_assoc($orders)){

    $status = strtolower($o['order_status'] ?? 'pending');
?>

<tr class="border-b hover:bg-gray-50 transition">

<!-- ORDER ID -->
<td class="p-4 font-bold text-gray-700">

#<?php echo $o['order_id']; ?>

</td>

<!-- USER -->
<td>

<?php echo $o['user_name'] ?? 'Guest'; ?>

</td>

<!-- RESTAURANT -->
<td>

<?php echo $o['restaurant_name'] ?? '-'; ?>

</td>

<!-- TOTAL -->
<td class="font-semibold text-orange-500">

₹<?php echo $o['grand_total']; ?>

</td>

<!-- PAYMENT -->
<td>

<span class="px-3 py-1 rounded-full text-xs font-bold
<?php echo strtolower($o['payment_method']) == 'online'
? 'bg-green-100 text-green-600'
: 'bg-yellow-100 text-yellow-700'; ?>">

<?php echo strtoupper($o['payment_method']); ?>

</span>

</td>

<!-- STATUS -->
<td>

<span class="px-3 py-1 rounded-full text-xs font-bold

<?php
if($status=='pending'){

    echo 'bg-yellow-100 text-yellow-700';

}
elseif($status=='preparing'){

    echo 'bg-blue-100 text-blue-700';

}
elseif($status=='out_for_delivery'){

    echo 'bg-purple-100 text-purple-700';

}
elseif($status=='delivered'){

    echo 'bg-green-100 text-green-700';

}
elseif($status=='cancelled'){

    echo 'bg-red-100 text-red-700';

}
?>

">

<?php echo ucfirst(str_replace('_',' ',$status)); ?>

</span>

</td>

<!-- CREATED -->
<td class="text-gray-500 text-xs">

<?php echo date("d M Y h:i A", strtotime($o['created_at'])); ?>

</td>

<!-- ACTION -->
<td>

<div class="flex gap-2 items-center">

<!-- VIEW -->
<a href="order_details.php?id=<?php echo $o['order_id']; ?>"
class="bg-gray-200 hover:bg-gray-300 px-3 py-1 text-xs rounded-lg transition">

View

</a>

<!-- UPDATE -->
<form method="POST" class="flex gap-2">

<input type="hidden"
name="order_id"
value="<?php echo $o['order_id']; ?>">

<select name="status"
class="border border-gray-300 p-2 rounded-lg text-xs">

<option value="pending"
<?php if($status=='pending') echo 'selected'; ?>>

Pending

</option>

<option value="preparing"
<?php if($status=='preparing') echo 'selected'; ?>>

Preparing

</option>

<option value="out_for_delivery"
<?php if($status=='out_for_delivery') echo 'selected'; ?>>

Out For Delivery

</option>

<option value="delivered"
<?php if($status=='delivered') echo 'selected'; ?>>

Delivered

</option>

<option value="cancelled"
<?php if($status=='cancelled') echo 'selected'; ?>>

Cancelled

</option>

</select>

<button name="update_status"
class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 text-xs rounded-lg transition">

Update

</button>

</form>

</div>

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