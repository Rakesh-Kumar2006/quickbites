<?php
session_start();
include("db.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$success = false;

// FETCH FOOD
$data = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM admin_food_items WHERE food_id=$id"));

// FETCH VARIANTS
$variants = mysqli_query($conn, "SELECT * FROM food_variants WHERE food_id=$id");

// FETCH RESTAURANTS
$restaurants = mysqli_query($conn, "SELECT * FROM admin_restaurants");

// UPDATE
if(isset($_POST['update'])){

    $name        = $_POST['name'];
    $description = $_POST['description'];
    $price       = $_POST['price'];
    $category    = $_POST['category'];
    $hotel_id    = $_POST['restaurant_id'];
    $status      = $_POST['status'];

    // IMAGE UPDATE
    if(!empty($_FILES['image']['name'])){
        $image = $_FILES['image']['name'];
        $tmp   = $_FILES['image']['tmp_name'];

        move_uploaded_file($tmp, "uploads/".$image);

        if(file_exists("uploads/".$data['image'])){
            unlink("uploads/".$data['image']);
        }

        $imgQuery = ", image='$image'";
    } else {
        $imgQuery = "";
    }

    mysqli_query($conn, "UPDATE admin_food_items SET
        name='$name',
        description='$description',
        price='$price',
        category='$category',
        hotel_id='$hotel_id',
        status='$status'
        $imgQuery
        WHERE food_id=$id
    ");

    // 🔥 DELETE OLD VARIANTS
    mysqli_query($conn, "DELETE FROM food_variants WHERE food_id=$id");

    // 🔥 INSERT UPDATED VARIANTS
    if(isset($_POST['variant_name'])){
        foreach($_POST['variant_name'] as $key => $variant){
            $v_price = $_POST['variant_price'][$key];

            if(!empty($variant) && !empty($v_price)){
                mysqli_query($conn, "INSERT INTO food_variants
                (food_id, variant_name, price)
                VALUES
                ('$id','$variant','$v_price')");
            }
        }
    }

    $success = true;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Edit Food</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<div class="flex h-screen overflow-hidden">

<?php include("sidebar.php"); ?>

<div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>

<div id="mainContent" class="flex-1 flex flex-col md:ml-64">

<?php include("navbar.php"); ?>

<main class="p-6 flex justify-center">

<div class="bg-white p-6 rounded-2xl shadow w-full max-w-lg">

<h2 class="text-xl font-bold mb-4 text-center">✏️ Edit Food Item</h2>

<a href="food_items.php"
class="inline-block mb-4 px-4 py-2 bg-gray-200 rounded-lg">← Back</a>

<form method="POST" enctype="multipart/form-data" class="space-y-3">

<input type="text" name="name"
value="<?php echo $data['name']; ?>"
class="w-full border p-2 rounded-lg">

<textarea name="description"
class="w-full border p-2 rounded-lg"><?php echo $data['description']; ?></textarea>

<input type="number" name="price"
value="<?php echo $data['price']; ?>"
class="w-full border p-2 rounded-lg">

<select name="category" class="w-full border p-2 rounded-lg">
<option value="<?php echo $data['category']; ?>"><?php echo $data['category']; ?></option>
<option value="Veg">Veg</option>
<option value="Non-Veg">Non-Veg</option>
</select>

<select name="restaurant_id" class="w-full border p-2 rounded-lg">
<?php while($r = mysqli_fetch_assoc($restaurants)){ ?>
<option value="<?php echo $r['hotel_id']; ?>"
<?php if($r['hotel_id']==$data['hotel_id']) echo "selected"; ?>>
<?php echo $r['name']; ?>
</option>
<?php } ?>
</select>

<select name="status" class="w-full border p-2 rounded-lg">
<option value="available" <?php if($data['status']=='available') echo "selected"; ?>>Available</option>
<option value="unavailable" <?php if($data['status']=='unavailable') echo "selected"; ?>>Unavailable</option>
</select>

<img src="uploads/<?php echo $data['image']; ?>"
class="w-full h-32 object-cover rounded">

<input type="file" name="image" class="w-full border p-2 rounded-lg">

<!-- 🔥 VARIANTS -->
<div id="variantContainer" class="space-y-2">

<label class="font-semibold">Variants</label>

<?php while($v = mysqli_fetch_assoc($variants)){ ?>
<div class="flex gap-2">
<select name="variant_name[]" class="border p-2 rounded w-1/2">
<option value="<?php echo $v['variant_name']; ?>"><?php echo $v['variant_name']; ?></option>
<option value="Half">Half</option>
<option value="Full">Full</option>
<option value="Regular">Regular</option>
<option value="Large">Large</option>
</select>

<input type="number" name="variant_price[]"
value="<?php echo $v['price']; ?>"
class="border p-2 rounded w-1/2">

<button type="button" onclick="removeVariant(this)"
class="bg-red-500 text-white px-3 rounded">✖</button>
</div>
<?php } ?>

</div>

<button type="button" onclick="addVariant()"
class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
+ Add Variant
</button>

<button name="update"
class="w-full bg-green-500 text-white py-2 rounded-lg hover:bg-green-600">
Update Food
</button>

</form>

</div>

</main>
</div>
</div>

<!-- SUCCESS -->
<?php if($success){ ?>
<script>
alert("Food Updated Successfully ✅");
window.location="food_items.php";
</script>
<?php } ?>

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

<script src="assets/js/sidebar.js" defer></script>
<script src="assets/js/navbar.js" defer></script>

</body>
</html>