@extends('layouts.app') 
@section('title', 'Chi tiết rạp')

@section('content')

  {{-- Header Rạp --}}
 <h5 class="schedule-title mb-4">
  Lịch chiếu phim rạp LumiStar Pham Ngoc Thach tại LumiStar
</h5>

  {{-- Thông tin rạp --}}
  <div class="cinema-box">
    <img src="{{ asset('images/rap1.png') }}" alt="LumiStar Pham Ngoc Thach" />
    <div>
      <h6>LumiStar Pham Ngoc Thach</h6>
      <p class="mb-1 cinema-info">Tầng 36 của TTTM Vincom, số 2 Phạm Ngọc Thạch, Đống Đa, Hà Nội</p>
      <p class="mb-1 cinema-info">Điện thoại: 19002099</p>
      <p class="mb-1 cinema-info">Email: cskh@bhdstar.vn</p>
      <button class="btn btn-outline-success btn-sm mt-1">
        → CHỌN RẠP KHÁC
      </button>
    </div>
  </div>

  {{-- Lịch chiếu + Lịch --}}
  <div class="schedule-section">
    {{-- Lịch chiếu phim --}}
    <div class="schedule-box">
      <div class="d-flex flex-wrap">
        <h6 class="fw-bold w-100">THE STONE: BUỒN THẦN BẤT THÁNH</h6>
        <p class="text-muted mb-3 w-100">LumiStar Pham Ngoc Thach</p>

        {{-- Suất chiếu cứng --}}
        @for ($i = 0; $i < 7; $i++)
          <div class="me-3 mb-3 text-center">
            <div class="showtime-btn">09:20</div>
            <div class="tag">Phụ đề</div>
            <div class="tag green">2D</div>
          </div>
        @endfor
      </div>
    </div>

     {{-- Cột lịch (datepicker) bên phải --}}
      <div class="col-md-3 d-flex justify-content-end">
        <div class="datepicker">
          <div class="datepicker-inner">
            <div class="datepicker-header">
              <div class="arrow" onclick="changeMonth(-1)">&#x276E;</div>
              <div class="month-labels">
                <div class="month-text" id="month-label"></div>
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

