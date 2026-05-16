<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

// 🔥 FILTER + SEARCH
$filter = $_GET['filter'] ?? '';
$search = $_GET['search'] ?? '';

// 🔥 AJAX STATUS UPDATE
if(isset($_POST['ajax_status'])){
    $id = $_POST['delivery_id'];
    $status = $_POST['status'];

    mysqli_query($conn, "UPDATE admin_delivery SET status='$status' WHERE delivery_id='$id'");
    echo "success";
    exit();
}

// ADD / UPDATE DELIVERY
if(isset($_POST['save_delivery'])){
    $order_id  = $_POST['order_id'];
    $name      = $_POST['delivery_partner_name'];
    $phone     = $_POST['delivery_partner_phone'];
    $status    = $_POST['status'];

    $check = mysqli_query($conn, "SELECT * FROM admin_delivery WHERE order_id='$order_id'");

    if(mysqli_num_rows($check) > 0){
        mysqli_query($conn, "UPDATE admin_delivery SET
            delivery_partner_name='$name',
            delivery_partner_phone='$phone',
            status='$status'
            WHERE order_id='$order_id'
        ");
    } else {
        mysqli_query($conn, "INSERT INTO admin_delivery
        (order_id, admin_id, delivery_partner_name, delivery_partner_phone, status)
        VALUES
        ('$order_id','$admin_id','$name','$phone','$status')");
    }
}

// 🔥 FETCH ORDERS (LATEST STATUS)
$orders = mysqli_query($conn, "
SELECT 
o.order_id, 
o.total_amount, 
r.name AS restaurant_name,
(SELECT updated_status FROM admin_orders 
 WHERE order_id = o.order_id 
 ORDER BY admin_order_id DESC LIMIT 1) AS status
FROM orders o
LEFT JOIN admin_restaurants r ON o.hotel_id = r.hotel_id
ORDER BY o.order_id DESC
");

// 🔥 DELIVERY QUERY WITH FILTER + SEARCH
$where = "WHERE 1=1";

if($filter){
    $where .= " AND d.status='$filter'";
}

if($search){
    $where .= " AND d.order_id LIKE '%$search%'";
}

$deliveries = mysqli_query($conn, "
SELECT d.*, o.total_amount, u.name AS user_name, r.name AS restaurant_name
FROM admin_delivery d
LEFT JOIN orders o ON d.order_id = o.order_id
LEFT JOIN users u ON o.user_id = u.user_id
LEFT JOIN admin_restaurants r ON o.hotel_id = r.hotel_id
$where
ORDER BY d.delivery_id DESC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Delivery Management</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

<?php include("sidebar.php"); ?>

<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

<div id="mainContent" class="flex-1 flex flex-col md:ml-64">

<?php include("navbar.php"); ?>

<main class="p-6 overflow-y-auto">

<h2 class="text-2xl font-bold mb-4">🚚 Delivery Management</h2>

<!-- 🔥 FILTER + SEARCH -->
<div class="flex flex-wrap gap-3 mb-4">

<form method="GET" class="flex gap-2">

<select name="filter" class="border p-2 rounded">
<option value="">All</option>
<option value="pending" <?php if($filter=='pending') echo "selected"; ?>>Pending</option>
<option value="delivered" <?php if($filter=='delivered') echo "selected"; ?>>Delivered</option>
</select>

<input type="text" name="search" placeholder="Search Order ID"
value="<?php echo $search; ?>"
class="border p-2 rounded">

<button class="bg-blue-500 text-white px-4 rounded">Apply</button>

</form>


</div>

<!-- ADD DELIVERY -->
<div class="bg-white p-6 rounded-xl shadow mb-6 max-w-lg">

<form method="POST" class="space-y-3">

<select name="order_id" class="w-full border p-2 rounded" required>
<option value="">Select Order</option>

<?php while($o = mysqli_fetch_assoc($orders)){ 
if($o['status'] != 'delivered'){ ?>
<option value="<?php echo $o['order_id']; ?>">
#<?php echo $o['order_id']; ?> - ₹<?php echo $o['total_amount']; ?>
</option>
<?php } } ?>
</select>

<input type="text" name="delivery_partner_name" placeholder="Partner Name"
class="w-full border p-2 rounded" required>

<input type="text" name="delivery_partner_phone" placeholder="Phone"
class="w-full border p-2 rounded" required>

<select name="status" class="w-full border p-2 rounded">
<option value="pending">Pending</option>
<option value="picked">Picked</option>
<option value="on_the_way">On the Way</option>
<option value="delivered">Delivered</option>
</select>

<button name="save_delivery"
class="w-full bg-green-500 text-white py-2 rounded">
Save Delivery
</button>

</form>

</div>

<!-- LIST -->
<div class="bg-white rounded-xl shadow overflow-x-auto">

<table class="w-full text-sm">

<thead class="bg-gray-200">
<tr>
<th class="p-3">#ID</th>
<th>Order</th>
<th>User</th>
<th>Partner</th>
<th>Status</th>
</tr>
</thead>

<tbody id="deliveryTable">

<?php while($d = mysqli_fetch_assoc($deliveries)){ ?>

<tr class="border-b">

<td class="p-3">#<?php echo $d['delivery_id']; ?></td>

<td>#<?php echo $d['order_id']; ?> (₹<?php echo $d['total_amount']; ?>)</td>

<td><?php echo $d['user_name']; ?></td>

<td><?php echo $d['delivery_partner_name']; ?></td>

<td>
<select onchange="updateStatus(<?php echo $d['delivery_id']; ?>, this.value)"
class="border p-1 text-xs rounded">
<option <?php if($d['status']=='pending') echo "selected"; ?> value="pending">Pending</option>
<option <?php if($d['status']=='picked') echo "selected"; ?> value="picked">Picked</option>
<option <?php if($d['status']=='on_the_way') echo "selected"; ?> value="on_the_way">On Way</option>
<option <?php if($d['status']=='delivered') echo "selected"; ?> value="delivered">Delivered</option>
</select>
</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

</main>
</div>
</div>

<script>
// 🔥 LIVE STATUS UPDATE
function updateStatus(id, status){
    fetch("", {
        method: "POST",
        headers: {"Content-Type":"application/x-www-form-urlencoded"},
        body: "ajax_status=1&delivery_id="+id+"&status="+status
    });
}


</script>

<script src="assets/js/sidebar.js" defer></script>
<script src="assets/js/navbar.js" defer></script>

</body>
</html>