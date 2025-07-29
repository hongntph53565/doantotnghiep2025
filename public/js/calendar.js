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
    document
        .querySelectorAll(".booking-step")
        .forEach((el) => (el.style.display = "none"));
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
};

function goBackStep() {
    const current = parseInt(localStorage.getItem("currentStep")) || 0;
    if (current > 0) goToStep(current - 1);
}

document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const fromURL = urlParams.get("showtime_id");

    if (fromURL) {
        localStorage.setItem("selectedShowtimeId", fromURL);
        localStorage.setItem("currentStep", 1);
        goToStep(1);
    } else {
        localStorage.setItem("currentStep", 0);
        goToStep(0);
    }

    renderCalendar(currentMonth, currentYear);

    const offsetDate = new Date(selectedDate.getTime() - selectedDate.getTimezoneOffset() * 60000);
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



