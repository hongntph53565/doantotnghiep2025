@extends('layouts.staff')

@section('title', 'Staff')


@section('content')
    <br>
    <div class="container-top">
        <h1 class="entry-title text-center fs-3">Bước 1: Chọn thời gian và địa điểm</h1>
        <br><br>
        <div class="card mb-3 rounded-4">
            <div class="row g-0">
                <div class="col-md-2">
                    <img src="{{ asset('storage/' . $movie->poster) }}" class="img" alt="{{ $movie->title }}">
                    {{-- Giả sử poster lưu trong storage --}}
                </div>
                <div class="col-md-10">
                    <div class="card-body">
                        <h5 class="card-title fw-bold fs-5">{{ $movie->title }}</h5>
                        <p class="card-description mb-2">{{ $movie->description }}</p>

                        <div class="text">
                            <p class="card-text mb-2">Đạo diễn: <span
                                    style="color: #3fb83f">{{ $movie->director ?? '' }}</span></p>
                            <p class="card-text mb-2">Diễn viên: <span
                                    style="color: #3fb83f">{{ $movie->cast ?? '' }}</span></p>
                            <p class="card-text mb-2">Thể loại: <span
                                    style="color: #3fb83f">{{ $movie->genre->genre_name ?? '' }}</span></p>
                            <p class="card-text mb-1">
                                Khởi chiếu: {{ \Carbon\Carbon::parse($movie->release_date)->format('d/m/Y') }}
                                | Thời lượng: {{ $movie->duration }} phút
                            </p>
                        </div>

                        <a href="{{ route('staff.list') }}" class="btn-ghost">← CHỌN PHIM KHÁC</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <div class="row">
        <!-- Bên trái: lịch chiếu -->
        <div class="col-md-7">
            <div class="border p-4 rounded-4" id="showtime-container">
                @include('staff.booking.showtimes', [
                    'movie' => $movie,
                    'cinema' => $movie->showtimes->first()?->room->cinema,
                ])
            </div>
        </div>


        <!-- Bên phải: lịch ngày -->
        <div class="col-md-4 p-0 ms-2">
            <div class="datepicker">
                <div class="datepicker-inner">
                    <div class="datepicker-header">
                        <div class="arrow" onclick="changeMonth(-1)">&#x276E;</div>
                        <div class="month-labels">
                            <div class="month-text" id="month-label"></div>
                            <div id="month-picker" class="month-picker hidden"></div>
                            <div id="year-picker" class="year-picker hidden"></div>
                            <div class="year-text" id="year-label"></div>
                        </div>
                        <div class="arrow" onclick="changeMonth(1)">&#x276F;</div>
                    </div>
                    <div class="day-names">
                        <div class="day-name">2</div>
                        <div class="day-name">3</div>
                        <div class="day-name">4</div>
                        <div class="day-name">5</div>
                        <div class="day-name">6</div>
                        <div class="day-name">7</div>
                        <div class="day-name">CN</div>
                    </div>
                    <div class="days" id="datepicker-days"></div>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('styles')
    {{-- <style>
        .col-md-7 {
            width: 825px;
        }

        .datepicker {
            width: 100%;
            border-radius: 16px;
            padding: 15px;
        }

        .datepicker-inner {
            border: 1px solid #2c2c2c;
            border-radius: 12px;
            padding: 10px;
        }

        .datepicker-header {
            display: flex;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 16px;
            color: #2c2c2c;
            gap: 16px;
        }

        .month-labels {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .month-text,
        .year-text {
            padding: 4px 12px;
            font-weight: bold;
            font-size: 15px;
            border-radius: 10px;
        }

        .month-text:hover,
        .year-text:hover {
            background-color: #f5f3ea;
            cursor: pointer;
        }

        .arrow {
            cursor: pointer;
            font-size: 20px;
            user-select: none;
            padding: 6px;
            border-radius: 8px;
            transition: background-color 0.2s;
        }

        .arrow:hover {
            background-color: #ddd5bb;
        }

        .day-names,
        .days,
        .date-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            text-align: center;
        }

        .day-name {
            font-weight: bold;
            padding: 4px;
            font-size: 13px;
            color: #333;
        }

        .day,
        .date-grid div {
            padding: 6px;
            border-radius: 6px;
            background: white;
            font-size: 14px;
            color: #333;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .day:hover {
            background-color: #dcd3b6;
        }

        .inactive {
            color: #c5c2bd;
            pointer-events: none;
        }

        .selected {
            background-color: #444b5a;
            color: white;
        }

        .today {
            border: 2px solid #444b5a;
            border-radius: 8px;
            background: #005189 !important;
            color: white;
        }

        /* ====== Month/Year Picker ====== */
        #month-picker,
        #year-picker {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            position: absolute;
            z-index: 100;
        }

        #month-picker.hidden,
        #year-picker.hidden {
            display: none;
        }

        .month-option,
        .year-option {
            padding: 8px 12px;
            background: #f5f5f5;
            text-align: center;
            border-radius: 6px;
            font-weight: 500;
            transition: background 0.3s;
        }

        .month-option:not(.disabled),
        .year-option {
            cursor: pointer;
        }

        .month-option:hover,
        .year-option:hover {
            background: #dbeafe;
        }

        .month-option.disabled {
            background: #eee;
            color: #aaa;
            cursor: not-allowed !important;
            opacity: 0.6;
        }

        .month-option.disabled:hover {
            background: #eee;
        }

        .month-option.selected,
        .year-option.active {
            background: #334155;
            color: white;
        }
    </style> --}}
    <style>
        .col-md-7 {
            width: 825px;
        }

        .datepicker {
            background-color: #eae2cc;
            width: 100%;
            max-width: 420px;
            border-radius: 16px;
            padding: 14px 14px 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
        }

        .datepicker-inner {
            border: 2px solid #d5ccb5;
            border-radius: 12px;
            padding: 12px;
        }

        /* Tiêu đề chọn tháng/năm */
        .datepicker-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
            margin-bottom: 12px;
            padding: 0 6px;
            font-size: 16px;
            color: #2c2c2c;
        }

        .month-labels {
            display: flex;
            gap: 6px;
            align-items: center;
        }

        .month-text,
        .year-text {
            padding: 4px 12px;
            font-weight: bold;
            font-size: 15px;
            border-radius: 10px;
        }

        .month-text:hover,
        .year-text:hover {
            background-color: #f5f3ea;
            cursor: pointer;
        }

        .year-text {
            margin-left: 30px;
        }

        .arrow {
            cursor: pointer;
            font-size: 20px;
            user-select: none;
            padding: 6px;
            border-radius: 8px;
            transition: background-color 0.2s;
        }

        .arrow:hover {
            background-color: #ddd5bb;
        }

        /* Lưới ngày */
        .day-names,
        .days,
        .date-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 6px;
            text-align: center;
            font-weight: 500;
        }

        .day-name {
            font-weight: bold;
            padding: 4px;
            font-size: 13px;
            color: #333;
        }

        .day,
        .date-grid div {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 36px;
            padding: 6px;
            border-radius: 6px;
            background: white;
            font-size: 14px;
            color: #333;
            cursor: pointer;
            transition: background-color 0.2s, border 0.2s;
            box-sizing: border-box;
            /* 👈 chống nở khi thêm border */
        }

        .day:hover {
            background-color: #dcd3b6;
        }

        .inactive {
            color: #c5c2bd;
            pointer-events: none;
        }

        .selected {
            background-color: #444b5a;
            color: white;
            border: 2px solid #444b5a;
        }

        /* Hôm nay không được chọn */
        .day.today {
            border: 2px solid #444b5a;
            background-color: transparent !important;
            color: #333;
        }

        /* Hôm nay + được chọn */
        .day.today.selected {
            background-color: #444b5a !important;
            color: white;
            border: 2px solid #444b5a;
            /* ✅ giữ nguyên border */
        }


        /* ====== Month/Year Picker ====== */
        #month-picker,
        #year-picker {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            background: #fff;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
            position: absolute;
            z-index: 100;
        }

        #month-picker.hidden,
        #year-picker.hidden {
            display: none;
        }

        .month-option,
        .year-option {
            padding: 8px 12px;
            background: #f5f5f5;
            text-align: center;
            border-radius: 6px;
            font-weight: 500;
            transition: background 0.3s;
        }

        .month-option:not(.disabled),
        .year-option {
            cursor: pointer;
        }

        .month-option:hover,
        .year-option:hover {
            background: #dbeafe;
        }

        .month-option.disabled {
            background: #eee;
            color: #aaa;
            cursor: not-allowed !important;
            opacity: 0.6;
        }

        .month-option.disabled:hover {
            background: #eee;
        }

        .month-option.selected,
        .year-option.active {
            background: #334155;
            color: white;
        }
    </style>

    <style>
        .btn-checkout {
            display: block;
            background: linear-gradient(to top, #99dc3c, #3fb83f);
            padding: 10px;
            text-align: center;
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            border-radius: 12px;
            margin-top: 10px;
            text-decoration: none;
        }

        .btn-checkout:hover {
            background: linear-gradient(to top, #3fb83f, #3fb83f);
        }

        .btn-back-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 16px;
        }

        .btn-back {
            color: #8bc34a;
            text-decoration: none;
            font-size: 16px;
        }

        .col-md-4 {
            border: 1px solid #ddd;
            border-radius: 20px;
            padding: 20px 20px 0px 20px;
            background-color: #fff;
            height: auto;
        }

        .col-md-4 h3 {
            margin: 0 0 10px;
        }

        .col-md-4.title {
            font-weight: bold;
            font-size: 18px;
        }

        .btn-ghost {
            margin-top: 30px;
            display: inline-block;
            color: #67B72F;
            /* Màu xanh lá */
            border: 1px solid #67B72F;
            /* Viền xanh */
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 600;
            text-transform: uppercase;
            text-decoration: none;
            font-family: 'Arial', sans-serif;
            font-size: 15px;
            transition: 0.2s ease;
        }

        .btn-ghost:hover {
            background-color: #67B72F;
            color: #fff;
        }

        .col-md-2 img {
            width: 100%;
            padding: 20px;
            border-radius: 30px;
        }

        .legend {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px;
            margin-top: 20px;
        }

        .legend-row {
            display: flex;
            gap: 50px;
            justify-content: center;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #ccc;
            font-size: 14px;
        }

        .legend-item img {
            width: 30px;
            height: 30px;
        }

        .seat table {
            margin: 0 auto;
            margin-top: 30px;
            border-collapse: collapse;
        }

        .seat td {
            padding: 4px;
            text-align: center;
        }

        .seat img {
            width: 30px;
            height: 30px;
            cursor: pointer;
            transition: transform 0.2s ease, filter 0.2s ease;
        }


        /* Trạng thái ghế được chọn */
        .seat img.selected {
            filter: sepia(100%) hue-rotate(180deg) saturate(200%);
        }

        /* Ghế đã đặt (ví dụ nếu muốn hiển thị màu xám) */
        .seat img.booked {
            opacity: 0.4;
            cursor: not-allowed;
            filter: grayscale(100%);
        }

        /* Label trái/phải */
        .seat .lable {
            font-weight: bold;
            padding: 0 8px;
            vertical-align: middle;
        }

        .seat .couple {
            display: flex;
        }

        /* Ô chứa ghế đôi */
        td[colspan="2"] {
            text-align: center;
            padding: 8px;
        }
    </style>
@endpush
@push('scripts')
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        const daysContainer = document.getElementById("datepicker-days");
        const today = new Date();
        let currentMonth = today.getMonth();
        let currentYear = today.getFullYear();
        let selectedDate = today;

        const monthNames = [
            "THÁNG 1", "THÁNG 2", "THÁNG 3", "THÁNG 4", "THÁNG 5", "THÁNG 6",
            "THÁNG 7", "THÁNG 8", "THÁNG 9", "THÁNG 10", "THÁNG 11", "THÁNG 12"
        ];
        let selectedDateFromServer = "{{ $selectedDate }}";

        function renderCalendar(month, year) {
            const now = new Date();
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
                const isPast =
                    year < now.getFullYear() ||
                    (year === now.getFullYear() && month < now.getMonth()) ||
                    (year === now.getFullYear() && month === now.getMonth() && day < now.getDate());

                const dayEl = createDayElement(day, isPast);
                if (!isPast) {
                    dayEl.addEventListener("click", () => {
                        document.querySelectorAll(".day.selected").forEach(el => el.classList.remove("selected"));

                        selectedDate = thisDate;
                        dayEl.classList.add("selected");

                        console.log("Ngày đã chọn:", selectedDate.toLocaleDateString("vi-VN"));
                        fetchShowtimesForDate(selectedDate); // GỌI AJAX TẠI ĐÂY
                    });

                }
                if (
                    isCurrentMonth &&
                    day === now.getDate() &&
                    !isPast &&
                    !hasSelected
                ) {
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

        function renderMonthPicker(year) {
            monthPicker.innerHTML = "";
            const now = new Date();

            for (let i = 0; i < 12; i++) {
                const btn = document.createElement("div");
                btn.className = "month-option";
                btn.textContent = "Tháng " + (i + 1);

                const isPast = year < now.getFullYear() || (year === now.getFullYear() && i < now.getMonth());

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

        // Sự kiện nhấn vào tháng
        monthLabel.addEventListener("click", () => {
            if (monthPicker.classList.contains("hidden")) {
                renderMonthPicker(currentYear);
                monthPicker.classList.remove("hidden");
                yearPicker.classList.add("hidden");
            } else {
                monthPicker.classList.add("hidden");
            }
        });

        // Sự kiện nhấn vào năm
        yearLabel.addEventListener("click", () => {
            if (yearPicker.classList.contains("hidden")) {
                renderYearPicker();
                yearPicker.classList.remove("hidden");
                monthPicker.classList.add("hidden");
            } else {
                yearPicker.classList.add("hidden");
            }
        });

        // Ẩn picker nếu click ra ngoài
        document.addEventListener("click", (e) => {
            if (!monthPicker.contains(e.target) && !monthLabel.contains(e.target)) {
                monthPicker.classList.add("hidden");
            }
            if (!yearPicker.contains(e.target) && !yearLabel.contains(e.target)) {
                yearPicker.classList.add("hidden");
            }
        });

        renderCalendar(currentMonth, currentYear);
    </script>
    <script>
        function formatDateToYMD(date) {
            const yyyy = date.getFullYear();
            const mm = String(date.getMonth() + 1).padStart(2, '0');
            const dd = String(date.getDate()).padStart(2, '0');
            return `${yyyy}-${mm}-${dd}`;
        }

        function fetchShowtimesForDate(date) {
            const formattedDate = formatDateToYMD(date);
            const movieId = {{ $movie->movie_id }};

            fetch(`/staff/bookings/${movieId}/showtimes-by-date?date=${formattedDate}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('showtime-container').innerHTML = html;
                })
                .catch(error => {
                    console.error("Lỗi khi lấy suất chiếu:", error);
                    document.getElementById('showtime-container').innerHTML =
                        "<p class='text-danger'>Không thể tải suất chiếu.</p>";
                });
        }
    </script>
@endpush
