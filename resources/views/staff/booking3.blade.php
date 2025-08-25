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

    <div class="container-seat" class="booking-step" id="step-2" style="display: none;">

        @include('Client.booking.steps.select-combo');
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
            border: 1px solid #67B72F;
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