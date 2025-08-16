const daysContainer = document.getElementById("datepicker-days");
function getVietnamNow() {
    const vnTimeStr = new Date().toLocaleString("en-US", { timeZone: "Asia/Ho_Chi_Minh" });
    return new Date(vnTimeStr);
}
const now = getVietnamNow();
const today = getVietnamNow();
let currentMonth = today.getMonth();
let currentYear = today.getFullYear();
let selectedDate = today;

const monthNames = [
    "THÁNG 1",
    "THÁNG 2",
    "THÁNG 3",
    "THÁNG 4",
    "THÁNG 5",
    "THÁNG 6",
    "THÁNG 7",
    "THÁNG 8",
    "THÁNG 9",
    "THÁNG 10",
    "THÁNG 11",
    "THÁNG 12",
];

function renderCalendar(month, year) {
    const now = getVietnamNow(); 
    const isCurrentMonth = month === now.getMonth() && year === now.getFullYear();

    document.getElementById("month-label").textContent = monthNames[month];
    document.getElementById("year-label").textContent = year;
    daysContainer.innerHTML = "";

    const firstDay = new Date(year, month, 1).getDay();
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const prevMonthDays = new Date(year, month, 0).getDate();
    const startDay = (firstDay + 6) % 7;

    for (let i = startDay - 1; i >= 0; i--) {
        daysContainer.appendChild(createDayElement(prevMonthDays - i, true));
    }

    let hasSelected = false;
    for (let day = 1; day <= daysInMonth; day++) {
        const thisDate = new Date(year, month, day);
        const isPast = thisDate.setHours(0, 0, 0, 0) < now.setHours(0, 0, 0, 0); 

        const dayEl = createDayElement(day, isPast);

        if (!isPast) {
            dayEl.addEventListener("click", () => {
                document.querySelectorAll(".day.selected").forEach(el => el.classList.remove("selected"));
                selectedDate = thisDate;
                dayEl.classList.add("selected");

                 fetchShowtimesByDate(thisDate);

                const offsetDate = new Date(thisDate.getTime() - thisDate.getTimezoneOffset() * 60000);
                const selectedDateString = offsetDate.toISOString().split("T")[0];

                fetch(`/ajax/showtimes?movie_id=${movieIdGlobal}&date=${selectedDateString}`)
                    .then(res => res.text())
                    .then(html => {
                        document.querySelector(".schedule-box").innerHTML = html;

                        document.querySelectorAll(".showtime-btn").forEach(button => {
                            button.addEventListener("click", function () {
                                const showtimeId = this.getAttribute("data-showtime-id");
                                const url = new URL(window.location.href);
                                url.searchParams.set("showtime_id", showtimeId);
                                window.location.href = url.toString();
                            });
                        });
                    });
            });
        }

        if (isCurrentMonth && day === now.getDate() && !isPast && !hasSelected) {
            dayEl.classList.add("today", "selected");
            selectedDate = thisDate;
            hasSelected = true;
        }

        daysContainer.appendChild(dayEl);
    }

    const remaining = (7 - (daysContainer.children.length % 7)) % 7;
    for (let i = 1; i <= remaining; i++) {
        daysContainer.appendChild(createDayElement(i, true));
    }
}


function createDayElement(day, inactive = false) {
    const el = document.createElement("div");
    el.className = "day" + (inactive ? " inactive" : "");
    el.textContent = day;
    return el;
}

function changeMonth(offset) {
    currentMonth += offset;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    } else if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    renderCalendar(currentMonth, currentYear);
}

const monthPicker = document.getElementById("month-picker");
const yearPicker = document.getElementById("year-picker");
const monthLabel = document.getElementById("month-label");
const yearLabel = document.getElementById("year-label");

monthLabel.addEventListener("click", () => {
    if (monthPicker.classList.contains("hidden")) {
        renderMonthPicker(currentYear);
        monthPicker.classList.remove("hidden");
        yearPicker.classList.add("hidden");
    } else {
        monthPicker.classList.add("hidden");
    }
});

yearLabel.addEventListener("click", () => {
    if (yearPicker.classList.contains("hidden")) {
        renderYearPicker();
        yearPicker.classList.remove("hidden");
        monthPicker.classList.add("hidden");
    } else {
        yearPicker.classList.add("hidden");
    }
});

document.addEventListener("click", (e) => {
    if (!monthPicker.contains(e.target) && !monthLabel.contains(e.target)) {
        monthPicker.classList.add("hidden");
    }
    if (!yearPicker.contains(e.target) && !yearLabel.contains(e.target)) {
        yearPicker.classList.add("hidden");
    }
});

function renderMonthPicker(year) {
    monthPicker.innerHTML = "";
    const now = new Date();

    for (let i = 0; i < 12; i++) {
        const btn = document.createElement("div");
        btn.className = "month-option";
        btn.textContent = "Tháng " + (i + 1);

        const isPast =
            year < now.getFullYear() ||
            (year === now.getFullYear() && i < now.getMonth());

        if (isPast) {
            btn.classList.add("disabled");
        } else {
            btn.addEventListener("click", () => {
                currentMonth = i;
                selectedDate = new Date(year, i, 1);
                renderCalendar(currentMonth, currentYear);
                monthPicker.classList.add("hidden");
            });
        }

        if (i === currentMonth) {
            btn.classList.add("active");
        }

        monthPicker.appendChild(btn);
    }
}

function renderYearPicker() {
    yearPicker.innerHTML = "";
    const now = new Date();
    const startYear = now.getFullYear();
    const endYear = startYear + 10;

    for (let y = startYear; y <= endYear; y++) {
        const btn = document.createElement("div");
        btn.className = "year-option";
        btn.textContent = y;

        btn.addEventListener("click", () => {
            currentYear = y;
            selectedDate = new Date(currentYear, currentMonth, 1);
            renderCalendar(currentMonth, currentYear);
            yearPicker.classList.add("hidden");
        });

        if (y === currentYear) {
            btn.classList.add("active");
        }

        yearPicker.appendChild(btn);
    }
}

window.selectShowtime = function (showtimeId) {
    localStorage.setItem("selectedShowtimeId", showtimeId);
    goToStep(1);
};

window.goToStep = function (step) {
    if (step === 2) {
        const selectedSeats = JSON.parse(sessionStorage.getItem("selectedSeats")) || [];
        if (selectedSeats.length === 0) {
            showToast("Vui lòng chọn ít nhất 1 ghế trước khi tiếp tục!");
            return;
        }
    }

    document.querySelectorAll(".booking-step").forEach(el => el.style.display = "none");
    document.querySelectorAll(".steps .step")?.forEach((el, index) => {
        el.classList.toggle("active", index === step);
    });

    const currentStep = document.getElementById(`step-${step}`);
    if (currentStep) currentStep.style.display = "block";

    const titles = [
        "Bước 1: Chọn thời gian và địa điểm",
        "Bước 2: Chọn ghế",
        "Bước 3: Chọn combo",
        "Bước 4: Thanh toán",
    ];
    const titleEl = document.getElementById("step-title");
    if (titleEl) titleEl.textContent = titles[step] || "";

    localStorage.setItem("currentStep", step);

    if (step === 2) {
        setTimeout(() => {
            if (typeof renderSeatInfo === "function") renderSeatInfo();
            if (typeof updateFoodTotalAndList === "function") updateFoodTotalAndList();
        }, 0);
    }

    if (step === 3) {
        setTimeout(() => {
            if (typeof renderFinalPaymentSummary === "function") renderFinalPaymentSummary();
        }, 0);
    }
};

function showToast(message) {
    const existingToast = document.getElementById("custom-toast");
    if (existingToast) existingToast.remove();

    const toast = document.createElement("div");
    toast.id = "custom-toast";
    toast.style.position = "fixed";
    toast.style.top = "20px"; // chuyển từ bottom lên top
    toast.style.left = "50%";
    toast.style.transform = "translateX(-50%)";
    toast.style.background = "rgba(135, 245, 108, 0.85)";
    toast.style.color = "#000";
    toast.style.padding = "10px 20px";
    toast.style.borderRadius = "8px";
    toast.style.zIndex = "9999";
    toast.style.fontSize = "14px";
    toast.style.boxShadow = "0 4px 8px rgba(0,0,0,0.2)";
    toast.textContent = message;

    document.body.appendChild(toast);

    setTimeout(() => {
        toast.remove();
    }, 3000);
}

function goBackStep() {
    const current = parseInt(localStorage.getItem("currentStep")) || 0;
    if (current > 0) goToStep(current - 1);
}

function renderSeatInfo() {
    const selectedSeats = JSON.parse(sessionStorage.getItem("selectedSeats")) || [];
    const ticketTotal = parseInt(sessionStorage.getItem("ticketTotal")) || 0;
    const seatInfo = document.getElementById("seat-info");

    if (!seatInfo) return;

    if (selectedSeats.length === 0) {
        seatInfo.innerHTML = "Chưa chọn ghế";
        return;
    }

    const seatList = selectedSeats.map(seat => {
        if (seat.type === "couple" && Array.isArray(seat.codes)) {
            return seat.codes.join(" & ");
        } else {
            return seat.code;
        }
    });

    seatInfo.innerHTML = `Ghế đã chọn: ${seatList.join(", ")} <strong style="float:right">${ticketTotal.toLocaleString("vi-VN")} VND</strong>`;
}

function updateFoodTotalAndList() {
    let foodTotal = 0;
    const foodList = [];

    document.querySelectorAll(".combo-item").forEach(combo => {
        const qty = parseInt(combo.querySelector(".number").textContent);
        const price = parseInt(combo.dataset.price);
        const foodId = parseInt(combo.dataset.id); // <- lấy id ở đây
        const name = combo.querySelector(".combo-title")?.textContent.trim();

        if (qty > 0) {
            foodList.push({ food_id: foodId, name, qty, price, total: qty * price }); // <- thêm food_id
            foodTotal += qty * price;
        }
    });

    const ticketTotal = parseInt(sessionStorage.getItem("ticketTotal")) || 0;
    const finalTotal = ticketTotal + foodTotal;

    renderSelectedFoodList(foodList);

    document.getElementById("final-total").textContent = finalTotal.toLocaleString("vi-VN") + " VND";

    sessionStorage.setItem("foodTotal", foodTotal);
    sessionStorage.setItem("finalTotal", finalTotal);
    sessionStorage.setItem("selectedFoods", JSON.stringify(foodList));
}



function renderSelectedFoodList(foodList) {
    const container = document.getElementById("food-selected-list");
    if (!container) return;

    if (foodList.length === 0) {
        container.innerHTML = "<p>Chưa chọn đồ ăn.</p>";
        return;
    }

    container.innerHTML = foodList.map(item => {
        return `
            <div style="display: flex; justify-content: space-between; margin-bottom: 5px;">
                <span>${item.qty} x ${item.name}</span>
                <strong>${item.total.toLocaleString("vi-VN")} VND</strong>
            </div>
        `;
    }).join("");
}


function renderFinalPaymentSummary() {
    const selectedSeats = JSON.parse(sessionStorage.getItem("selectedSeats")) || [];
    const ticketTotal = parseInt(sessionStorage.getItem("ticketTotal")) || 0;
    const foodList = JSON.parse(sessionStorage.getItem("selectedFoods")) || [];
    const foodTotal = parseInt(sessionStorage.getItem("foodTotal")) || 0;
    const finalTotal = parseInt(sessionStorage.getItem("finalTotal")) || (ticketTotal + foodTotal);

    const seatList = selectedSeats.map(seat => {
        if (seat.type === "couple" && Array.isArray(seat.codes)) {
            return seat.codes.join(" & ");
        } else {
            return seat.code;
        }
    });

    let html = "";
    if (seatList.length) {
        html += `Ghế: ${seatList.join(", ")} <strong style="float:right">${ticketTotal.toLocaleString("vi-VN")} VND</strong><br>`;
    }

    foodList.forEach(item => {
        html += `${item.qty} x ${item.name} <strong style="float:right">${item.total.toLocaleString("vi-VN")} VND</strong><br>`;
    });

    const seatInfo = document.getElementById("final-seat-info");
    const totalPayment = document.getElementById("final-total-payment");

    if (seatInfo) seatInfo.innerHTML = html || "Chưa chọn ghế/combo";
    if (totalPayment) totalPayment.innerText = finalTotal.toLocaleString("vi-VN") + " VND";
}


document.addEventListener("DOMContentLoaded", function () {
    const combos = document.querySelectorAll(".combo-item");

    combos.forEach(combo => {
        const plusBtn = combo.querySelector(".plus");
        const minusBtn = combo.querySelector(".minus");
        const quantitySpan = combo.querySelector(".number");

        plusBtn.onclick = () => {
            let qty = parseInt(quantitySpan.textContent);
            qty++;
            quantitySpan.textContent = qty;
            updateFoodTotalAndList();
        };

        minusBtn.onclick = () => {
            let qty = parseInt(quantitySpan.textContent);
            if (qty > 0) qty--;
            quantitySpan.textContent = qty;
            updateFoodTotalAndList();
        };
    });

    const urlParams = new URLSearchParams(window.location.search);
    const fromURL = urlParams.get("showtime_id");

   if (fromURL) {
    localStorage.setItem("selectedShowtimeId", fromURL);
    localStorage.setItem("currentStep", 1);
    setTimeout(() => goToStep(1), 0);  // delay 1 tick
} else {
    localStorage.setItem("currentStep", 0);
    setTimeout(() => goToStep(0), 0);  // delay 1 tick
}

    renderCalendar(currentMonth, currentYear);

    fetchShowtimesByDate(selectedDate);

    renderSeatInfo();
    updateFoodTotalAndList();
     renderFinalPaymentSummary();
});

function fetchShowtimesByDate(dateObj) {
    const offsetDate = new Date(dateObj.getTime() - dateObj.getTimezoneOffset() * 60000);
    const selectedDateString = offsetDate.toISOString().split("T")[0];

    let fetchUrl = "";

    if (typeof calendarMode !== "undefined" && calendarMode === "cinema") {
        fetchUrl = `/ajax-showtimes-by-cinema?cinema_id=${cinemaIdGlobal}&date=${selectedDateString}`;
    } else {
        fetchUrl = `/ajax/showtimes?movie_id=${movieIdGlobal}&date=${selectedDateString}`;
    }

    fetch(fetchUrl)
        .then(res => res.text())
        .then(html => {
            document.querySelector(".schedule-box").innerHTML = html;
            document.querySelectorAll(".showtime-btn").forEach(button => {
                button.addEventListener("click", function () {
                    const showtimeId = this.getAttribute("data-showtime-id");
                    const url = new URL(window.location.href);
                    url.searchParams.set("showtime_id", showtimeId);
                    window.location.href = url.toString();
                });
            });
        });
}









