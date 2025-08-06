@extends('layouts.staff')

@section('title', 'Staff')


@push('scripts')
    <script src="{{ asset('js/calendar.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/MovieDetails.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ChooseSeat.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ChooseFood.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Payment.css') }}">
@endpush


@section('content')

    <div class="container mt-4">
        <h1 id="step-title" class="entry-title text-center text-dark mb-4">
            Bước 1: Chọn thời gian và địa điểm
        </h1>
        <div class="cinema-box">
            <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" width="200" />
            <div>
                <h6 class="movie-title">{{ $movie->title }}</h6>
                <p class="mb-1 cinema-info">{{ $movie->description }}</p>


                <p class="mb-1 cinema-info"><strong>Đạo diễn:</strong><span> {{ $movie->director ?? '' }}</span></p>
                <p class="mb-1 cinema-info"><strong>Diễn viên:</strong><span> {{ $movie->cast ?? '' }}</span></p>
                <p class="mb-1 cinema-info"><strong>Thể loại:</strong><span>  {{ $movie->genre->genre_name ?? 'Không rõ' }}</span></p>
                <p class="mb-1 cinema-info"><strong>Khởi chiếu:</strong>
                    {{ \Carbon\Carbon::parse($movie->release_date)->format('d/m/Y') }} |
                    <strong>Thời lượng:</strong> {{ $movie->duration }} phút
                </p>
                {{-- <p class="mb-1 cinema-info"><strong>Ngôn ngữ:</strong> {{ $movie->language ?? 'Không rõ' }}</p> --}}

                <button class="btn btn-outline-success btn-sm mt-1" onclick="clearSessionAndGoHome()">
                    → CHỌN PHIM KHÁC
                </button>

            </div>
        </div>

    </div>

    <div class="container mt-4">
        <div id="booking-steps">
            <div class="booking-step" id="step-0" style="display: {{ $step === 0 ? 'block' : 'none' }}">
                @include('Client.booking.steps.select_showtime')
            </div>

            <div class="booking-step" id="step-1" style="display: {{ $step === 1 ? 'block' : 'none' }}">
                @include('Client.booking.steps.select-seat')
            </div>

            <div class="booking-step" id="step-2" style="display: none;">
                @include('Client.booking.steps.select-combo')
            </div>
            <div class="booking-step" id="step-3" style="display: none;">
                @include('Client.booking.steps.payment')
            </div>
        </div>


    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/calendar.js') }}"></script>

    <script>
        function clearSessionAndGoHome() {
            sessionStorage.clear();
            window.history.back();
            // window.location.href = '{{ route('home') }}';
        }
    </script>
@endpush
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
