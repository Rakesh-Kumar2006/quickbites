<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("db.php");

$user_id = $_SESSION['user_id'] ?? 0;

// SETTINGS
$settings = mysqli_fetch_assoc(mysqli_query($conn,
"SELECT * FROM settings LIMIT 1"
));

// USER
$user = null;

if($user_id){

    $user = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT * FROM users WHERE user_id='$user_id'"
    ));
}

// CART COUNT
$count = 0;

if($user_id){

    $c = mysqli_fetch_assoc(mysqli_query($conn,
    "SELECT COUNT(*) as total FROM cart WHERE user_id='$user_id'"
    ));

    $count = $c['total'];
}
?>

<script src="https://cdn.tailwindcss.com"></script>

<!-- NAVBAR -->
<nav class="bg-black/80 backdrop-blur-md text-white sticky top-0 z-50 border-b border-gray-800 shadow-lg">

<div class="max-w-7xl mx-auto px-6 py-3 flex items-center justify-between">

    <!-- LOGO -->
    <a href="home.php"
    class="flex items-center gap-3 text-2xl font-extrabold text-orange-400">

        <?php if(!empty($settings['logo'])){ ?>

            <img src="admin/uploads/<?php echo $settings['logo']; ?>"
            class="h-10 w-10 rounded-xl object-cover shadow">

        <?php } else { ?>

            🍔

        <?php } ?>

        <span>
            <?php echo $settings['site_name'] ?? 'QuickBites'; ?>
        </span>

    </a>

    <!-- SEARCH -->
    <form action="home.php"
    class="flex-1 mx-10 hidden lg:block">

        <div class="relative">

            <input
                type="text"
                name="search"
                placeholder="Search food, restaurants..."
                class="w-full pl-12 pr-4 py-3 bg-gray-900 border border-gray-700 rounded-full text-white focus:ring-2 focus:ring-orange-400 outline-none transition">

            <span class="absolute left-4 top-3 text-gray-400 text-lg">
                🔍
            </span>

        </div>

    </form>

    <!-- RIGHT -->
    <div class="flex items-center gap-5">

        <!-- CART -->
        <a href="cart.php"
        class="relative text-2xl hover:scale-110 transition">

            🛒

            <?php if($count > 0){ ?>

            <span class="absolute -top-2 -right-3 bg-red-500 text-white text-xs px-2 py-0.5 rounded-full font-bold shadow">

                <?php echo $count; ?>

            </span>

            <?php } ?>

        </a>

        <!-- USER -->
        <div class="relative hidden md:block">

        <?php if($user_id && $user){ ?>

            <!-- BUTTON -->
            <button onclick="toggleDropdown(event)"
            class="flex items-center gap-3 bg-gray-900 hover:bg-gray-800 px-3 py-2 rounded-2xl transition">

                <?php if(!empty($user['image'])){ ?>

                    <!-- IMAGE -->
                    <img src="uploads/<?php echo $user['image']; ?>"
                    class="h-10 w-10 rounded-full object-cover border-2 border-orange-400 shadow">

                <?php } else { ?>

                    <!-- DEFAULT -->
                    <?php
                    $initial = strtoupper(substr($user['name'] ?? 'U', 0, 1));
                    ?>

                    <div class="h-10 w-10 rounded-full bg-orange-500 flex items-center justify-center text-white font-bold shadow">

                        <?php echo $initial; ?>

                    </div>

                <?php } ?>

                <div class="text-left">

                    <p class="font-semibold text-sm">
                        <?php echo $user['name']; ?>
                    </p>

                    <p class="text-xs text-gray-400">
                        My Account
                    </p>

                </div>

            </button>

            <!-- DROPDOWN -->
            <div id="dropdown"
            class="hidden absolute right-0 mt-4 bg-white text-black rounded-2xl shadow-2xl w-56 overflow-hidden border z-[9999]">

                <a href="profile.php"
                class="block px-5 py-3 hover:bg-gray-100 transition">

                    👤 Profile

                </a>

                <a href="orders.php"
                class="block px-5 py-3 hover:bg-gray-100 transition">

                    📦 Orders

                </a>

                <a href="payment_history.php"
                class="block px-5 py-3 hover:bg-gray-100 transition">

                    💳 Payments

                </a>

                <a href="reviews.php"
                class="block px-5 py-3 hover:bg-gray-100 transition">

                    ⭐ Reviews

                </a>

                <a href="complaint.php"
                class="block px-5 py-3 hover:bg-gray-100 transition">

                    ⚠️ Complaints

                </a>

                <a href="contact.php"
                class="block px-5 py-3 hover:bg-gray-100 transition">

                    📞 Contact Us

                </a>

                <a href="cart.php"
                class="block px-5 py-3 hover:bg-gray-100 transition">

                    🛒 Cart

                </a>

                <a href="logout.php"
                class="block px-5 py-3 text-red-500 hover:bg-red-50 transition font-semibold">

                    🚪 Logout

                </a>

            </div>

        <?php } else { ?>

            <!-- LOGIN -->
            <a href="login.php"
            class="bg-orange-500 hover:bg-orange-600 px-5 py-2 rounded-full text-sm font-bold transition shadow-lg">

                Login

            </a>

        <?php } ?>

        </div>

        <!-- MOBILE BUTTON -->
        <button onclick="toggleMobile()"
        class="md:hidden text-3xl hover:text-orange-400 transition">

            ☰

        </button>

    </div>

</div>

<!-- MOBILE MENU -->
<div id="mobileMenu"
class="hidden md:hidden bg-black border-t border-gray-800 px-6 py-5 space-y-4 text-white">

<?php if($user_id && $user){ ?>

    <div class="flex items-center gap-3 mb-4">

        <?php if(!empty($user['image'])){ ?>

            <img src="uploads/<?php echo $user['image']; ?>"
            class="h-12 w-12 rounded-full object-cover border-2 border-orange-400">

        <?php } else { ?>

            <?php
            $initial = strtoupper(substr($user['name'] ?? 'U', 0, 1));
            ?>

            <div class="h-12 w-12 rounded-full bg-orange-500 flex items-center justify-center text-white font-bold">

                <?php echo $initial; ?>

            </div>

        <?php } ?>

        <div>

            <p class="font-bold">
                <?php echo $user['name']; ?>
            </p>

            <p class="text-sm text-gray-400">
                Welcome Back
            </p>

        </div>

    </div>

    <a href="home.php"
    class="block hover:text-orange-400 transition">

        🏠 Home

    </a>

    <a href="profile.php"
    class="block hover:text-orange-400 transition">

        👤 Profile

    </a>

    <a href="orders.php"
    class="block hover:text-orange-400 transition">

        📦 Orders

    </a>

    <a href="payment_history.php"
    class="block hover:text-orange-400 transition">

        💳 Payments

    </a>

    <a href="reviews.php"
    class="block hover:text-orange-400 transition">

        ⭐ Reviews

    </a>

    <a href="complaint.php"
    class="block hover:text-orange-400 transition">

        ⚠️ Complaints

    </a>

    <a href="contact.php"
    class="block hover:text-orange-400 transition">

        📞 Contact Us

    </a>

    <a href="cart.php"
    class="block hover:text-orange-400 transition">

        🛒 Cart

    </a>

    <a href="logout.php"
    class="block text-red-400 hover:text-red-500 transition">

        🚪 Logout

    </a>

<?php } else { ?>

    <a href="login.php"
    class="block hover:text-orange-400 transition">

        Login

    </a>

<?php } ?>

</div>

</nav>

<!-- JS -->
<script>

let dropdown = document.getElementById("dropdown");

// DROPDOWN
function toggleDropdown(e){

    e.stopPropagation();

    dropdown.classList.toggle("hidden");
}

// INSIDE CLICK
if(dropdown){

    dropdown.addEventListener("click", function(e){

        e.stopPropagation();

    });
}

// OUTSIDE CLICK
document.addEventListener("click", function(){

    if(dropdown){

        dropdown.classList.add("hidden");
    }
});

// MOBILE MENU
function toggleMobile(){

    document.getElementById("mobileMenu")
    .classList.toggle("hidden");
}

</script>