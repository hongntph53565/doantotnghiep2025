@extends('layouts.staff')

@section('title', 'Vé Online')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')

    <style>
        .disabled-link {
            pointer-events: none;
            /* chặn click */
            opacity: .65;
            /* làm mờ */
        }

        form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        input[type="text"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 8px;
            min-width: 180px;
            font-size: 14px;
        }

        button {
            padding: 8px 16px;
            background-color: #3490dc;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #2779bd;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #f8f9fa;
            font-weight: bold;
        }

        tbody tr:nth-child(even) {
            background-color: #f1f1f1;
        }

        tbody tr:hover {
            background-color: #e2e8f0;
        }
    </style>

    @if (session('error'))
        <div style="color: red; margin-bottom: 10px;">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('staff.search_ticket_online') }}" method="GET" class="mb-4">
        <input type="text" name="query" placeholder="Nhập mã vé, tên khách hàng hoặc ngày chiếu..."
            value="{{ request('query') }}">
        <button type="submit">Tìm kiếm</button>
    </form>

    @if ($bookings->count())
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Người đặt</th>
                    <th>Tên phim</th>
                    <th>Ngày chiếu</th>
                    <th>Mã vé</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                    <th>Thông tin in</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $booking)
                    <tr>
                        <td>{{ $booking->booking_id }}</td>
                        <td>{{ $booking->user->full_name ?? 'Không rõ' }}</td>
                        <td>{{ $booking->showtime->movie->title ?? 'Đơn đồ ăn' }}</td>
                        <td>{{ $booking->showtime->date ?? '' }}</td>
                        <td>{{ $booking->booking_code }}</td>
                        <td>{{ $booking->booking_status }}</td>
                        <td>
                            @php $printed = ($booking->printed_count ?? 0) > 0 || !is_null($booking->printed_at ?? null); @endphp

                            <a href="{{ $printed ? '#' : route('staff.booking.print', $booking->booking_id) }}"
                                target="{{ $printed ? '' : '_blank' }}"
                                class="btn btn-sm btn-primary {{ $printed ? 'disabled-link' : '' }}"
                                aria-disabled="{{ $printed ? 'true' : 'false' }}" tabindex="{{ $printed ? '-1' : '0' }}"
                                title="{{ $printed ? 'Vé này đã in rồi' : 'In vé' }}">
                                {{ $printed ? 'Đã in' : 'In vé' }}
                            </a>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                data-bs-target="#ticketModal{{ $booking->booking_id }}">
                                Xem
                            </button>



                            <div class="modal fade" id="ticketModal{{ $booking->booking_id }}" tabindex="-1"
                                aria-labelledby="ticketModalLabel{{ $booking->booking_id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content p-4 ticket-style">
                                        <div class="row g-3">

                                            <div class="col-md-3 text-center ">
                                                @if ($booking->showtime && $booking->showtime->movie)
                                                    <img src="{{ asset('storage/' . $booking->showtime->movie->poster) }}"
                                                        alt="poster" class="img-fluid rounded shadow">
                                                @elseif ($booking->bookingFoods->first()?->food?->image)
                                                    <img src="{{ asset('storage/' . $booking->bookingFoods->first()->food->image) }}"
                                                        alt="combo" class="img-fluid rounded shadow">
                                                @else
                                                    <img src="{{ asset('images/default-poster.jpg') }}" alt="default"
                                                        class="img-fluid rounded shadow">
                                                @endif
                                            </div>



                                            <div class="col-md-9 px-0">
                                                <div class="ticket-info">
                                                    @if ($booking->showtime && $booking->showtime->movie)
                                                        <h5 class="fw-bold text-uppercase mb-3">
                                                            {{ $booking->showtime->movie->title }}
                                                        </h5>

                                                        <div class="mb-1 d-flex">
                                                            <span class="w-25 fw-bold"><i
                                                                    class="bi bi-calendar-event me-1"></i> Thời
                                                                gian:</span>
                                                            <span>
                                                                <em>
                                                                    {{ ucfirst(
                                                                        \Carbon\Carbon::parse($booking->showtime->start_time)->locale('vi')->isoFormat('dddd, DD [Tháng] MM, YYYY'),
                                                                    ) }}
                                                                </em>
                                                                <strong class="mx-2">|</strong>
                                                                <em>
                                                                    {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('H:i') }}
                                                                    ~
                                                                    {{ \Carbon\Carbon::parse($booking->showtime->end_time)->format('H:i') }}
                                                                </em>
                                                            </span>
                                                        </div>

                                                        <div class="mb-1 d-flex">
                                                            <span class="w-25 fw-bold"><i
                                                                    class="bi bi-geo-alt-fill me-1"></i>
                                                                Rạp:</span>
                                                            <span>{{ $booking->showtime->room->cinema->name ?? 'N/A' }}</span>
                                                        </div>
                                                        <div class="mb-1 d-flex">
                                                            <span class="w-25 fw-bold"><i class="bi bi-building me-1"></i>
                                                                Địa
                                                                chỉ:</span>
                                                            <div class="text-wrap">
                                                                {{ $booking->showtime->room->cinema->address_detail ?? '...' }}
                                                            </div>
                                                        </div>

                                                        <div class="mb-1 d-flex">
                                                            <span class="w-25 fw-bold"><i class="bi bi-film me-1"></i>
                                                                Phòng:</span>
                                                            <span>
                                                                {{ $booking->showtime->room->room_name ?? 'N/A' }}
                                                                |
                                                                <strong>Ghế:</strong>
                                                                @foreach ($booking->bookingSeats as $bs)
                                                                    {{ $bs->showtimeSeat->seat->seat_code ?? 'N/A' }}
                                                                    @if (!$loop->last)
                                                                        ,
                                                                    @endif
                                                                @endforeach
                                                            </span>
                                                        </div>
                                                    @else
                                                        <h5 class="fw-bold text-uppercase mb-3 text-danger">
                                                            Đơn hàng đồ ăn (Không có phim chiếu)
                                                        </h5>
                                                    @endif

                                                    <div class="mb-1 d-flex">
                                                        <span class="w-25 fw-bold"><i
                                                                class="bi bi-ticket-perforated me-1"></i> Mã
                                                            vé:</span>
                                                        <span>{{ $booking->booking_code }}</span>
                                                    </div>

                                                    <div class="mb-1 d-flex">
                                                        <span class="w-25 fw-bold"><i class="bi bi-cup-straw me-1"></i> Đồ
                                                            ăn:</span>
                                                        <span>
                                                            @php
                                                                $foodList = $booking->bookingFoods
                                                                    ->map(function ($bf) {
                                                                        return $bf->quantity .
                                                                            ' x ' .
                                                                            ($bf->food->name ?? 'Không rõ');
                                                                    })
                                                                    ->implode(', ');
                                                            @endphp
                                                            {{ $foodList ?: 'Không có' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <hr class="my-4">

                                        <div class="row align-items-center">

                                            <div class="col-md-3 text-center">
                                                <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ $booking->booking_code }}&size=100x100"
                                                    alt="QR" class="img-thumbnail">
                                                <p class="mt-2 mb-0">{{ $booking->booking_code }}</p>
                                            </div>


                                            <div class="col-md-9">


                                                @php
                                                    $discount = $booking->bookingPromotions->sum('discount_amount');

                                                    $comboTotal = $booking->bookingFoods->sum('price'); // giá từ booking_food

                                                    $ticketPrice = 0;
                                                    if ($booking->showtime) {
                                                        // Nếu có phim
                                                        $ticketPrice = $booking->total_price + $discount - $comboTotal;
                                                    }
                                                @endphp

                                                <div class="d-flex justify-content-between">
                                                    <span><i class="bi bi-ticket-perforated me-1"></i> Giá vé:</span>
                                                    <span>{{ $ticketPrice > 0 ? number_format($ticketPrice, 0, ',', '.') . ' đ' : '0 đ' }}</span>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <span><i class="bi bi-cup-straw me-1"></i> Bắp nước:</span>
                                                    <span>{{ number_format($comboTotal, 0, ',', '.') }} đ</span>
                                                </div>

                                                <div class="d-flex justify-content-between">
                                                    <span><i class="bi bi-tags-fill me-1"></i> Giảm giá:</span>
                                                    <span>
                                                        {{ number_format($booking->bookingPromotions->sum('discount_amount'), 0, ',', '.') }}
                                                        đ
                                                    </span>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <span><i class="bi bi-credit-card-2-front-fill me-1"></i>
                                                        Phương thức:</span>
                                                    <span>{{ strtoupper($booking->payment_method) }}</span>
                                                </div>
                                                <hr>
                                                <div class="d-flex justify-content-between fw-bold">
                                                    <span>Tổng cộng:</span>
                                                    <span>{{ number_format($booking->total_price, 0, ',', '.') }}
                                                        đ</span>
                                                </div>
                                            </div>

                                        </div>

                                        <hr class="my-3">
                                        <p class="small text-muted mb-1">
                                            Vui lòng đưa mã số này đến quầy vé LumiStar để nhận vé của bạn
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if ($booking->printed_count > 0)
                                <span class="badge bg-success">
                                    Đã in
                                    @if ($booking->printer)
                                        bởi: {{ $booking->printer->full_name ?? ($booking->printer->name ?? 'N/A') }}
                                    @endif
                                    @if ($booking->printed_at)
                                        lúc: {{ $booking->printed_at->format('d/m/Y H:i') }}
                                    @endif
                                </span>
                            @endif
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>


        @if (method_exists($bookings, 'links'))
            <div class="mt-3 d-flex justify-content-center">
                {{ $bookings->appends(['query' => request('query')])->links() }}
            </div>
        @endif
    @else
        <p class="text-muted">Không tìm thấy kết quả phù hợp.</p>
    @endif

@endsection
