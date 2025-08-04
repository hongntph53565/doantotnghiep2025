@extends('layouts.staff')

@section('title', 'Staff')


@section('content')
    <br>
    <div class="container-top">
        <h1 class="entry-title text-center fs-3">Bước 2: Chọn ghế</h1>
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

    <div class="container-seat">

        <div class="row d-flex p-0">
            <div class="col-md-7 me-2">
                <div class="screen">
                    <div style="text-align: center; margin-bottom: 10px;">
                        <svg width="100%" height="100" viewBox="0 0 800 100">
                            <defs>
                                <linearGradient id="screenGradient" x1="0" y1="0" x2="0"
                                    y2="1">
                                    <stop offset="0%" stop-color="#adff2f" stop-opacity="0.4" />
                                    <stop offset="100%" stop-color="white" stop-opacity="0" />
                                </linearGradient>
                            </defs>

                            <!-- Vùng shadow cong theo đường cong -->
                            <path d="
                                                                                                                        M50 40
                                                                                                                        Q400 0 750 40
                                                                                                                        Q400 60 50 40
                                                                                                                        Z"
                                fill="url(#screenGradient)" />

                            <!-- Đường cong chính -->
                            <path d="M50 40 Q400 0 750 40" stroke="#adff2f" stroke-width="5" stroke-linecap="round"
                                fill="none" />
                        </svg>

                        <div style="margin-top: -35px; font-weight: bold; color: #acacac; font-size: 20px;">Màn hình
                        </div>
                    </div>


                </div>
                <div class="legend">
                    <div class="legend-row">
                        <div class="legend-item">
                            <img src="{{ asset('images/seat-normal-available.svg') }}" alt="">
                            <span>Standard</span>
                        </div>
                        <div class="legend-item">
                            <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip" data-status="available"
                                alt="">
                            <span>VIP</span>
                        </div>
                        <div class="legend-item">
                            <img src="{{ asset('images/seat-couple-available.svg') }}" data-type="double"
                                data-status="available" alt="">
                            <span>Couple</span>
                        </div>
                    </div>
                    <div class="legend-row">
                        <div class="legend-item">
                            <img src="{{ asset('images/seat-selected.svg') }}" alt="">
                            <span>Ghế đã chọn</span>
                        </div>
                        <div class="legend-item">
                            <img src="{{ asset('images/seat-booked.svg') }}" alt="">
                            <span>Ghế đã bán</span>
                        </div>
                    </div>
                </div>
                <div class="booking-step" id="step-1" style="display: {{ $step === 1 ? 'block' : 'none' }}" class="seat">
                    @include('staff.booking.seat');
                </div>

            </div>

            <div class="col-md-4 ms-5 mt-5">
                <h3 class="fw-bold fs-5">{{ $selectedShowtime->room->cinema->name ?? 'Tên rạp' }}</h3>
                <p><strong style="color: #67B72F;">{{ $selectedShowtime->room->room_name }}</strong> <span> -
                        {{ \Carbon\Carbon::parse($selectedShowtime->date)->format('d/m/Y') }}

                        - Suất chiếu:
                        {{ $selectedShowtime->start_time }}</span></p>
                <hr>
                <p class="title fw-bold fs-5" style="color: #67B72F;">{{ $selectedShowtime->movie->title }}</p>
                <p>
                    <span
                        style="background: #0096FF; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px;">{{ $selectedShowtime->movie->age_rating }}</span>
                    <span
                        style="background: black; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px;">PHỤ
                        ĐỀ</span>
                    <span
                        style="background: green; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px;">{{ $selectedShowtime->room->format }}</span>
                </p>
                {{-- <p class="info">1 x Adult - Stand - 2D<br>Ghế: C15 <strong style="float:right">100.000 VND</strong>
                </p>
                <hr>
                <p class="info">1 x OL Combo1 - Sweet 22Oz <strong style="float:right">85.000 VND</strong></p>
                <hr> --}}

                <div id="selected-seats"></div>
                <hr>
                <div class="total">
                    <span>Tổng tiền</span>
                    <span id="total-price">0 VND</span>
                </div>
                <p class="note">(Đã bao gồm phụ thu)</p>
                <a href="javascript:void(0);" class="btn-checkout" onclick="goToStep(2)">Chọn đồ ăn (2/4)</a>
                <div class="btn-back-wrapper">
                    <a href="javascript:void(0);" class="btn-back" onclick="goBackStep()">← Trở lại</a>
                </div>
                <br>
            </div>
        </div>
    </div>

@endsection
@push('styles')
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
@endpush