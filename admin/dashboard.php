<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

$admin = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM admin_users WHERE admin_id='$admin_id'"));

$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders"))['total'];
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users"))['total'];
$total_revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_amount) as total FROM orders"))['total'];

$total_revenue = $total_revenue ?? 0;

$page_title = "Dashboard";
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Quick Bite</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

    <!-- ✅ SIDEBAR INCLUDE -->
    <?php include("sidebar.php"); ?>

    <!-- Overlay -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

    <!-- Main -->
    <div id="mainContent" class="flex-1 flex flex-col transition-all duration-300 md:ml-64">

        <!-- ✅ NAVBAR INCLUDE -->
        <?php include("navbar.php"); ?>

        <!-- Content -->
        <main class="p-6 overflow-y-auto">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-xl shadow">
                    <h3>Total Orders</h3>
                    <p class="text-3xl font-bold"><?php echo $total_orders; ?></p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <h3>Total Users</h3>
                    <p class="text-3xl font-bold"><?php echo $total_users; ?></p>
                </div>

                <div class="bg-white p-6 rounded-xl shadow">
                    <h3>Revenue</h3>
                    <p class="text-3xl font-bold">₹<?php echo $total_revenue; ?></p>
                </div>
            </div>

            <div class="bg-white mt-8 p-6 rounded-xl shadow">
                <canvas id="myChart"></canvas>
            </div>

        </main>
    </div>
</div>

<!-- 🔧 COMMON SCRIPT -->


<!-- Chart -->
<script>
new Chart(document.getElementById('myChart'), {
    type: 'bar',
    data: {
        labels: ['Orders', 'Users'],
        datasets: [{
            label: 'System Data',
            data: [<?php echo $total_orders; ?>, <?php echo $total_users; ?>],
        }]
    }
});
</script>
 <script src="assets/js/sidebar.js" defer></script>
<script src="assets/js/navbar.js" defer></script>
</body>
</html>