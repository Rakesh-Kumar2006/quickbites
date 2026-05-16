<?php
include("db.php");
include("assets/navbar.php");

$hotel_id = $_GET['hotel_id'] ?? '';
$filter   = $_GET['type'] ?? '';
$search   = $_GET['search'] ?? '';
$sort     = $_GET['sort'] ?? '';

$res = null;

if($hotel_id){

    $res = mysqli_fetch_assoc(mysqli_query($conn,"
    SELECT * FROM admin_restaurants 
    WHERE hotel_id='$hotel_id'
    "));
}

// FOOD QUERY
$query = "
SELECT f.*, 
GROUP_CONCAT(CONCAT(v.variant_name, ' - ₹', v.price) SEPARATOR '|') AS variants
FROM admin_food_items f
LEFT JOIN food_variants v ON f.food_id = v.food_id
WHERE 1
";

if($hotel_id){
    $query .= " AND f.hotel_id='$hotel_id'";
}

if($search){
    $query .= "
    AND (
        f.name LIKE '%$search%' 
        OR f.description LIKE '%$search%'
    )";
}

// FILTERS
if($filter == 'veg'){
    $query .= " AND LOWER(f.category)='veg'";
}
elseif($filter == 'nonveg'){
    $query .= "
    AND (
        LOWER(f.category)='nonveg' 
        OR LOWER(f.category)='non-veg'
    )";
}

$query .= " GROUP BY f.food_id";

// SORTING
if($sort == 'low'){
    $query .= " ORDER BY f.price ASC";
}
elseif($sort == 'high'){
    $query .= " ORDER BY f.price DESC";
}
elseif($sort == 'az'){
    $query .= " ORDER BY f.name ASC";
}
elseif($sort == 'za'){
    $query .= " ORDER BY f.name DESC";
}
else{
    $query .= " ORDER BY f.food_id DESC";
}

$foods = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>

<title>Restaurant Menu - QuickBites</title>

<script src="https://cdn.tailwindcss.com"></script>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

</head>

<body class="bg-gradient-to-br from-orange-50 via-white to-orange-100">

<!-- GLOBAL JS -->
<script>

window.updateQty = function(id, change){

    let el = document.getElementById("qty_"+id);

    if(!el) return;

    let val = parseInt(el.value) || 1;

    val += change;

    if(val < 1) val = 1;

    el.value = val;
};

window.addToCart = function(id){

    let qtyEl = document.getElementById("qty_"+id);

    let qty = qtyEl ? qtyEl.value : 1;

    let variantEl =
    document.querySelector("input[name='variant_"+id+"']:checked");

    let variant = variantEl ? variantEl.value : "";

    let formData = new FormData();

    formData.append("food_id", id);
    formData.append("qty", qty);
    formData.append("variant", variant);

    fetch("cart_action.php", {

        method: "POST",

        body: formData

    })

    .then(res => res.text())

    .then(data => {

        let box = document.getElementById("cartBox");

        if(box){
            box.innerHTML = data;
        }

    })

    .catch(err => {

        console.error(err);

        alert("Error adding to cart");

    });
};

function updateCart(id, change){

    let fd = new FormData();

    fd.append("update", true);
    fd.append("id", id);
    fd.append("change", change);

    fetch("cart_action.php", {

        method:"POST",
        body:fd

    })

    .then(res=>res.text())

    .then(data=>{

        document.getElementById("cartBox").innerHTML = data;

    });
}

function removeItem(id){

    let fd = new FormData();

    fd.append("remove", id);

    fetch("cart_action.php", {

        method:"POST",
        body:fd

    })

    .then(res=>res.text())

    .then(data=>{

        document.getElementById("cartBox").innerHTML = data;

    });
}

</script>

<div class="max-w-7xl mx-auto px-4 py-8">

<!-- BACK -->
<a href="home.php"
class="inline-flex items-center gap-2 bg-white hover:bg-orange-500 hover:text-white transition px-5 py-3 rounded-2xl shadow mb-6">

← Back

</a>

<!-- TITLE -->
<h1 class="text-4xl font-extrabold text-gray-800 mb-2">

<?php echo $search ? "Showing Results for '$search'" : "Restaurant Menu"; ?>

</h1>

<p class="text-gray-500 mb-8">
Browse delicious meals and order instantly
</p>

<!-- RESTAURANT -->
<?php if($res){ ?>

<div class="bg-white rounded-3xl shadow-xl p-6 mb-8 flex flex-col md:flex-row gap-6 items-center border border-orange-100">

<img src="admin/uploads/<?php echo $res['image']; ?>"
class="h-32 w-32 rounded-3xl object-cover shadow">

<div class="flex-1">

<h2 class="text-3xl font-bold text-gray-800 mb-2">
<?php echo $res['name']; ?>
</h2>

<p class="text-gray-500 leading-7">
<?php echo $res['description']; ?>
</p>

</div>

</div>

<?php } ?>

<!-- FILTERS -->
<div class="bg-white rounded-3xl shadow-lg p-5 mb-8 border border-orange-100">

<div class="flex flex-wrap gap-4 items-center">

<!-- ALL -->
<a href="?hotel_id=<?php echo $hotel_id; ?>&search=<?php echo $search; ?>"
class="px-5 py-3 rounded-2xl font-semibold transition
<?php echo $filter=='' ? 'bg-black text-white shadow-lg' : 'bg-gray-100 hover:bg-gray-200'; ?>">

🍽️ All

</a>

<!-- VEG -->
<a href="?hotel_id=<?php echo $hotel_id; ?>&search=<?php echo $search; ?>&type=veg"
class="px-5 py-3 rounded-2xl font-semibold transition
<?php echo $filter=='veg' ? 'bg-green-600 text-white shadow-lg' : 'bg-green-100 hover:bg-green-200'; ?>">

🥗 Veg

</a>

<!-- NON VEG -->
<a href="?hotel_id=<?php echo $hotel_id; ?>&search=<?php echo $search; ?>&type=nonveg"
class="px-5 py-3 rounded-2xl font-semibold transition
<?php echo $filter=='nonveg' ? 'bg-red-600 text-white shadow-lg' : 'bg-red-100 hover:bg-red-200'; ?>">

🍗 Non-Veg

</a>

<!-- LOW TO HIGH -->
<a href="?hotel_id=<?php echo $hotel_id; ?>&search=<?php echo $search; ?>&type=<?php echo $filter; ?>&sort=low"
class="px-5 py-3 rounded-2xl font-semibold transition
<?php echo $sort=='low' ? 'bg-orange-500 text-white shadow-lg' : 'bg-orange-100 hover:bg-orange-200'; ?>">

💰 Low → High

</a>

<!-- HIGH TO LOW -->
<a href="?hotel_id=<?php echo $hotel_id; ?>&search=<?php echo $search; ?>&type=<?php echo $filter; ?>&sort=high"
class="px-5 py-3 rounded-2xl font-semibold transition
<?php echo $sort=='high' ? 'bg-orange-500 text-white shadow-lg' : 'bg-orange-100 hover:bg-orange-200'; ?>">

💸 High → Low

</a>

<!-- A-Z -->
<a href="?hotel_id=<?php echo $hotel_id; ?>&search=<?php echo $search; ?>&type=<?php echo $filter; ?>&sort=az"
class="px-5 py-3 rounded-2xl font-semibold transition
<?php echo $sort=='az' ? 'bg-blue-500 text-white shadow-lg' : 'bg-blue-100 hover:bg-blue-200'; ?>">

🔤 A → Z

</a>

<!-- Z-A -->
<a href="?hotel_id=<?php echo $hotel_id; ?>&search=<?php echo $search; ?>&type=<?php echo $filter; ?>&sort=za"
class="px-5 py-3 rounded-2xl font-semibold transition
<?php echo $sort=='za' ? 'bg-blue-500 text-white shadow-lg' : 'bg-blue-100 hover:bg-blue-200'; ?>">

🔠 Z → A

</a>

</div>

</div>

<!-- CONTENT -->
<div class="grid lg:grid-cols-3 gap-8">

<!-- FOOD ITEMS -->
<div class="lg:col-span-2 space-y-6">

<?php while($f = mysqli_fetch_assoc($foods)){ ?>

<div class="bg-white rounded-3xl shadow-lg hover:shadow-2xl transition overflow-hidden border border-orange-100 flex flex-col md:flex-row">

<!-- IMAGE -->
<img src="admin/uploads/<?php echo $f['image']; ?>"
class="w-full md:w-52 h-52 object-cover">

<!-- CONTENT -->
<div class="flex-1 p-6">

<div class="flex justify-between items-start mb-3">

<div>

<h3 class="text-2xl font-bold text-gray-800">
<?php echo $f['name']; ?>
</h3>

<p class="text-gray-500 mt-1 leading-6">
<?php echo $f['description']; ?>
</p>

</div>

</div>

<!-- VARIANTS -->
<div class="mt-4 space-y-2">

<?php

if($f['variants']){

foreach(explode("|",$f['variants']) as $i=>$v){

$checked = $i==0 ? "checked" : "";

echo "

<label class='flex items-center gap-3 bg-gray-50 hover:bg-orange-50 p-3 rounded-xl cursor-pointer transition'>

<input type='radio'
name='variant_".$f['food_id']."'
value='$v'
$checked>

<span class='font-medium'>$v</span>

</label>

";

}

}else{

echo "
<div class='text-orange-500 font-bold text-xl'>
₹".$f['price']."
</div>
";

}

?>

</div>

<!-- QTY -->
<div class="flex items-center justify-between mt-6">

<div class="flex items-center gap-3 bg-gray-100 rounded-2xl p-2">

<button type="button"
onclick="updateQty(<?php echo $f['food_id']; ?>,-1)"
class="w-10 h-10 rounded-xl bg-white shadow text-xl">

−

</button>

<input type="text"
id="qty_<?php echo $f['food_id']; ?>"
value="1"
class="w-12 text-center bg-transparent font-bold outline-none">

<button type="button"
onclick="updateQty(<?php echo $f['food_id']; ?>,1)"
class="w-10 h-10 rounded-xl bg-white shadow text-xl">

+

</button>

</div>

<button type="button"
onclick="addToCart(<?php echo $f['food_id']; ?>)"
class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-2xl font-bold shadow-lg transition">

ADD TO CART

</button>

</div>

</div>

</div>

<?php } ?>

</div>

<!-- CART -->
<div>

<div class="bg-white rounded-3xl shadow-2xl sticky top-24 overflow-hidden border border-orange-100">

<!-- HEADER -->
<div class="bg-gradient-to-r from-orange-500 to-red-500 text-white p-6">

<h3 class="font-bold text-2xl flex items-center gap-3">
🛒 Your Cart
</h3>

<p class="text-sm opacity-90 mt-1">
Review your selected items
</p>

</div>

<!-- CART BODY -->
<div id="cartBox"
class="p-5 space-y-4 max-h-[500px] overflow-y-auto">

<?php include("cart_fetch.php"); ?>

</div>

<!-- FOOTER -->
<div class="p-5 border-t bg-gray-50">

<a href="cart.php"
class="block text-center bg-orange-500 hover:bg-orange-600 text-white py-4 rounded-2xl font-bold shadow-lg transition">

View Full Cart →

</a>

</div>

</div>

</div>

</div>

</div>

<?php include("assets/footer.php"); ?>

</body>
</html>