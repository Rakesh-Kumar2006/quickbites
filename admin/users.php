<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// 🔍 SEARCH
$search = $_GET['search'] ?? '';
$page = $_GET['page'] ?? 1;
$limit = 5;
$offset = ($page - 1) * $limit;

$where = "WHERE 1=1";

if($search){
    $where .= " AND (name LIKE '%$search%' 
              OR email LIKE '%$search%' 
              OR phone LIKE '%$search%')";
}

// 🔥 BLOCK / UNBLOCK
if(isset($_GET['toggle'])){
    $id = intval($_GET['toggle']);

    mysqli_query($conn, "
    UPDATE users 
    SET status = IF(status='active','blocked','active') 
    WHERE user_id=$id
    ");

    header("Location: users.php");
    exit();
}

// 🔥 DELETE
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM users WHERE user_id=$id");
    header("Location: users.php");
    exit();
}

// 🔥 TOTAL COUNT (FOR PAGINATION)
$totalQuery = mysqli_query($conn, "SELECT COUNT(*) as total FROM users $where");
$totalData = mysqli_fetch_assoc($totalQuery);
$totalUsers = $totalData['total'];
$totalPages = ceil($totalUsers / $limit);

// 🔥 FETCH USERS
$users = mysqli_query($conn, "
SELECT * FROM users
$where
ORDER BY user_id DESC
LIMIT $limit OFFSET $offset
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Users</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

<?php include("sidebar.php"); ?>

<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

<div id="mainContent" class="flex-1 flex flex-col md:ml-64">

<?php include("navbar.php"); ?>

<main class="p-6 overflow-y-auto">

<h2 class="text-2xl font-bold mb-4">👥 Users</h2>

<!-- 🔍 SEARCH -->
<form method="GET" class="flex gap-2 mb-4 max-w-md">
<input type="text" name="search" placeholder="Search users..."
value="<?php echo $search; ?>"
class="border p-2 rounded w-full">

<button class="bg-blue-500 text-white px-4 rounded">
Search
</button>
</form>

<!-- 📋 TABLE -->
<div class="bg-white rounded-xl shadow overflow-x-auto">

<table class="w-full text-sm">

<thead class="bg-gray-200">
<tr>
<th class="p-3">#ID</th>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Status</th>
<th>Joined</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php while($u = mysqli_fetch_assoc($users)){ ?>

<tr class="border-b hover:bg-gray-50">

<td class="p-3">#<?php echo $u['user_id']; ?></td>

<td class="font-semibold"><?php echo $u['name']; ?></td>

<td><?php echo $u['email']; ?></td>

<td><?php echo $u['phone']; ?></td>

<td>
<span class="px-2 py-1 text-xs rounded
<?php echo $u['status']=='active' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'; ?>">
<?php echo ucfirst($u['status']); ?>
</span>
</td>

<td><?php echo date("d M Y", strtotime($u['created_at'])); ?></td>

<td class="flex gap-2">

<!-- 🔥 BLOCK BUTTON -->
<a href="?toggle=<?php echo $u['user_id']; ?>"
class="px-2 py-1 text-xs rounded
<?php echo $u['status']=='active' ? 'bg-yellow-500' : 'bg-green-500'; ?> text-white">
<?php echo $u['status']=='active' ? 'Block' : 'Unblock'; ?>
</a>

<!-- DELETE -->
<a href="?delete=<?php echo $u['user_id']; ?>"
onclick="return confirm('Delete this user?')"
class="bg-red-500 text-white px-2 py-1 text-xs rounded">
Delete
</a>

</td>

</tr>

<?php } ?>

</tbody>

</table>

</div>

<!-- 🔥 PAGINATION -->
<div class="flex justify-center mt-4 gap-2">

<?php for($i=1; $i<=$totalPages; $i++){ ?>
<a href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"
class="px-3 py-1 rounded
<?php echo $i==$page ? 'bg-blue-500 text-white' : 'bg-gray-200'; ?>">
<?php echo $i; ?>
</a>
<?php } ?>

</div>

</main>
</div>
</div>

<script src="assets/js/sidebar.js" defer></script>
<script src="assets/js/navbar.js" defer></script>

</body>
</html>