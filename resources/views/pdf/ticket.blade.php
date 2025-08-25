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
    margin: 0 auto 16px;
    position: relative; /* quan trọng cho watermark */
    overflow: hidden;   /* tránh watermark tràn viền */
  }

 .ticket .wm {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;

  /* Scale ảnh vượt khung để chắc chắn phủ hết */
  min-width: 100%;
  min-height: 100%;

  object-fit: cover;        /* Giữ tỉ lệ, có thể crop */
  object-position: center;  /* Căn giữa ảnh */

  opacity: 0.2;            /* Độ mờ khi xem */
  pointer-events: none;
  z-index: 0;
  /* filter: #5DC930; */
}


/* Nội dung nằm trên watermark */
.ticket > *:not(.wm) {
  position: relative;
  z-index: 1;
}

  .title { text-align:center; font-weight:bold; font-size:18px; margin-bottom:10px; }
  .movie-title { font-weight:bold; font-size:20px; margin-bottom:6px; }
  .section { margin-bottom:12px; }
  .barcode { text-align:center; margin-top:20px; }
  .footer { text-align:center; font-size:12px; margin-top:16px; }

  /* Khi in: cố gắng giữ màu/độ mờ (không phải browser nào cũng tôn trọng 100%) */
  @media print {
    body { padding: 0; }
    .ticket .wm {
      opacity: 0.2;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }
  }
</style>

</head>
<body >
    @php
    $seatCodes = implode(', ', $booking->seats->pluck('seat_code')->toArray());
    $seatCount = $booking->seats->count();
@endphp

{{-- Vé cho từng ghế --}}
@foreach ($booking->seats as $seat)
    <div class="ticket">
        <img class="wm" src="{{ asset('images/bgticket1.png') }}" alt="Watermark">
        <div style="height: 30px"></div>
        <div class="title">VÉ VÀO PHÒNG CHIẾU PHIM</div>
        <div style="height: 20px"></div>
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
<strong>Ghế:</strong> {{ $seat->seat_code }}
        </div>

        <div class="barcode">
            <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ $booking->booking_code }}&size=100x100" alt="QR">
            <p><strong>Mã vé:</strong> {{ $booking->booking_code }}</p>
        </div>

        <div class="footer">
            Cảm ơn quý khách đã sử dụng dịch vụ LumiStar<br>
            Nhân viên: {{ auth()->user()->name ?? 'N/A' }}
        </div>
    </div>
@endforeach

{{-- Vé đồ ăn --}}
@if($booking->foods->count())
    <div class="ticket">
        <img class="wm" src="{{ asset('images/bgticket1.png') }}" alt="Watermark">
        <div class="title">VÉ ĐỒ ĂN</div>

        @if($cinema)
            <div class="section">
                <p><strong>{{ $cinema->name }}</strong></p>
                {{ $cinema->address_detail ?? '' }},
                {{ $cinema->ward ?? '' }},
                {{ $cinema->district ?? '' }},
                {{ $cinema->city ?? '' }}
            </div>
        @endif

        <div class="section">
            <strong>Đồ ăn:</strong>
            {{ $booking->foods->map(fn($f) => $f->pivot->quantity . ' x ' . $f->name)->implode(', ') }}
        </div>

        <div class="barcode">
             <img src="https://api.qrserver.com/v1/create-qr-code/?data={{ $booking->booking_code }}&size=100x100" alt="QR">
            <p><strong>Mã đơn:</strong> {{ $booking->booking_code }}</p>
        </div>

        <div class="footer">
            Cảm ơn quý khách đã sử dụng dịch vụ LumiStar<br>
            Nhân viên: {{ auth()->user()->full_name ?? 'N/A' }}<br>
Tài khoản: {{ auth()->user()->username ?? 'N/A' }}



        </div>
    </div>
@endif




</body>
</html>
<script>
(function () {
  function whenAllLoaded(selectors, timeoutMs) {
    const nodes = selectors.flatMap(s => Array.from(document.querySelectorAll(s)));
    return new Promise(resolve => {
      if (nodes.length === 0) return resolve();
      let loaded = 0;
      const done = () => { if (++loaded === nodes.length) resolve(); };
      nodes.forEach(n => {
        if (n.complete) return done();
        n.addEventListener('load', done, { once: true });
        n.addEventListener('error', done, { once: true });
      });
      setTimeout(resolve, timeoutMs || 2500);
    });
  }
  window.addEventListener('load', async () => {
    await whenAllLoaded(['.barcode img', '.ticket .wm'], 2500);
    window.print();
  });
})();
</script>
<script>
(function () {
  const markUrl = @json($markPrintedUrl);
  const csrf = @json(csrf_token());
  let marked = false;

  async function markPrinted() {
    if (marked) return;
    marked = true;
    try {
      await fetch(markUrl, {
        method: 'POST',
        headers: {'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrf},
        body: JSON.stringify({ done: true })
      });
    } catch (e) { console.error(e); }
  }

  window.addEventListener('load', async () => {
const imgs = Array.from(document.images);
    await Promise.race([
      Promise.all(imgs.map(img => img.complete ? Promise.resolve() :
        new Promise(res => { img.onload = img.onerror = res; }))),
      new Promise(res => setTimeout(res, 2500))
    ]);
    window.print();
  });

  if ('onafterprint' in window) {
    window.addEventListener('afterprint', markPrinted);
  } else {
    window.addEventListener('blur', () => setTimeout(markPrinted, 1000));
  }
})();
</script>