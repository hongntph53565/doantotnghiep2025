new Chart(document.getElementById("theoRapChart"), {
    type: "pie",
    data: {
        labels: ["Mỹ Đình", "Gò Vấp", "Hà Đông"],
        datasets: [
            {
                data: [61.6, 29.4, 8.9],
                backgroundColor: ["#0d6efd", "#198754", "#ffc107"],
            },
        ],
    },
    options: {
        plugins: {
            legend: {
                position: "right",
            },
        },
    },
});

// Doanh thu theo phim
new Chart(document.getElementById("theoPhimChart"), {
    type: "bar",
    data: {
        labels: [
            "Địa Đạo: Mặt Trời...",
            "Người Lữ Trực Quỷ",
            "Tìm Xác: Ma Không Đầu",
            "Trò Tà Kỹ",
            "Nắng Bạch Tuyết",
            "Lạc Trôi",
            "Sát Thủ Vô Cùng Cực Hài",
        ],
        datasets: [
            {
                label: "Doanh thu (₫)",
                data: [
                    4096735, 3500000, 3200000, 2800000, 2200000, 1800000,
                    1200000,
                ],
                backgroundColor: "#0d6efd",
            },
        ],
    },
    options: {
        responsive: true,
        indexAxis: "y",
        scales: {
            x: {
                ticks: {
                    callback: (value) => value.toLocaleString("vi-VN") + " ₫",
                },
            },
        },
        plugins: {
            legend: {
                display: false,
            },
        },
    },
});

// Phương thức thanh toán
new Chart(document.getElementById("ptttChart"), {
    type: "pie",
    data: {
        labels: ["VNPAY", "ZALOPAY"],
        datasets: [
            {
                data: [67.85, 32.2],
                backgroundColor: ["#0d6efd", "#20c997"],
            },
        ],
    },
    options: {
        plugins: {
            legend: {
                position: "right",
            },
        },
    },
});

// Xu hướng theo tháng
new Chart(document.getElementById("xuHuongChart"), {
    type: "line",
    data: {
        labels: ["Mar", "Apr"],
        datasets: [
            {
                label: "Doanh thu (₫)",
                data: [8400000, 10400000],
                fill: true,
                tension: 0.3,
                borderColor: "#0d6efd",
                backgroundColor: "rgba(13,110,253,0.2)",
            },
        ],
    },
    options: {
        responsive: true,
        scales: {
            y: {
                ticks: {
                    callback: (value) => value.toLocaleString("vi-VN") + " ₫",
                },
            },
        },
        plugins: {
            legend: {
                position: "top",
            },
        },
    },
});