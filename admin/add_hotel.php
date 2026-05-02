<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];

// ENUM FETCH
function getEnumValues($conn, $table, $column) {
    $query = "SHOW COLUMNS FROM $table LIKE '$column'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    preg_match("/^enum\((.*)\)$/", $row['Type'], $matches);
    $values = explode(",", $matches[1]);

    return array_map(function($value) {
        return trim($value, "'");
    }, $values);
}

$open_times  = getEnumValues($conn, "admin_restaurants", "open_time");
$close_times = getEnumValues($conn, "admin_restaurants", "close_time");

// SUCCESS FLAG
$success = false;

if (isset($_POST['add_hotel'])) {

    $name        = $_POST['name'];
    $description = $_POST['description'];
    $category    = $_POST['category'];
    $open_time   = $_POST['open_time'];
    $close_time  = $_POST['close_time'];
    $address     = $_POST['address'];
    $phone       = $_POST['phone'];

    $image = $_FILES['image']['name'];
    $tmp   = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp, "uploads/".$image);

    if(mysqli_query($conn, "INSERT INTO admin_restaurants 
    (admin_id, name, description, category, open_time, close_time, address, phone, image)
    VALUES 
    ('$admin_id','$name','$description','$category','$open_time','$close_time','$address','$phone','$image')")){
        $success = true;
    }
}

// FETCH DATA
date_default_timezone_set('Asia/Kolkata');
$current = strtotime(date("h:i A"));
$data = mysqli_query($conn, "SELECT * FROM admin_restaurants ORDER BY hotel_id DESC");
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Restaurant</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

    <!-- SIDEBAR -->
    <?php include("sidebar.php"); ?>

    <!-- OVERLAY -->
    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

    <!-- MAIN -->
    <div id="mainContent" class="flex-1 flex flex-col transition-all duration-300 md:ml-64">

        <!-- NAVBAR -->
        <?php include("navbar.php"); ?>

        <!-- CONTENT -->
        <main class="p-6 overflow-y-auto">

            <!-- ADD FORM -->
            <div class="bg-white p-6 rounded-xl shadow mb-10 max-w-lg mx-auto">

                <h2 class="text-xl font-bold mb-4 text-center">➕ Add Restaurant</h2>

                <form id="hotelForm" method="POST" enctype="multipart/form-data" class="space-y-3">

                    <input type="text" name="name" placeholder="Name" class="w-full border p-2 rounded" required>

                    <textarea name="description" placeholder="Description" class="w-full border p-2 rounded"></textarea>

                    <select name="category" class="w-full border p-2 rounded" required>
                        <option value="">Category</option>
                        <option value="veg">Veg</option>
                        <option value="nonveg">Non-Veg</option>
                        <option value="both">Both</option>
                    </select>

                    <select name="open_time" id="open_time" class="w-full border p-2 rounded" required>
                        <option value="">Opening Time</option>
                        <?php foreach($open_times as $t){ echo "<option>$t</option>"; } ?>
                    </select>

                    <select name="close_time" id="close_time" class="w-full border p-2 rounded" required>
                        <option value="">Closing Time</option>
                        <?php foreach($close_times as $t){ echo "<option>$t</option>"; } ?>
                    </select>

                    <p id="statusPreview" class="font-bold text-blue-600">Status Preview</p>

                    <textarea name="address" placeholder="Address" class="w-full border p-2 rounded"></textarea>

                    <input type="text" name="phone" placeholder="Phone" class="w-full border p-2 rounded">

                    <input type="file" name="image" class="w-full border p-2 rounded">

                    <button name="add_hotel" class="bg-green-500 text-white w-full py-2 rounded hover:bg-green-600">
                        Add Restaurant
                    </button>

                </form>
            </div>

            <!-- MANAGE -->
            <h2 class="text-2xl font-bold mb-4">📊 Manage Restaurants</h2>

            <div class="grid md:grid-cols-3 gap-5">

                <?php while($row = mysqli_fetch_assoc($data)) {

                $open  = strtotime($row['open_time']);
                $close = strtotime($row['close_time']);
                $isOpen = ($current >= $open && $current <= $close);
                ?>

                <div class="bg-white p-4 rounded-xl shadow">

                    <img src="uploads/<?php echo $row['image']; ?>"
                         onerror="this.src='https://via.placeholder.com/150'"
                         class="h-32 w-full rounded object-cover">

                    <h3 class="font-bold mt-2"><?php echo $row['name']; ?></h3>

                    <p class="text-sm text-gray-500"><?php echo $row['category']; ?></p>

                    <p class="text-sm">🕒 <?php echo $row['open_time']." - ".$row['close_time']; ?></p>

                    <?php if($isOpen){ ?>
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-sm">Open</span>
                    <?php } else { ?>
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-sm">Closed</span>
                    <?php } ?>

                    <div class="flex gap-2 mt-3">
                        <a href="edit_restaurant.php?id=<?php echo $row['hotel_id']; ?>"
                        class="px-3 py-1 text-xs bg-blue-500 text-white rounded">✏️ Edit</a>

                        <a href="delete_restaurant.php?id=<?php echo $row['hotel_id']; ?>"
                        onclick="return confirm('Delete this restaurant?')"
                        class="px-3 py-1 text-xs bg-red-500 text-white rounded">🗑 Delete</a>
                    </div>

                </div>

                <?php } ?>

            </div>

        </main>

    </div>
</div>

<!-- TOAST -->
<div id="toast"
class="fixed top-5 right-5 bg-green-500 text-white px-5 py-3 rounded shadow hidden">
Restaurant Added Successfully ✅
</div>

<!-- STATUS SCRIPT -->
<script>
function checkStatus() {
    const open = document.getElementById("open_time").value;
    const close = document.getElementById("close_time").value;

    if (!open || !close) return;

    const now = new Date();
    const current = now.toLocaleTimeString([], {hour:'2-digit', minute:'2-digit'});

    const openTime = new Date("01/01/2020 " + open);
    const closeTime = new Date("01/01/2020 " + close);
    const currentTime = new Date("01/01/2020 " + current);

    let status = document.getElementById("statusPreview");

    if (currentTime >= openTime && currentTime <= closeTime) {
        status.innerText = "🟢 Open Now";
        status.className = "text-green-600 font-bold";
    } else {
        status.innerText = "🔴 Closed Now";
        status.className = "text-red-600 font-bold";
    }
}

document.getElementById("open_time").addEventListener("change", checkStatus);
document.getElementById("close_time").addEventListener("change", checkStatus);
</script>

<!-- TOAST -->
<script>
<?php if($success){ ?>
let toast = document.getElementById("toast");
toast.classList.remove("hidden");

setTimeout(() => {
    toast.classList.add("hidden");
}, 3000);

document.getElementById("hotelForm").reset();
document.getElementById("statusPreview").innerText = "Status Preview";
<?php } ?>
</script>

<!-- COMMON SCRIPTS -->
<script src="assets/js/sidebar.js" defer></script>
<script src="assets/js/navbar.js" defer></script>

</body>
</html>