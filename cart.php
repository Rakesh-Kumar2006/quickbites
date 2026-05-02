<?php
include("assets/navbar.php");
?>

<div class="max-w-3xl mx-auto p-6">

<h2 class="text-2xl font-bold mb-4">🛒 My Cart</h2>

<div id="cartBox">
<?php include("cart_fetch.php"); ?>
</div>

</div>

<?php include("assets/footer.php"); ?>