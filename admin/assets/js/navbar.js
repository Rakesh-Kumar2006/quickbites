document.addEventListener("DOMContentLoaded", function () {

    let lastCount = 0;
    let soundEnabled = false;

    const bellBtn = document.getElementById("bellBtn");
    const box = document.getElementById("notificationBox");
    const list = document.getElementById("notifList");
    const countEl = document.getElementById("notifCount");
    const sound = document.getElementById("sound");

    if (!bellBtn || !box) return;

    // Enable sound after first click
    document.addEventListener("click", () => {
        soundEnabled = true;
    }, { once: true });

    // 🔔 Toggle dropdown
    bellBtn.addEventListener("click", function (e) {
        e.stopPropagation();
        box.classList.toggle("hidden");
    });

    // Prevent closing when clicking inside
    box.addEventListener("click", function (e) {
        e.stopPropagation();
    });

    // Close on outside click
    document.addEventListener("click", function (e) {
        if (!bellBtn.contains(e.target) && !box.contains(e.target)) {
            box.classList.add("hidden");
        }
    });

    // 🔄 Load notifications
    function loadNotifications() {

        fetch("fetch_notifications.php")
            .then(res => res.json())
            .then(data => {

                let html = "";
                let unread = 0;

                data.forEach(n => {
                    if (n.status === 'unread') unread++;

                    html += `
                    <div class="p-2 border-b ${n.status === 'unread' ? 'bg-yellow-100' : ''}">
                        ${n.message}
                    </div>`;
                });

                countEl.innerText = unread;

                if (box.classList.contains("hidden")) {
                    list.innerHTML = html || "No notifications";
                }

                if (unread > lastCount && soundEnabled) {
                    sound.play().catch(() => {});
                }

                lastCount = unread;
            });
    }

    setInterval(loadNotifications, 3000);
    loadNotifications();

});

// Mark all read
function markAllRead() {
    fetch("mark_read.php").then(() => {
        document.getElementById("notifCount").innerText = 0;
    });
}