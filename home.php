<?php
include("db.php");
include("assets/navbar.php");

// ✅ ADD THIS (timezone fix)
date_default_timezone_set('Asia/Kolkata');
?>

<script src="https://cdn.tailwindcss.com"></script>

<!-- HERO SECTION -->
<div class="bg-black text-white">

<div class="max-w-7xl mx-auto px-6 py-16 grid md:grid-cols-2 gap-10 items-center">

<!-- IMAGE -->
<div>
    <img src="uploads/hero.jpg" class="rounded-xl shadow-lg">
</div>

<!-- TEXT -->
<div>
    <h1 class="text-4xl font-bold mb-4">
        Fresh flavors. Every craving.
    </h1>

    <p class="text-gray-400 mb-6">
        Discover dishes made for your mood — fresh, comforting, or sweet.
        Order from the best restaurants near you.
    </p>

    <a href="#restaurants"
    class="bg-orange-500 px-6 py-3 rounded-lg text-white font-semibold hover:bg-orange-600">
        Order your food →
    </a>
</div>

</div>
</div>

<!-- CATEGORY SECTION -->
<div class="bg-gray-100 py-12">

<div class="max-w-7xl mx-auto px-6">

<h2 class="text-2xl font-bold text-center mb-10">
Try Out Our Variety Of Cuisine
</h2>

<div class="grid md:grid-cols-4 gap-6">

<?php
$categories = [
    ["Veg","veg.jpg"],
    ["Biryani","biryani.jpg"],
    ["Pizza","pizza.jpg"],
    ["Burger","burger.jpg"]
];

foreach($categories as $cat){
?>

<div class="bg-white rounded-xl shadow hover:shadow-xl transition overflow-hidden">

<img src="uploads/<?php echo $cat[1]; ?>" 
onerror="this.src='https://via.placeholder.com/300'"
class="h-40 w-full object-cover">

<div class="p-4 text-center">

<h3 class="font-bold text-lg"><?php echo $cat[0]; ?></h3>

<p class="text-sm text-gray-500 mb-3">
Delicious <?php echo strtolower($cat[0]); ?> items
</p>
<a href="menu.php?search=<?php echo $cat[0]; ?>"
class="bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 inline-block">
Explore
</a>

</div>
</div>

<?php } ?>

</div>
</div>
</div>

<!-- RESTAURANTS -->
<div id="restaurants" class="max-w-7xl mx-auto px-6 py-12">

<h2 class="text-2xl font-bold mb-6">🍽 Popular Restaurants</h2>

<?php
$type = $_GET['type'] ?? '';
?>

<!-- FILTER BUTTONS -->
<div class="flex gap-3 mb-6">

<a href="home.php#restaurants"
class="px-4 py-2 rounded <?php echo ($type==''?'bg-black text-white':'bg-gray-300'); ?>">
All
</a>

<a href="home.php?type=veg#restaurants"
class="px-4 py-2 rounded <?php echo ($type=='veg'?'bg-green-600 text-white':'bg-green-200'); ?>">
🟢 Veg
</a>

<a href="home.php?type=nonveg#restaurants"
class="px-4 py-2 rounded <?php echo ($type=='nonveg'?'bg-red-600 text-white':'bg-red-200'); ?>">
🔴 Non-Veg
</a>

<a href="home.php?type=both#restaurants"
class="px-4 py-2 rounded <?php echo ($type=='both'?'bg-yellow-500 text-white':'bg-yellow-200'); ?>">
🟡 Both
</a>

</div>

<div class="grid md:grid-cols-3 gap-6">

<?php
$query = "SELECT * FROM admin_restaurants";

if($type != ''){
    if($type == 'veg'){
        $query .= " WHERE category='veg' OR category='both'";
    }
    elseif($type == 'nonveg'){
        $query .= " WHERE category='nonveg' OR category='both'";
    }
    else{
        $query .= " WHERE category='both'";
    }
}

$q = mysqli_query($conn, $query);

while($r = mysqli_fetch_assoc($q)){

    // ✅ FIXED TIME LOGIC ONLY
    $current_time = strtotime(date("H:i"));

    $open  = strtotime(date("H:i", strtotime($r['open_time'])));
    $close = strtotime(date("H:i", strtotime($r['close_time'])));

    if($open < $close){
        $isOpen = ($current_time >= $open && $current_time <= $close);
    } else {
        $isOpen = ($current_time >= $open || $current_time <= $close);
    }

    // CATEGORY BADGE
    $cat = strtolower($r['category']);
    if($cat == 'veg'){
        $badge = "<span class='bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-semibold'>🟢 Veg</span>";
    }
    elseif($cat == 'nonveg'){
        $badge = "<span class='bg-red-100 text-red-600 px-2 py-1 rounded text-xs font-semibold'>🔴 Non-Veg</span>";
    }
    else{
        $badge = "<span class='bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs font-semibold'>🟡 Both</span>";
    }
?>

<a href="<?php echo $isOpen ? 'menu.php?hotel_id='.$r['hotel_id'] : '#'; ?>">

<div class="bg-white rounded-xl shadow hover:shadow-xl transition overflow-hidden <?php echo !$isOpen ? 'opacity-60 cursor-not-allowed' : ''; ?>">

<img src="admin/uploads/<?php echo $r['image']; ?>"
onerror="this.src='https://via.placeholder.com/300'"
class="h-48 w-full object-cover">

<div class="p-4">

<div class="flex justify-between items-center mb-1">
<h3 class="font-bold text-lg"><?php echo $r['name']; ?></h3>
<?php echo $badge; ?>
</div>

<p class="text-sm text-gray-500 line-clamp-2">
<?php echo $r['description']; ?>
</p>

<div class="flex justify-between mt-3 text-sm items-center">

<span class="bg-green-500 text-white px-2 py-1 rounded text-xs">
⭐ 4.2
</span>

<span class="<?php echo $isOpen ? 'text-green-600 font-semibold' : 'text-red-500 font-semibold'; ?>">
<?php echo $isOpen ? '🟢 Open' : '🔴 Closed'; ?>
</span>

</div>

</div>
</div>

</a>

<?php } ?>

</div>
</div>

<?php include("assets/footer.php"); ?>