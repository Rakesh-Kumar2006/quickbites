<?php 
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

// DATE FILTER
$from = $_GET['from'] ?? '';
$to   = $_GET['to'] ?? '';

$where = "";
if($from && $to){
    $where = "WHERE DATE(created_at) BETWEEN '$from' AND '$to'";
}

// TOTALS
$total_orders = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM orders"))['total'];
$total_users = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users"))['total'];
$total_restaurants = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM admin_restaurants"))['total'];
$total_revenue = mysqli_fetch_assoc(mysqli_query($conn, "SELECT SUM(total_amount) as total FROM orders $where"))['total'] ?? 0;

// DAILY DATA
$daily = mysqli_query($conn, "
SELECT DATE(created_at) as day, SUM(total_amount) as total
FROM orders
$where
GROUP BY day
ORDER BY day DESC
");

$dailyLabels = [];
$dailyData = [];
while($d = mysqli_fetch_assoc($daily)){
    $dailyLabels[] = $d['day'];
    $dailyData[] = $d['total'];
}

// ORDER STATUS
$status_report = mysqli_query($conn, "
SELECT updated_status, COUNT(*) as total
FROM admin_orders
GROUP BY updated_status
");

$statusLabels = [];
$statusData = [];
while($s = mysqli_fetch_assoc($status_report)){
    $statusLabels[] = $s['updated_status'];
    $statusData[] = $s['total'];
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Reports</title>
<script src="https://cdn.tailwindcss.com"></script>

<!-- CHART + PDF -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>

<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

<?php include("sidebar.php"); ?>

<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

<div id="mainContent" class="flex-1 flex flex-col md:ml-64">

<?php include("navbar.php"); ?>

<main class="p-6 overflow-y-auto">

<h2 class="text-2xl font-bold mb-4">📊 Reports Dashboard</h2>

<!-- 🔥 FILTER + PDF BUTTON -->
<div class="flex flex-wrap justify-between items-center mb-6 gap-3">

<form method="GET" class="flex gap-3 flex-wrap">
    <input type="date" name="from" value="<?php echo $from; ?>" class="border p-2 rounded">
    <input type="date" name="to" value="<?php echo $to; ?>" class="border p-2 rounded">
    <button class="bg-blue-500 text-white px-4 rounded">Filter</button>
</form>

<button onclick="downloadPDF()" 
class="flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded transition">
📄 Export PDF
</button>

</div>

<!-- STATS -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
<div class="bg-white p-4 rounded-xl shadow">
<h3>Total Orders</h3>
<p class="text-2xl font-bold"><?php echo $total_orders; ?></p>
</div>

<div class="bg-white p-4 rounded-xl shadow">
<h3>Total Revenue</h3>
<p class="text-2xl font-bold">₹<?php echo $total_revenue; ?></p>
</div>

<div class="bg-white p-4 rounded-xl shadow">
<h3>Total Users</h3>
<p class="text-2xl font-bold"><?php echo $total_users; ?></p>
</div>

<div class="bg-white p-4 rounded-xl shadow">
<h3>Total Restaurants</h3>
<p class="text-2xl font-bold"><?php echo $total_restaurants; ?></p>
</div>
</div>

<!-- CHARTS -->
<div class="grid md:grid-cols-2 gap-6 mb-6">

<div class="bg-white p-4 rounded-xl shadow">
<h3 class="font-bold mb-2">📊 Daily Revenue</h3>
<canvas id="barChart"></canvas>
</div>

<div class="bg-white p-4 rounded-xl shadow">
<h3 class="font-bold mb-2">🥧 Order Status</h3>
<canvas id="pieChart"></canvas>
</div>

</div>

</main>
</div>
</div>

<!-- CHART SCRIPT -->
<script>

// BAR CHART
new Chart(document.getElementById("barChart"), {
    type: "bar",
    data: {
        labels: <?php echo json_encode($dailyLabels); ?>,
        datasets: [{
            label: "Revenue",
            data: <?php echo json_encode($dailyData); ?>
        }]
    }
});

// PIE CHART
new Chart(document.getElementById("pieChart"), {
    type: "pie",
    data: {
        labels: <?php echo json_encode($statusLabels); ?>,
        datasets: [{
            data: <?php echo json_encode($statusData); ?>
        }]
    }
});

// PDF EXPORT
function downloadPDF(){
    const { jsPDF } = window.jspdf;
    let doc = new jsPDF();

    doc.text("Quick Bite Report", 20, 20);
    doc.text("Total Orders: <?php echo $total_orders; ?>", 20, 40);
    doc.text("Total Revenue: ₹<?php echo $total_revenue; ?>", 20, 50);
    doc.text("Total Users: <?php echo $total_users; ?>", 20, 60);
    doc.text("Total Restaurants: <?php echo $total_restaurants; ?>", 20, 70);

    doc.save("report.pdf");
}

</script>

<script src="assets/js/sidebar.js" defer></script>
<script src="assets/js/navbar.js" defer></script>

</body>
</html>