@extends('layouts.admin')

@section('title', 'Danh sách hóa đơn')

@section('title2')
 Chi tiết hóa đơn 
@endsection

@section('title1')
    Hóa đơn
@endsection

@section('content')
    <style>
        .page-wrap {
            background: #f3f4f6;
            padding: 32px;
            /* padding lớn hơn */
            max-width: 1400px;
            /* rộng hơn trang */
            margin: 0 auto;
            /* căn giữa */
        }

        .box {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
            /* đổ bóng rõ hơn */
            padding: 24px;
            /* padding lớn hơn */
        }

        .table thead th {
            background: #f8fafc;
            font-weight: 600;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .movie-poster {
            width: 160px;
            height: 208px;
            object-fit: cover;
            border-radius: 6px;
        }

        .combo-img {
            width: 104px;
            height: 134px;
            object-fit: cover;
            border-radius: 6px;
        }

        .barcode-box img {
            max-width: 100%;
            height: auto;
        }

        /* Responsive: nhỏ hơn màn hình nhỏ */
        @media (max-width: 992px) {
            .movie-poster {
                width: 100px;
                height: 140px;
            }

            .combo-img {
                width: 48px;
                height: 48px;
            }
        }

        .movie-title {
            font-size: 20px;
            /* to hơn bình thường */
            font-weight: 700;
            color: #28a745;
        }

        /* Label có sẵn như bạn viết */
        .label {
            display: inline-block;
            font-size: 12px;
            padding: 3px 6px;
            margin-right: 4px;
            border-radius: 4px;
            color: #fff;
            font-weight: bold;
        }

        .label.age {
            background: linear-gradient(to bottom, #ff4d4d, #a00);
        }

        .label.subtitle {
            background: #000;
            border: 1px solid rgba(247, 232, 147, 0.795);
            font-weight: normal;
        }

        .label.type {
            background: linear-gradient(to bottom, #5fd26f, #2ca551);
        }

        .screening-time {
            font-weight: 700;
            /* in đậm */
            font-size: 16px;
            /* to chữ hơn */
            color: #333;
            /* có thể đổi màu nếu muốn */
        }

        .movie-info .info-item {
            font-size: 16px;
            /* to hơn mặc định */
            font-weight: 500;
            /* in đậm vừa phải */
            color: #222;
            /* màu tối */
            margin-bottom: 2px;
            /* cách nhau */
        }

        .screening-time {
            font-size: 20px;
            /* giữ chữ lịch chiếu lớn */
            font-weight: 700;
            /* in đậm */
            color: #28a745;
        }

        .booking-barcode {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            /* tăng khoảng cách giữa barcode và text */
            margin-top: 16px;
            /* cách phần trên nhiều hơn */
        }

        .booking-barcode img {
            width: 200px;
            /* tăng chiều rộng barcode */
            height: auto;
            /* giữ tỉ lệ */
        }
    </style>
    @push('styles')
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    @endpush


    <div class="page-wrap">
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-3">


            <a href="{{ route('bills.index') }}" class="btn btn-outline-secondary py-2">
                <i class="bi bi-arrow-left me-2"></i> Quay lại
            </a>


        </div>

        <div class="row g-4">
    <!-- CỘT TRÁI: 3/4 -->
    <div class="col-12 col-lg-9">
    <!-- Thông tin phim / đồ ăn -->
    <div class="box p-3 mb-3">
        <div class="table-responsive">
            <table class="table table-sm align-middle">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Chi tiết / Ghế</th>
                        <th class="text-end">Tổng tiền</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Vé phim --}}
                    @if($booking->showtime_id)
                        <tr>
                            <td>
                                <div class="d-flex align-items-start gap-2">
                                    <img src="{{ $booking->showtime?->movie?->poster
                                        ? asset('storage/' . $booking->showtime->movie->poster)
                                        : 'https://via.placeholder.com/100' }}"
                                        class="movie-poster" alt="Poster">
                                    <div class="movie-info">
                                        <div class="fw-bold movie-title">{{ $booking->showtime->movie?->title }}</div>
                                        <div class="labels mt-1">
                                            <span class="label age">{{ $booking->showtime->movie?->age_rating }}</span>
                                            <span class="label subtitle">{{ $booking->showtime->movie?->language }}</span>
                                            <span class="label type">{{ $booking->showtime->movie?->format }}</span>
                                        </div>
                                        <div class="movie-info mt-2">
                                            <div class="info-item">Thời lượng: {{ $booking->showtime->movie?->duration }} phút</div>
                                            <div class="info-item">Thể loại: {{ $booking->showtime->movie?->genre->genre_name }}</div>
                                            <div class="info-item">Địa điểm: {{ $booking->showtime->cinema->name }} - {{ $booking->showtime->cinema->address_detail }} - {{ $booking->showtime->room->room_name }}</div>
                                            <div>Lịch chiếu: 
                                                <span class="screening-time">
                                                    {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('H:i') }} -
                                                    {{ \Carbon\Carbon::parse($booking->showtime->end_time)->format('H:i') }}
                                                    ({{ \Carbon\Carbon::parse($booking->showtime->date)->format('d/m/Y') }})
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">
                                {{ $booking->seats->pluck('seat_code')->join(', ') }}
                            </td>
                            <td class="text-end">{{ number_format($totalSeatPrice, 0, ',', '.') }} VNĐ</td>
                        </tr>
                    @endif

                    {{-- Đơn đồ ăn --}}
                    @if($booking->bookingFoods->count())
                        @foreach($booking->bookingFoods as $bf)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $bf->food->image ? asset('storage/' . $bf->food->image) : 'https://via.placeholder.com/100' }}" class="combo-img" alt="{{ $bf->food->name }}">
                                        <span>{{ $bf->food->name }}</span>
                                    </div>
                                </td>
                                <td class="small">
                                    Số lượng: {{ $bf->quantity }} <br>
                                    Giá: {{ number_format($bf->food->price ?? 0, 0, ',', '.') }} VNĐ
                                </td>
                                <td class="text-end">
                                    {{ number_format($bf->quantity * ($bf->food->price ?? 0), 0, ',', '.') }} VNĐ
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tổng tiền và combo -->
    <div class="box p-3">
        <div class="d-flex flex-column align-items-end">
            <div>Giảm giá: <strong>{{ number_format($booking->total_discount, 0, ',', '.') }} VNĐ</strong></div>
            <div class="fs-5 fw-bold">
                <i class="bi bi-coin text-warning"></i> Điểm: {{ floor(($booking->payment?->price_amount ?? 0) / 1000) }}
            </div>
            <div class="fs-5 fw-bold">Tổng tiền: {{ number_format($booking->payment?->price_amount ?? 0, 0, ',', '.') }} VNĐ</div>
        </div>
    </div>
</div>


    <!-- CỘT PHẢI: 1/4 -->
    <div class="col-12 col-lg-3">
        <!-- Trạng thái vé -->
        <div class="box p-3 mb-3">
            <div class="fw-semibold text-success">Trạng thái vé</div>
            <div>
                @if ($booking->printed_count > 0)
                    <span class="badge bg-success fs-6">
                        Đã xuất vé ({{ $booking->printed_at?->format('H:i - d/m/Y') }})
                    </span>
                @else
                    <span class="badge bg-secondary fs-6">Chưa xuất vé</span>
                @endif
            </div>
            <div class="booking-barcode">
                {!! DNS1D::getBarcodeHTML($booking->booking_code, 'C128', 1, 40) !!}
                <small>{{ $booking->booking_code }}</small>
            </div>
        </div>

        <!-- Thông tin người đặt -->
        <div class="box p-3 mb-3">
            <div class="fw-semibold mb-2">Thông tin người đặt</div>
            <div class="mb-2 d-flex align-items-center gap-2">
                <i class="bi bi-person fs-4 text-secondary"></i>
                <div>
                    <div class="fw-semibold">{{ $booking->user->full_name }}</div>
                    <div class="small text-muted">
                        @switch($booking->user->role_id)
                            @case(1) Admin @break
                            @case(2) Quản lý rạp @break
                            @case(3) Nhân viên @break
                            @case(4) Người dùng @break
                            @default Không xác định
                        @endswitch
                    </div>
                </div>
            </div>
            <div class="mb-1 d-flex align-items-center gap-2">
                <i class="bi bi-envelope text-secondary"></i>
                <span class="small">{{ $booking->user->email }}</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-telephone text-secondary"></i>
                <span class="small">{{ $booking->user->phone }}</span>
            </div>
        </div>

        <!-- Thông tin thanh toán -->
        <div class="box p-3">
            <div class="fw-semibold mb-1">Thông tin thanh toán</div>
            <div class="small">Thanh toán lúc: {{ $booking->payment?->created_at?->format('H:i - d/m/Y') ?? '' }}</div>
            <div class="small">Phương thức: {{ $booking->payment?->payment_method ?? 'Chưa thanh toán' }}</div>
            <div class="small">Tên tài khoản: {{ $booking->user->full_name }}</div>
            <div class="fw-bold mt-2">Tổng tiền: {{ number_format($booking->payment?->price_amount ?? 0, 0, ',', '.') }} VNĐ</div>
        </div>
    </div>
</div>

    </div>
@endsection
