@extends('layouts.staff')
@section('title', 'Đặt vé')

@section('content')
<link rel="stylesheet" href="{{ asset('css/booking1.css') }}">

<div class="container py-4">
  {{-- THÔNG TIN PHIM --}}
  <div class="row mb-4 bg-light p-4 rounded shadow-sm">
    <div class="col-md-4 text-center">
      <img src="{{ $movie->poster }}" alt="{{ $movie->title }}" class="img-fluid rounded shadow" style="max-height: 420px;">
    </div>
    <div class="col-md-8">
      <h3 class="text-success fw-bold">{{ strtoupper($movie->title) }}</h3>
      <p class="text-muted">{{ $movie->description }}</p>
      <p><strong>Phân loại:</strong> <span class="badge bg-danger">K</span> <small>Phim dành cho khán giả dưới 13 tuổi có người giám hộ</small></p>
      <p><strong>Định dạng:</strong> <span class="badge bg-success">2D</span></p>
      <p><strong>Đạo diễn:</strong> {{ $movie->director }}</p>
      <p><strong>Diễn viên:</strong> {{ $movie->cast }}</p>
      <p><strong>Thể loại:</strong> {{ $movie->genre->genre_name ?? 'Không rõ' }}</p>
      <p><strong>Khởi chiếu:</strong> {{ \Carbon\Carbon::parse($movie->release_date)->format('d/m/Y') }}</p>
      <p><strong>Thời lượng:</strong> {{ $movie->duration }} phút</p>
      <p><strong>Ngôn ngữ:</strong> Phụ đề</p>
      <a href="{{ route('staff.nowShowing') }}" class="btn btn-outline-primary btn-sm mt-2">🎮 Chọn phim khác</a>
    </div>
  </div>

  {{-- LỊCH CHIẾU + LỊCH NGÀY --}}
  <div class="row">
    {{-- CỘT TRÁI: DANH SÁCH SUẤT CHIẾU --}}
    <div class="col-md-8">
     <h4 class="mb-4 fw-semibold text-dark" style="font-size: 1.5rem;">
  <span class="text-muted">Lịch chiếu phim:</span>
  <span class="text-primary" style="font-weight: 600;">{{ $movie->title }}</span>
</h4>
      @php $hasShowtime = false; @endphp

      @foreach ($cinemas as $cinema)
        @php
          $showtimes = collect();
          foreach ($cinema->rooms as $room) {
            $showtimes = $showtimes->merge($room->showtimes);
          }
          $showtimes = $showtimes->sortBy('start_time');
        @endphp

        @if ($showtimes->isNotEmpty())
          @php $hasShowtime = true; @endphp
          <div class="mb-4 p-3 bg-light border rounded shadow-sm">
            <h5 class="text-success fw-bold mb-1">{{ $cinema->name }}</h5>
            <p class="text-muted">{{ $cinema->address }}</p>

            <div class="d-flex flex-wrap gap-3">
              @foreach ($showtimes as $showtime)
                <div class="text-center">
                  <a href="{{ route('staff.booking2', ['showtime_id' => $showtime->showtime_id]) }}" class="btn btn-dark fw-bold px-4 py-2">
                    {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}
                  </a>
                  <div class="mt-1">
                    <span class="badge bg-warning text-dark">Phụ đề</span>
                    <span class="badge bg-success">2D</span>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        @endif
      @endforeach

      @if (!$hasShowtime)
        <div class="alert alert-warning text-center fw-bold mt-4">
          Không có suất chiếu vào ngày này!
        </div>
      @endif
    </div>

    {{-- CỘT PHẢI: LỊCH THÁNG --}}
    <div class="col-md-4">
      <div class="bg-light p-3 border rounded shadow-sm text-center">
  <div class="d-flex justify-content-between align-items-center mb-2">
    <button class="btn btn-sm btn-outline-secondary" onclick="changeMonth(-1)">❮</button>
    <div>
      <span id="month-label" class="fw-bold fs-5" style="cursor: pointer;"></span>
      <span id="year-label" class="fw-bold fs-5 ms-1" style="cursor: pointer;"></span>
    </div>
    <button class="btn btn-sm btn-outline-secondary" onclick="changeMonth(1)">❯</button>
  </div>

  <!-- Picker ẩn hiện khi click vào tháng/năm -->
  <div id="month-picker" class="border rounded p-2 mb-2 d-none bg-white" style="z-index: 10; position: absolute;"></div>
  <div id="year-picker" class="border rounded p-2 mb-2 d-none bg-white" style="z-index: 10; position: absolute;"></div>

  <div class="d-grid" style="grid-template-columns: repeat(7, 1fr); gap: 4px;">
    <div class="fw-bold">T2</div><div class="fw-bold">T3</div><div class="fw-bold">T4</div>
    <div class="fw-bold">T5</div><div class="fw-bold">T6</div><div class="fw-bold">T7</div><div class="fw-bold">CN</div>
  </div>

  <div id="datepicker-days" class="d-grid mt-2" style="grid-template-columns: repeat(7, 1fr); gap: 4px;"></div>
</div>

    </div>
  </div>
</div>


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
        selectedDate = thisDate;
        const formatted = selectedDate.toISOString().split("T")[0];
        window.location.href = `?date=${formatted}`;
      });
    }

    

    if (
      selectedDate.getFullYear() === year &&
      selectedDate.getMonth() === month &&
      selectedDate.getDate() === day
    ) {
      dayEl.classList.add("today", "selected");
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

// Lấy ngày từ URL nếu có
const urlParams = new URLSearchParams(window.location.search);
const requestDate = urlParams.get("date");
if (requestDate) {
  const parts = requestDate.split("-");
  currentYear = parseInt(parts[0]);
  currentMonth = parseInt(parts[1]) - 1;
  selectedDate = new Date(currentYear, currentMonth, parseInt(parts[2]));
}

renderCalendar(currentMonth, currentYear);
      
</script>
@endsection
