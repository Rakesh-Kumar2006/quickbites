<?php
session_start();

include("db.php");
include("assets/navbar.php");

$user_id = $_SESSION['user_id'] ?? 0;

if(!$user_id){

    header("Location: login.php");
    exit();
}

$msg = "";

// SUBMIT REVIEW
if(isset($_POST['submit_review'])){

    $food_id = mysqli_real_escape_string($conn, $_POST['food_id']);
    $rating = mysqli_real_escape_string($conn, $_POST['rating']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);

    // CHECK ALREADY REVIEWED
    $check = mysqli_query($conn,"
    SELECT * FROM food_reviews
    WHERE user_id='$user_id'
    AND food_id='$food_id'
    ");

    if(mysqli_num_rows($check) > 0){

        $msg = "You already reviewed this food item!";

    } else {

        mysqli_query($conn,"
        INSERT INTO food_reviews(
            food_id,
            user_id,
            rating,
            comment,
            created_at
        )
        VALUES(
            '$food_id',
            '$user_id',
            '$rating',
            '$comment',
            NOW()
        )
        ");

        $msg = "Review submitted successfully!";
    }
}

// FOOD ITEMS
$foods = mysqli_query($conn,"
SELECT * FROM admin_food_items
ORDER BY name ASC
");
?>

<!DOCTYPE html>
<html>
<head>

<title>Food Reviews - QuickBites</title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gradient-to-br from-orange-50 via-white to-orange-100 min-h-screen">

<div class="max-w-6xl mx-auto px-4 py-10">

<!-- BACK -->
<a href="home.php"
class="inline-flex items-center gap-2 bg-white hover:bg-orange-500 hover:text-white transition px-6 py-3 rounded-2xl shadow-lg font-bold mb-8">

← Back to Home

</a>

<!-- TOP -->
<div class="text-center mb-10">

<div class="w-24 h-24 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-5 shadow-lg">

<span class="text-5xl">
⭐
</span>

</div>

<h1 class="text-5xl font-extrabold text-gray-800 mb-3">
Food Reviews
</h1>

<p class="text-gray-500 text-lg max-w-2xl mx-auto">
Share your food experience and help others discover
the best dishes on QuickBites.
</p>

</div>

<!-- MESSAGE -->
<?php if($msg){ ?>

<div class="mb-8 text-center">

<div class="inline-block bg-green-100 border border-green-300 text-green-700 px-6 py-4 rounded-2xl shadow">

<?php echo $msg; ?>

</div>

</div>

<?php } ?>

<!-- MAIN CARD -->
<div class="bg-white rounded-3xl shadow-2xl overflow-hidden grid lg:grid-cols-2">

<!-- LEFT -->
<div class="hidden lg:flex relative">

<img src="uploads/reviews.jpg"
class="w-full h-full object-cover"
onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=1200&auto=format&fit=crop'">

<div class="absolute inset-0 bg-black/40"></div>

<div class="absolute bottom-10 left-10 text-white z-10">

<h2 class="text-4xl font-extrabold mb-4">
Rate Your Food 🍔
</h2>

<p class="text-lg text-gray-200 max-w-sm">
Tell us about your experience with food quality,
taste, and delivery service.
</p>

</div>

</div>

<!-- RIGHT -->
<div class="p-8 lg:p-10">

<h2 class="text-3xl font-bold text-gray-800 mb-8">
Write a Review
</h2>

<form method="POST" class="space-y-6">

<!-- FOOD -->
<div>

<label class="block text-sm font-semibold text-gray-600 mb-2">
Select Food Item
</label>

<select name="food_id"
class="w-full border border-gray-200 p-4 rounded-2xl focus:ring-2 focus:ring-orange-400 outline-none transition"
required>

<option value="">
Choose Food Item
</option>

<?php while($food = mysqli_fetch_assoc($foods)){ ?>

<option value="<?php echo $food['food_id']; ?>">

<?php echo $food['name']; ?>

</option>

<?php } ?>

</select>

</div>

<!-- RATING -->
<div>

<label class="block text-sm font-semibold text-gray-600 mb-2">
Rating
</label>

<select name="rating"
class="w-full border border-gray-200 p-4 rounded-2xl focus:ring-2 focus:ring-orange-400 outline-none transition"
required>

<option value="">
Select Rating
</option>

<option value="5">
⭐⭐⭐⭐⭐ Excellent
</option>

<option value="4">
⭐⭐⭐⭐ Very Good
</option>

<option value="3">
⭐⭐⭐ Good
</option>

<option value="2">
⭐⭐ Average
</option>

<option value="1">
⭐ Poor
</option>

</select>

</div>

<!-- COMMENT -->
<div>

<label class="block text-sm font-semibold text-gray-600 mb-2">
Review Comment
</label>

<textarea name="comment"
rows="6"
placeholder="Write your review here..."
class="w-full border border-gray-200 p-4 rounded-2xl focus:ring-2 focus:ring-orange-400 outline-none transition resize-none"
required></textarea>

</div>

<!-- BUTTON -->
<button type="submit"
name="submit_review"
class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-4 rounded-2xl text-lg font-bold shadow-lg transition">

Submit Review ⭐

</button>

</form>

</div>

</div>

<!-- RECENT REVIEWS -->
<div class="mt-12">

<h2 class="text-3xl font-bold text-gray-800 mb-8">
Recent Reviews
</h2>

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

<?php

$reviews = mysqli_query($conn,"
SELECT r.*, u.name as user_name, f.name as food_name
FROM food_reviews r
JOIN users u ON u.user_id=r.user_id
JOIN admin_food_items f ON f.food_id=r.food_id
ORDER BY review_id DESC
LIMIT 6
");

while($r = mysqli_fetch_assoc($reviews)){

?>

<div class="bg-white rounded-3xl shadow-lg p-6 border border-orange-100">

<div class="flex justify-between items-start mb-4">

<div>

<h3 class="font-bold text-lg text-gray-800">
<?php echo $r['food_name']; ?>
</h3>

<p class="text-sm text-gray-500">
by <?php echo $r['user_name']; ?>
</p>

</div>

<div class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full font-bold text-sm">

⭐ <?php echo $r['rating']; ?>/5

</div>

</div>

<p class="text-gray-600 leading-relaxed mb-4">
"<?php echo $r['comment']; ?>"
</p>

<p class="text-xs text-gray-400">

<?php echo date("d M Y", strtotime($r['created_at'])); ?>

</p>

</div>

<?php } ?>

</div>

</div>

</div>

<!-- FOOTER -->
<?php include("assets/footer.php"); ?>

</body>
</html>