{{-- resources/views/booking1.blade.php --}}
@extends('layouts.app')

@section('title', 'Đặt vé - Bước 1')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/staff_booking1.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('js/calendar.js') }}"></script>
@endpush


@section('content')
  {{-- Các bước đặt vé --}}
  <section class="booking-steps">
    <div class="steps-container">
      <div class="steps">
        <span class="step active">01</span>
        <span class="step">02</span>
        <span class="step">03</span>
        <span class="step">04</span>
      </div>
    </div>
  </section>

  {{-- Tiêu đề bước --}}
  <div class="step-title text-center mt-4">
    <h4><strong>Bước 1: Chọn thời gian và địa điểm</strong></h4>
  </div>

  {{-- Thông tin phim --}}
  <div class="cinema-box container">
    <img src="{{ asset('images/doraemon.jpg') }}" alt="DORAEMON: NOBITA'S ART WORLD TALES" />
    <div>
      <h6>DORAEMON: NOBITA'S ART WORLD TALES</h6>
      <p class="mb-1 cinema-info">
        Thế giới trong lễ các châu Âu thú trung cổ được mở ra từ trong các bức tranh. Doraemon và những người bạn cùng Claire bắt đầu một cuộc phiêu lưu tuyệt vời.
      </p>
      <p class="mb-1 cinema-info"><strong>Đạo diễn:</strong> Yukiyo Teramoto</p>
      <p class="mb-1 cinema-info"><strong>Diễn viên:</strong> Megumi Ohara, Wasabi Mizuta</p>
      <p class="mb-1 cinema-info"><strong>Thể loại:</strong> Family</p>
      <p class="mb-1 cinema-info"><strong>Khởi chiếu:</strong> 23/05/2025 | Thời lượng: 105 phút</p>
      <a href="" class="btn btn-outline-success btn-sm mt-1">→ CHỌN PHIM KHÁC</a>
    </div>
  </div>

  {{-- Lịch chiếu + lịch ngày --}}
    <div class="container mb-5">
      <div class="cinema-box "> 
        <div class="row">
            {{-- Cột Lịch chiếu bên trái --}}
            <div class="col-md-9">
                <div class="schedule-box">
                    <h6 class="fw-bold">LumiStar The Garden</h6>
                    <p class="text-muted">Tầng 4 & 5, TTTM The Garden, khu đô thị The Manor, đường Mễ Trì, phường Mỹ Đình 1,
                        quận Nam Từ Liêm, Hà Nội</p>
                    <div class="d-flex flex-wrap">
                        @for ($i = 0; $i < 6; $i++)
                            <div class="me-3 mb-3 text-center">
                                <div class="showtime-btn">09:20</div>
                                <div class="badge-format format-2d">2D</div>
                                <div class="badge-format subtitle">Phụ đề</div>
                            </div>
                        @endfor
                    </div>

                    <h6 class="fw-bold mt-4">LumiStar Phạm Ngọc Thạch</h6>
                    <p class="text-muted">Tầng 8, TTTM Vincom, số 2 Phạm Ngọc Thạch, Đống Đa, Hà Nội</p>
                    <div class="d-flex flex-wrap">
                        @for ($i = 0; $i < 3; $i++)
                            <div class="me-3 mb-3 text-center">
                                <div class="showtime-btn">09:20</div>
                                <div class="badge-format format-2d">2D</div>
                                <div class="badge-format subtitle">Phụ đề</div>
                            </div>
                        @endfor
                    </div>
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
        </div>
    </div>
@endsection

