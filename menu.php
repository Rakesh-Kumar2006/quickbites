<?php
include("db.php");
include("assets/navbar.php");

$hotel_id = $_GET['hotel_id'] ?? '';
$filter   = $_GET['type'] ?? '';
$search   = $_GET['search'] ?? '';

$res = null;
if($hotel_id){
    $res = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM admin_restaurants WHERE hotel_id='$hotel_id'"));
}

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
    $query .= " AND (f.name LIKE '%$search%' OR f.description LIKE '%$search%')";
}

if($filter == 'veg'){
    $query .= " AND LOWER(f.category)='veg'";
}
elseif($filter == 'nonveg'){
    $query .= " AND (LOWER(f.category)='nonveg' OR LOWER(f.category)='non-veg')";
}

$query .= " GROUP BY f.food_id";
$foods = mysqli_query($conn, $query);
?>

<script src="https://cdn.tailwindcss.com"></script>

<!-- 🔥 GLOBAL JS FIX (IMPORTANT) -->
<script>
console.log("🔥 GLOBAL SCRIPT LOADED");

// MAKE FUNCTIONS GLOBAL
window.updateQty = function(id, change){
    let el = document.getElementById("qty_"+id);
    if(!el) return;

    let val = parseInt(el.value) || 1;
    val += change;

    if(val < 1) val = 1;
    el.value = val;
};

window.addToCart = function(id){

    console.log("ADD CLICKED:", id);

    let qtyEl = document.getElementById("qty_"+id);
    let qty = qtyEl ? qtyEl.value : 1;

    let variantEl = document.querySelector("input[name='variant_"+id+"']:checked");
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
        console.log("Cart Updated");
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

    fetch("cart_action.php", {method:"POST", body:fd})
    .then(res=>res.text())
    .then(data=>{
        document.getElementById("cartBox").innerHTML = data;
    });
}

function removeItem(id){
    let fd = new FormData();
    fd.append("remove", id);

    fetch("cart_action.php", {method:"POST", body:fd})
    .then(res=>res.text())
    .then(data=>{
        document.getElementById("cartBox").innerHTML = data;
    });
}
</script>

<div class="max-w-7xl mx-auto px-6 py-6">

<a href="home.php" class="bg-gray-200 px-4 py-2 rounded mb-4 inline-block">← Back</a>

<h2 class="text-2xl font-bold mb-4">
<?php echo $search ? "Showing: $search" : "Menu"; ?>
</h2>

<?php if($res){ ?>
<div class="bg-white p-6 rounded-xl shadow mb-6 flex gap-6 items-center">
<img src="admin/uploads/<?php echo $res['image']; ?>" class="h-28 w-28 rounded">
<div>
<h2 class="text-xl font-bold"><?php echo $res['name']; ?></h2>
<p class="text-gray-500"><?php echo $res['description']; ?></p>
</div>
</div>
<?php } ?>

<!-- FILTER -->
<div class="flex gap-3 mb-6">
<a href="?hotel_id=<?php echo $hotel_id; ?>&search=<?php echo $search; ?>"
class="px-4 py-2 <?php echo $filter==''?'bg-black text-white':'bg-gray-200'; ?>">All</a>

<a href="?hotel_id=<?php echo $hotel_id; ?>&search=<?php echo $search; ?>&type=veg"
class="px-4 py-2 <?php echo $filter=='veg'?'bg-green-600 text-white':'bg-green-200'; ?>">Veg</a>

<a href="?hotel_id=<?php echo $hotel_id; ?>&search=<?php echo $search; ?>&type=nonveg"
class="px-4 py-2 <?php echo $filter=='nonveg'?'bg-red-600 text-white':'bg-red-200'; ?>">Non-Veg</a>
</div>

<div class="grid md:grid-cols-3 gap-6">

<!-- FOOD -->
<div class="md:col-span-2 space-y-4">

<?php while($f = mysqli_fetch_assoc($foods)){ ?>

<div class="bg-white p-4 rounded-xl shadow flex justify-between">

<div class="w-2/3">
<h3 class="font-bold"><?php echo $f['name']; ?></h3>
<p class="text-sm text-gray-500"><?php echo $f['description']; ?></p>

<div class="mt-2 space-y-1">
<?php
if($f['variants']){
foreach(explode("|",$f['variants']) as $i=>$v){
$checked = $i==0 ? "checked" : "";
echo "
<label class='flex gap-2 text-sm'>
<input type='radio' name='variant_".$f['food_id']."' value='$v' $checked>
<span>$v</span>
</label>";
}
}else{
echo "₹".$f['price'];
}
?>
</div>
</div>

<div class="text-center">

<img src="admin/uploads/<?php echo $f['image']; ?>"
class="h-20 w-20 rounded mb-2">

<div class="flex gap-2 justify-center mb-2">
<button type="button" onclick="updateQty(<?php echo $f['food_id']; ?>,-1)">-</button>

<input type="text" id="qty_<?php echo $f['food_id']; ?>" value="1"
class="w-10 text-center border rounded">

<button type="button" onclick="updateQty(<?php echo $f['food_id']; ?>,1)">+</button>
</div>

<button type="button"
onclick="addToCart(<?php echo $f['food_id']; ?>)"
class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600">
ADD
</button>

</div>
</div>

<?php } ?>

</div>
<div class="bg-white rounded-2xl shadow-lg sticky top-20 overflow-hidden border">

<!-- HEADER -->
 <div class="bg-gradient-to-r from-gray-800 to-black text-white p-4">
    <h3 class="font-bold text-lg flex items-center gap-2">
        🛒 Your Cart
    </h3>
    <p class="text-xs opacity-80">Review your items</p>
</div>

<!-- CART ITEMS -->
<div id="cartBox" class="p-4 space-y-3 max-h-[400px] overflow-y-auto">

<?php include("cart_fetch.php"); ?>

</div>

<!-- FOOTER -->
<div class="p-4 border-t bg-gray-50">

<a href="cart.php"
class="block text-center bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-xl font-semibold shadow">
View Full Cart →
</a>

</div>

</div>
<?php include("assets/footer.php"); ?>