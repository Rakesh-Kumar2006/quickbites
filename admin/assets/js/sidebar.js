document.addEventListener("DOMContentLoaded", function () {

const menuBtn = document.getElementById("menu-btn");
const sidebar = document.getElementById("sidebar");
const overlay = document.getElementById("overlay");
const mainContent = document.getElementById("mainContent");
const menuText = document.querySelectorAll(".menu-text");
const logoText = document.getElementById("logoText");
const profileName = document.getElementById("profileName");
const navbar = document.getElementById("navbar");
// MENU CLICK
if (menuBtn) {
    menuBtn.addEventListener("click", () => {

        // 📱 MOBILE
        if (window.innerWidth < 768) {
            if (sidebar && overlay) {
                sidebar.classList.toggle("-translate-x-full");
                overlay.classList.toggle("hidden");
            }
        }

        // 💻 DESKTOP
        else {
            if (!sidebar) return;

            // 🔥 AUTO DETECT STATE (IMPORTANT FIX)
            let isCollapsed = sidebar.classList.contains("w-20");

            if (!isCollapsed) {
                // 👉 COLLAPSE
                sidebar.classList.remove("w-64");
                sidebar.classList.add("w-20");

                if (mainContent) {
                    mainContent.classList.remove("md:ml-64");
                    mainContent.classList.add("md:ml-20");
                }

                menuText.forEach(el => el.classList.add("hidden"));
                if (logoText) logoText.classList.add("hidden");
                if (profileName) profileName.classList.remove("hidden");

            } else {
                // 👉 EXPAND
                sidebar.classList.remove("w-20");
                sidebar.classList.add("w-64");

                if (mainContent) {
                    mainContent.classList.remove("md:ml-20");
                    mainContent.classList.add("md:ml-64");
                }

                menuText.forEach(el => el.classList.remove("hidden"));
                if (logoText) logoText.classList.remove("hidden");
                if (profileName) profileName.classList.add("hidden");
            }
        }
    });
}

// OVERLAY CLOSE
if (overlay) {
    overlay.addEventListener("click", () => {
        if (sidebar) sidebar.classList.add("-translate-x-full");
        overlay.classList.add("hidden");
    });
}

});