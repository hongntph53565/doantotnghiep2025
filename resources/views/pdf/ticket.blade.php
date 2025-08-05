<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Vé {{ $booking->booking_code }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            line-height: 1.4;
            padding: 20px;
        }
        .ticket {
            width: 320px;
            padding: 16px;
            border: 1px dashed #999;
            margin: 0 auto;
        }
        .title {
            text-align: center;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 10px;
        }
        .movie-title {
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 6px;
        }
        .section {
            margin-bottom: 12px;
        }
        .barcode {
            text-align: center;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 16px;
        }
        @media print {
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body >
    @php
    $seatCodes = implode(', ', $booking->seats->pluck('seat_code')->toArray());
    $seatCount = $booking->seats->count();
@endphp

@for ($i = 0; $i < $seatCount; $i++)
    <div class="ticket">
        <div class="title">VÉ VÀO PHÒNG CHIẾU PHIM</div>

        <div class="section">
            <p><strong>{{ $booking->showtime->room->cinema->name }}</strong></p>
            {{ $booking->showtime->room->cinema->address_detail }},
            {{ $booking->showtime->room->cinema->ward }},
            {{ $booking->showtime->room->cinema->district }},
            {{ $booking->showtime->room->cinema->city }}
        </div>

        <div class="section">
            <p class="movie-title">{{ $booking->showtime->movie->title }}</p>
            <strong>Suất:</strong>
            {{ \Carbon\Carbon::parse($booking->showtime->start_time)->format('H:i') }} -
            {{ \Carbon\Carbon::parse($booking->showtime->end_time)->format('H:i') }},
            {{ \Carbon\Carbon::parse($booking->showtime->date)->format('d/m/Y') }}
        </div>

        <div class="section">
            <strong>Phòng:</strong> {{ $booking->showtime->room->room_name }}<br>
            <strong>Ghế:</strong> {{ $seatCodes }}
        </div>

        @if($booking->foods->count())
            <div class="section">
                <strong>Đồ ăn:</strong>
                {{ $booking->foods->map(fn($f) => $f->pivot->quantity . ' x ' . $f->name)->implode(', ') }}
            </div>
        @endif

        <div class="barcode">
            <img src="data:image/png;base64,{{ $barcode }}" alt="barcode" />
            <p><strong>Mã vé:</strong> {{ $booking->booking_code }}</p>
        </div>

        <div class="footer">
            Cảm ơn quý khách đã sử dụng dịch vụ LumiStar<br>
            Nhân viên: {{ auth()->user()->name ?? 'N/A' }}
        </div>
    </div>
@endfor

</body>
</html>
<script>
    window.addEventListener('load', function () {
        const barcodeImg = document.querySelector('.barcode img');
        if (barcodeImg && !barcodeImg.complete) {
            barcodeImg.onload = () => window.print();
        } else {
            window.print();
        }
    });
</script>
