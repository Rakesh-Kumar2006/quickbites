<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<title>About Us - QuickBites</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

<!-- NAVBAR -->
<?php include("assets/navbar.php"); ?>

<!-- HERO SECTION -->
<section class="bg-gradient-to-r from-orange-500 to-red-500 text-white py-20">

<div class="max-w-6xl mx-auto px-6 text-center">

<h1 class="text-5xl font-bold mb-4">About QuickBites</h1>

<p class="text-lg max-w-3xl mx-auto">
QuickBites is a modern online food ordering and delivery platform
designed to provide delicious meals quickly and conveniently.
We connect customers with their favorite restaurants and ensure
fast, reliable delivery services.
</p>

</div>

</section>

<!-- ABOUT SECTION -->
<section class="py-16">

<div class="max-w-6xl mx-auto px-6 grid md:grid-cols-2 gap-10 items-center">

<!-- IMAGE -->
<div>

<img src="uploads/about.jpg"
class="rounded-2xl shadow-lg w-full h-[400px] object-cover"
onerror="this.src='https://via.placeholder.com/600x400'">

</div>

<!-- CONTENT -->
<div>

<h2 class="text-4xl font-bold text-orange-500 mb-6">
Who We Are
</h2>

<p class="text-gray-700 mb-4 leading-7">
QuickBites was created with a simple mission:
to make food ordering easy, fast, and enjoyable.
Whether you're craving pizza, burgers, biryani, or healthy meals,
our platform brings restaurants and customers together seamlessly.
</p>

<p class="text-gray-700 mb-4 leading-7">
Our system allows users to browse menus, place orders,
track deliveries, manage profiles, and enjoy secure online experiences.
We focus on quality service, customer satisfaction,
and modern technology.
</p>

<div class="grid grid-cols-2 gap-4 mt-6">

<div class="bg-white p-4 rounded-xl shadow text-center">
<h3 class="text-3xl font-bold text-orange-500">1000+</h3>
<p class="text-gray-600">Orders Delivered</p>
</div>

<div class="bg-white p-4 rounded-xl shadow text-center">
<h3 class="text-3xl font-bold text-orange-500">50+</h3>
<p class="text-gray-600">Restaurants</p>
</div>

<div class="bg-white p-4 rounded-xl shadow text-center">
<h3 class="text-3xl font-bold text-orange-500">500+</h3>
<p class="text-gray-600">Happy Customers</p>
</div>

<div class="bg-white p-4 rounded-xl shadow text-center">
<h3 class="text-3xl font-bold text-orange-500">24/7</h3>
<p class="text-gray-600">Support</p>
</div>

</div>

</div>

</div>

</section>

<!-- WHY CHOOSE US -->
<section class="bg-white py-16">

<div class="max-w-6xl mx-auto px-6">

<h2 class="text-4xl font-bold text-center text-orange-500 mb-12">
Why Choose Us
</h2>

<div class="grid md:grid-cols-3 gap-8">

<div class="bg-gray-100 p-6 rounded-2xl shadow hover:shadow-lg transition">

<div class="text-5xl mb-4">🍔</div>

<h3 class="text-xl font-bold mb-3">
Delicious Food
</h3>

<p class="text-gray-600">
Choose from a wide variety of cuisines and restaurants.
</p>

</div>

<div class="bg-gray-100 p-6 rounded-2xl shadow hover:shadow-lg transition">

<div class="text-5xl mb-4">🚚</div>

<h3 class="text-xl font-bold mb-3">
Fast Delivery
</h3>

<p class="text-gray-600">
Quick and reliable delivery service at your doorstep.
</p>

</div>

<div class="bg-gray-100 p-6 rounded-2xl shadow hover:shadow-lg transition">

<div class="text-5xl mb-4">💳</div>

<h3 class="text-xl font-bold mb-3">
Secure Payments
</h3>

<p class="text-gray-600">
Safe and secure payment options for hassle-free ordering.
</p>

</div>

</div>

</div>

</section>


<!-- CTA SECTION -->
<section class="bg-orange-500 text-white py-16">

<div class="max-w-4xl mx-auto text-center px-6">

<h2 class="text-4xl font-bold mb-4">
Ready to Order Delicious Food?
</h2>

<p class="mb-6 text-lg">
Browse restaurants and order your favorite meals now.
</p>

<a href="menu.php"
class="bg-white text-orange-500 px-6 py-3 rounded-lg font-bold hover:bg-gray-100 transition">

Explore Menu

</a>

</div>

</section>

<!-- FOOTER -->
<?php include("assets/footer.php"); ?>

</body>
</html>