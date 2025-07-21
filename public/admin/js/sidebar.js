function toggleSidebar() {
    const sidebar = document.getElementById("sidebar");
    sidebar.classList.toggle("collapsed");
}

// 1. Fullscreen toggle
function toggleFullscreen() {
    if (!document.fullscreenElement) {
        document.documentElement.requestFullscreen().catch((err) => {
            console.log(
                `Error attempting to enable fullscreen: ${err.message}`
            );
        });
    } else {
        document.exitFullscreen();
    }
}

// 2. QR Scanner (placeholder)
function showQRScanner() {
    alert("Chức năng quét QR Code sẽ được tích hợp sau");
}

// 3. Toggle theme
function toggleTheme() {
    document.body.classList.toggle("dark-theme");
    const icon = document.getElementById("theme-icon");
    icon.classList.toggle("bi-moon");
    icon.classList.toggle("bi-sun");
}