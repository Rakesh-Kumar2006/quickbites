<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$admin_id = $_SESSION['admin_id'];
$success = false;

// ADD FOOD + VARIANTS
if(isset($_POST['add_food'])){

    $name        = $_POST['name'];
    $description = $_POST['description'];
    $price       = $_POST['price'];
    $category    = $_POST['category'];
    $hotel_id    = $_POST['restaurant_id'];

    $image = $_FILES['image']['name'];
    $tmp   = $_FILES['image']['tmp_name'];
    move_uploaded_file($tmp, "uploads/".$image);

    mysqli_query($conn, "INSERT INTO admin_food_items
    (admin_id, hotel_id, name, description, price, category, image)
    VALUES
    ('$admin_id','$hotel_id','$name','$description','$price','$category','$image')");

    $food_id = mysqli_insert_id($conn);

    if(isset($_POST['variant_name'])){
        foreach($_POST['variant_name'] as $key => $variant){
            $v_price = $_POST['variant_price'][$key];

            if(!empty($variant) && !empty($v_price)){
                mysqli_query($conn, "INSERT INTO food_variants
                (food_id, variant_name, price)
                VALUES
                ('$food_id','$variant','$v_price')");
            }
        }
    }

    $success = true;
}

// FETCH RESTAURANTS
$restaurants = mysqli_query($conn, "SELECT * FROM admin_restaurants");


/* ================= FILTER + PAGINATION ================= */

$limit = 6;

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if($page < 1) $page = 1;

$category = isset($_GET['category']) ? $_GET['category'] : '';

$offset = ($page - 1) * $limit;

// FILTER CONDITION
$where = "";
if($category != ""){
    $where = "WHERE f.category = '$category'";
}

// COUNT
$count_query = "SELECT COUNT(*) as total FROM admin_food_items f $where";
$count_result = mysqli_query($conn, $count_query);
$total_items = mysqli_fetch_assoc($count_result)['total'];

$total_pages = ceil($total_items / $limit);

// FETCH FOOD
$foods = mysqli_query($conn, "
SELECT f.*, r.name AS restaurant_name, r.open_time, r.close_time,
GROUP_CONCAT(CONCAT(v.variant_name, ' - ₹', v.price) SEPARATOR '|') AS variants
FROM admin_food_items f
JOIN admin_restaurants r ON f.hotel_id = r.hotel_id
LEFT JOIN food_variants v ON f.food_id = v.food_id
$where
GROUP BY f.food_id
ORDER BY f.food_id DESC
LIMIT $limit OFFSET $offset
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Food Items</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
</head>

<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

<?php include("sidebar.php"); ?>

<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

<div id="mainContent" class="flex-1 flex flex-col transition-all duration-300 md:ml-64">

<?php include("navbar.php"); ?>

<main class="p-6 overflow-y-auto">

<!-- ADD FOOD -->
<div class="bg-white p-6 rounded-2xl shadow-lg mb-10 max-w-lg mx-auto">

<h2 class="text-xl font-bold mb-4 text-center">🍔 Add Food Item</h2>

<form id="foodForm" method="POST" enctype="multipart/form-data" class="space-y-3">

<input type="text" name="name" placeholder="Food Name"
class="w-full border p-2 rounded-lg" required>

<textarea name="description" placeholder="Food Description"
class="w-full border p-2 rounded-lg"></textarea>

<input type="number" name="price" placeholder="Base Price"
class="w-full border p-2 rounded-lg">

<select name="category" class="w-full border p-2 rounded-lg" required>
<option value="">Category</option>
<option value="Veg">Veg</option>
<option value="Non-Veg">Non-Veg</option>
</select>

<select name="restaurant_id" class="w-full border p-2 rounded-lg" required>
<option value="">Select Restaurant</option>
<?php while($r = mysqli_fetch_assoc($restaurants)){ ?>
<option value="<?php echo $r['hotel_id']; ?>">
<?php echo $r['name']; ?>
</option>
<?php } ?>
</select>

<input type="file" name="image" class="w-full border p-2 rounded-lg">

<!-- VARIANTS -->
<div id="variantContainer" class="space-y-2">
<label class="font-semibold">Variants</label>

<div class="flex gap-2">
<select name="variant_name[]" class="border p-2 rounded w-1/2">
<option value="">Select</option>
<option value="Half">Half</option>
<option value="Full">Full</option>
<option value="Regular">Regular</option>
<option value="Large">Large</option>
</select>

<input type="number" name="variant_price[]" placeholder="Price"
class="border p-2 rounded w-1/2">

<button type="button" onclick="removeVariant(this)"
class="bg-red-500 text-white px-3 rounded">✖</button>
</div>
</div>

<button type="button" onclick="addVariant()"
class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
+ Add Variant
</button>

<button name="add_food"
class="bg-green-500 text-white w-full py-2 rounded-lg hover:bg-green-600">
Add Food
</button>

</form>
</div>
<!-- MANAGE -->
<h2 class="text-2xl font-bold mb-4">📊 Manage Food Items</h2>

<!-- FILTER -->
<div class="flex gap-3 mb-4">
<a href="?category=" class="px-3 py-1 bg-gray-300 rounded">All</a>
<a href="?category=Veg" class="px-3 py-1 bg-green-500 text-white rounded">Veg</a>
<a href="?category=Non-Veg" class="px-3 py-1 bg-red-500 text-white rounded">Non-Veg</a>
</div>


<div class="grid md:grid-cols-3 gap-6">

<?php 
date_default_timezone_set('Asia/Kolkata');
$current = strtotime(date("H:i"));

while($f = mysqli_fetch_assoc($foods)){ 

    $open  = strtotime($f['open_time']);
    $close = strtotime($f['close_time']);

    if ($open < $close) {
        $isRestaurantOpen = ($current >= $open && $current <= $close);
    } else {
        $isRestaurantOpen = ($current >= $open || $current <= $close);
    }

    $finalStatus = ($isRestaurantOpen && $f['status'] == 'available') ? 'available' : 'unavailable';
?>

<div class="bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden">

<div class="relative">
<img src="uploads/<?php echo $f['image']; ?>"
onerror="this.src='https://via.placeholder.com/300'"
class="h-40 w-full object-cover">

<span class="absolute top-2 left-2 px-2 py-1 text-xs rounded-full 
<?php echo ($f['category']=='Veg') ? 'bg-green-500' : 'bg-red-500'; ?> text-white">
<?php echo $f['category']; ?>
</span>
</div>

<div class="p-4 space-y-1">

<h3 class="font-bold text-lg"><?php echo $f['name']; ?></h3>

<p class="text-sm text-gray-500 line-clamp-2">
<?php echo $f['description']; ?>
</p>

<p class="text-xs text-gray-400">
🍽 <?php echo $f['restaurant_name']; ?>
</p>

<div class="flex flex-wrap gap-2 mt-2">
<?php 
if(!empty($f['variants'])){
    foreach(explode("|", $f['variants']) as $v){
        echo "<span class='bg-gray-100 px-2 py-1 text-xs rounded'>$v</span>";
    }
} else {
    echo "<span class='text-green-600 font-semibold'>₹".$f['price']."</span>";
}
?>
</div>

<div class="flex justify-between items-center mt-2">
<span class="text-xs px-2 py-1 rounded-full 
<?php echo ($finalStatus=='available') ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'; ?>">
<?php echo ucfirst($finalStatus); ?>
</span>
</div>

<?php if(!$isRestaurantOpen){ ?>
<p class="text-xs text-red-500 font-semibold">🚫 Restaurant Closed</p>
<?php } ?>

<div class="flex gap-2 mt-3">
<a href="edit_food.php?id=<?php echo $f['food_id']; ?>"
class="flex-1 text-center text-xs bg-blue-500 text-white py-1.5 rounded-lg">
✏ Edit
</a>

<a href="delete_food.php?id=<?php echo $f['food_id']; ?>"
onclick="return confirm('Delete this item?')"
class="flex-1 text-center text-xs bg-red-500 text-white py-1.5 rounded-lg">
🗑 Delete
</a>
</div>

</div>
</div>

<?php } ?>

</div>

<!-- PAGINATION -->
<div class="flex justify-center mt-6 gap-2 flex-wrap">

<?php if($page > 1){ ?>
<a href="?page=<?php echo $page-1; ?>&category=<?php echo $category; ?>"
class="px-3 py-1 bg-gray-300 rounded">Prev</a>
<?php } ?>

<?php for($i=1; $i<=$total_pages; $i++){ ?>
<a href="?page=<?php echo $i; ?>&category=<?php echo $category; ?>"
class="px-3 py-1 rounded <?php echo ($i==$page)?'bg-blue-500 text-white':'bg-gray-200'; ?>">
<?php echo $i; ?>
</a>
<?php } ?>

<?php if($page < $total_pages){ ?>
<a href="?page=<?php echo $page+1; ?>&category=<?php echo $category; ?>"
class="px-3 py-1 bg-gray-300 rounded">Next</a>
<?php } ?>

</div>

</main>
</div>
</div>

<!-- ✅ FIXED JS -->
<script>
function addVariant(){
    let container = document.getElementById("variantContainer");

    let html = `
    <div class="flex gap-2 mt-2">
        <select name="variant_name[]" class="border p-2 rounded w-1/2">
            <option value="">Select</option>
            <option value="Half">Half</option>
            <option value="Full">Full</option>
            <option value="Regular">Regular</option>
            <option value="Large">Large</option>
        </select>

        <input type="number" name="variant_price[]" placeholder="Price"
        class="border p-2 rounded w-1/2">

        <button type="button" onclick="removeVariant(this)"
        class="bg-red-500 text-white px-3 rounded">✖</button>
    </div>
    `;

    container.insertAdjacentHTML("beforeend", html);
}

function removeVariant(btn){
    btn.parentElement.remove();
}
</script>

<!-- ✅ KEEP THESE OUTSIDE -->
<script src="assets/js/sidebar.js" defer></script>
<script src="assets/js/navbar.js" defer></script>

</body>
</html>