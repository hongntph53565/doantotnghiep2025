<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            line-height: 1.4;
        }
        .ticket {
            width: 300px;
            padding: 20px;
            border: 1px dashed #ccc;
            margin: 0 auto;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 10px;
        }
        .section {
            margin-bottom: 10px;
        }

        .barcode {
            text-align: center;
            margin-top: 15px;
        }
        .barcode img {
            width: 100%;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 10px;
        }
        .movie-title {
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 5px;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="ticket">
        <div class="title">VE VAO PHONG CHIEU PHIM</div>

        <div class="section">
            <p><strong>{{ $booking->showtime->room->cinema->name ?? 'Không xác định' }}</strong></p>
            {{ $booking->showtime->room->cinema->address_detail ?? '' }},
            {{ $booking->showtime->room->cinema->ward ?? '' }},
            {{ $booking->showtime->room->cinema->district ?? '' }},
            {{ $booking->showtime->room->cinema->city ?? '' }}
        </div>

        <div class="section">
            <p class="movie-title">{{ $booking->showtime->movie->title ?? 'Không xác định' }}</p> <br>
            <strong>Slot:</strong>
            {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('H:i') }} -
            {{ \Carbon\Carbon::parse($booking->showtime->end_time)->format('H:i') }},
            {{ \Carbon\Carbon::parse($booking->showtime->date)->format('d/m/Y') }}
        </div>

        <div class="section">
            <strong>Room:</strong> {{ $booking->showtime->room->room_name ?? 'Không xác định' }}<br>
            <strong>Seat(s):</strong>
            {{ implode(', ', $booking->seats->pluck('seat_code')->toArray()) }}
        </div>

        <div class="section">
            <strong>Ticket Price:</strong> {{ number_format($booking->total_price, 0, ',', '.') }}đ
        </div>

        @if($booking->foods->count())
        <div class="section">
            <strong>Foods & Drinks:</strong>
            {{ $booking->foods->pluck('name')->implode(', ') }}
        </div>
        @endif

        <div class="barcode">


            <div class="barcode" style="text-align: center; margin-top: 20px;">
                {!! DNS1D::getBarcodeHTML($booking->booking_code, 'C128', 2, 60) !!}
            </div>
            <p>Mã vé: {{ $booking->booking_code }}</p>
        <div class="footer">
            Cảm ơn quý khách đã sử dụng dịch vụ của LumiStar<br>
            Nhân viên: {{ auth()->user()->name ?? 'N/A' }}
        </div>
    </div>
</body>
</html>
