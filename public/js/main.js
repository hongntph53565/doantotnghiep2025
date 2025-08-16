document.addEventListener("DOMContentLoaded", () => {
    const seats = document.querySelectorAll("img[data-type]");

    seats.forEach((seat) => {
        seat.addEventListener("click", function () {
            const type = this.dataset.type;
            let status = this.dataset.status;

            if (status === "booked") return;

            // Toggle trạng thái
            this.dataset.status =
                status === "available" ? "selected" : "available";

            // Đổi hình
            const filename =
                this.dataset.status === "selected"
                    ? "seat-selected.svg"
                    : `seat-${type}-available.svg`;

            this.src = `images/${filename}`;
        });
    });
});
const toggleBtn = document.getElementById("menu-toggle");
const closeBtn = document.getElementById("close-menu");
const menu = document.querySelector(".menu");

toggleBtn.addEventListener("click", () => {
    menu.classList.toggle("show");
});

closeBtn.addEventListener("click", () => {
    menu.classList.remove("show");
});
