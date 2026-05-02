<!-- Navbar -->
<header class="flex items-center justify-between bg-gradient-to-r from-slate-900 via-slate-800 to-slate-900 text-white px-6 py-4 shadow-lg w-full">

    <!-- LEFT -->
    <div class="flex items-center gap-4">
        <button id="menu-btn" class="text-2xl hover:text-yellow-400">☰</button>
    </div>

    <!-- CENTER -->
    <div class="flex-1 text-center">
        <h1 class="text-xl font-semibold">Dashboard</h1>
    </div>

    <!-- RIGHT -->
    <div class="flex items-center space-x-4">

        <!-- 🔔 Notification -->
        <div class="relative cursor-pointer" id="bellBtn">
            🔔
            <span id="notifCount"
            class="absolute -top-1 -right-1 bg-red-500 text-white text-xs px-1 rounded-full">
            0
            </span>

            <div id="notificationBox"
            class="hidden absolute right-0 mt-3 w-72 bg-white text-black rounded-xl shadow-lg p-4 z-50">

                <h3 class="font-semibold mb-2">Notifications</h3>
                <div id="notifList" class="text-sm space-y-2">Loading...</div>

                <!-- 🔥 VIEW ALL -->
                <a href="notifications.php" class="block text-blue-500 mt-2 text-sm">
                    View All →
                </a>
            </div>
        </div>

        <!-- ⚙️ SETTINGS ICON -->
        <a href="settings.php" class="text-xl hover:text-yellow-400">
            ⚙️
        </a>

        <!-- 👤 PROFILE -->
        <a href="profile.php" class="flex items-center space-x-2 hover:opacity-80">

            <span class="text-gray-200 hidden md:block">
                <?php echo $_SESSION['admin_name'] ?? 'Admin'; ?>
            </span>

            <img src="uploads/<?php echo $_SESSION['admin_image'] ?? 'default.png'; ?>"
                class="w-10 h-10 rounded-full border object-cover"
                onerror="this.src='https://via.placeholder.com/40'">

        </a>

    </div>

</header> 