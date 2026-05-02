<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include("db.php");

$user_id = $_SESSION['user_id'] ?? 0;

// SETTINGS
$settings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM settings LIMIT 1"));

// USER
$user = null;
if($user_id){
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE user_id='$user_id'"));
}

// CART COUNT
$count = 0;
if($user_id){
    $c = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) as total FROM cart WHERE user_id='$user_id'"));
    $count = $c['total'];
}
?>

<script src="https://cdn.tailwindcss.com"></script>

<nav class="bg-black/80 backdrop-blur-md text-white sticky top-0 z-50 border-b border-gray-800">

<div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">

    <!-- LOGO -->
    <a href="index.php" class="flex items-center gap-2 text-xl font-bold text-orange-400">
        <?php if(!empty($settings['logo'])){ ?>
            <img src="admin/uploads/<?php echo $settings['logo']; ?>" class="h-9 w-9 rounded">
        <?php } else { ?>
            🍔
        <?php } ?>
        <span><?php echo $settings['site_name'] ?? 'QuickBite'; ?></span>
    </a>

    <!-- SEARCH -->
    <form action="home.php" class="flex-1 mx-10 hidden md:block">
        <div class="relative">
            <input 
                type="text"
                name="search"
                placeholder="Search food or restaurant..."
                class="w-full pl-10 pr-4 py-2 bg-gray-900 border border-gray-700 rounded-full text-white focus:ring-2 focus:ring-orange-400">
            <span class="absolute left-3 top-2.5 text-gray-400">🔍</span>
        </div>
    </form>

    <!-- RIGHT -->
    <div class="flex items-center gap-4">

        <!-- CART -->
        <a href="cart.php" class="relative text-xl">
            🛒
            <?php if($count > 0){ ?>
            <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs px-1 rounded-full">
                <?php echo $count; ?>
            </span>
            <?php } ?>
        </a>

        <!-- USER -->
        <div class="relative hidden md:block">

        <?php if($user_id && $user){ ?>

            <!-- BUTTON -->
            <button onclick="toggleDropdown(event)" class="flex items-center gap-2 cursor-pointer">

                <?php if(!empty($user['image'])){ ?>

                    <!-- USER IMAGE -->
                    <img src="uploads/<?php echo $user['image']; ?>"
                    class="h-9 w-9 rounded-full object-cover border border-gray-600">

                <?php } else { ?>

                    <!-- DEFAULT AVATAR -->
                    <?php
                    $initial = strtoupper(substr($user['name'] ?? 'U', 0, 1));
                    ?>
                    <div class="h-9 w-9 rounded-full bg-orange-500 flex items-center justify-center text-white font-bold">
                        <?php echo $initial; ?>
                    </div>

                <?php } ?>

                <span><?php echo $user['name']; ?></span>
            </button>

            <!-- DROPDOWN -->
            <div id="dropdown" 
            class="hidden absolute right-0 mt-3 bg-white text-black rounded-xl shadow-xl w-44 z-[9999] overflow-hidden border">

                <a href="profile.php" class="block px-4 py-2 hover:bg-gray-100">Profile</a>
                <a href="orders.php" class="block px-4 py-2 hover:bg-gray-100">Orders</a>
                <a href="logout.php" class="block px-4 py-2 text-red-500 hover:bg-gray-100">Logout</a>

            </div>

        <?php } else { ?>

            <!-- LOGIN -->
            <a href="login.php" class="bg-orange-500 px-4 py-1 rounded-full text-sm">
                Login
            </a>

        <?php } ?>

        </div>

        <!-- MOBILE BUTTON -->
        <button onclick="toggleMobile()" class="md:hidden text-2xl">
            ☰
        </button>

    </div>

</div>

<!-- MOBILE MENU -->
<div id="mobileMenu" class="hidden md:hidden bg-black border-t border-gray-800 px-6 py-4 space-y-3">

<?php if($user_id && $user){ ?>

    <p class="font-semibold"><?php echo $user['name']; ?></p>

    <a href="profile.php" class="block">Profile</a>
    <a href="orders.php" class="block">Orders</a>
    <a href="cart.php" class="block">Cart</a>
    <a href="logout.php" class="block text-red-400">Logout</a>

<?php } else { ?>

    <a href="login.php" class="block">Login</a>

<?php } ?>

</div>

</nav>

<!-- JS -->
<script>
let dropdown = document.getElementById("dropdown");

function toggleDropdown(e){
    e.stopPropagation();
    dropdown.classList.toggle("hidden");
}

// prevent closing when clicking inside dropdown
if(dropdown){
    dropdown.addEventListener("click", function(e){
        e.stopPropagation();
    });
}

// close when clicking outside
document.addEventListener("click", function(){
    if(dropdown){
        dropdown.classList.add("hidden");
    }
});

function toggleMobile(){
    document.getElementById("mobileMenu").classList.toggle("hidden");
}
</script>