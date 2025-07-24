<div class="container mb-5">
    <div class="container-combo">
        <div class="left-box">
            <div class="payment-method-box">
                <h3>Hình thức thanh toán</h3>
                <hr>
                <div class="payment-option">
                    <input type="radio" name="payment" id="vnpay">
                    <label for="vnpay">
                        <img src="{{ asset('images/vnpay.png') }}" alt="VNPAY">
                        <span>Thanh toán qua VNPAY (Visa, Master, Amex, JCB,...)</span>
                    </label>
                </div>

                <div class="payment-option">
                    <input type="radio" name="payment" id="payos">
                    <label for="payos">
                        <img src="{{ asset('images/momo.png') }}" alt="MoMo">
                        <span>Thanh toán bằng Payos</span>
                    </label>
                </div>

                <div class="payment-option">
                    <input type="radio" name="payment" id="zalopay">
                    <label for="zalopay">
                        <img src="{{ asset('images/zalopay.png') }}" alt="ZaloPay">
                        <span>Zalopay QR đa năng</span>
                    </label>
                </div>


            </div>
        </div>

        <div class="right-box">
            @if ($selectedShowtime && $selectedShowtime->room && $selectedShowtime->movie)
                <h3 style="font-weight: bold;">{{ $selectedShowtime->room->cinema->name ?? 'Tên rạp' }}</h3>
                <p>
                    <strong style="color: #67B72F;">{{ $selectedShowtime->room->room_name ?? 'Phòng chiếu' }}</strong>
                    @if ($selectedShowtime)
                        <span>
                            - {{ \Carbon\Carbon::parse($selectedShowtime->date)->format('d/m/Y') }}
                            - Suất chiếu: {{ \Carbon\Carbon::parse($selectedShowtime->start_time)->format('H:i') }}
                        </span>
                    @else
                        <span> - Ngày chiếu - Suất chiếu: giờ </span>
                    @endif

                </p>
                <p class="title" style="color: #67B72F; font-weight: bold; font-size: 20px;">
                    {{ $movie->title ?? 'Tên phim' }}
                </p>

                <p>
                    <span
                        style="background: #0096FF; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px; margin-right: 6px;">
                        {{ $movie->age_rating ?? 'P' }}
                    </span>
                    <span
                        style="background: black; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px; margin-right: 6px;">
                        {{ $movie->language ?? 'Phụ đề' }}
                    </span>
                    <span
                        style="background: green; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px;">
                        {{ $movie->format ?? '2D' }}
                    </span>
                </p>

            @endif
 <hr>
            <p class="info" id="final-seat-info">Đang tải ghế...</p>

            <hr>
            <div class="total">
                <span>Tổng tiền</span>
                <span id="final-total-payment">0 VND</span>
            </div>
            <p class="note">(Đã bao gồm phụ thu)</p>
            @if (isset($booking_code) && isset($total_price))
                <input type="hidden" id="booking_code" value="{{ $booking_code }}">
                <input type="hidden" id="total_price" value="{{ $total_price }}">
            @endif
           @if (Auth::check())
    <form id="checkout-form" action="{{ route('booking.store') }}" method="POST">
        @csrf
        <input type="hidden" name="user_id" value="{{ Auth::user()->user_id }}">
        <input type="hidden" name="showtime_id" id="showtime_id">
        <input type="hidden" name="payment_method" id="payment_method">
        <input type="hidden" name="total_price" id="total_price_hidden">
        <input type="hidden" name="seats_id" id="selected_seats">
        <input type="hidden" name="selected_foods" id="selected_foods">

        <a href="javascript:void(0);" class="btn-checkout" onclick="submitCheckout()">THANH TOÁN (4/4)</a>
    </form>
@else
    <div class="alert alert-warning mt-3">
        Bạn cần <a href="{{ route('register.form') }}">đăng ký / đăng nhập</a> để tiếp tục thanh toán.
    </div>
@endif

            <div class="btn-back-wrapper">
                <a href="javascript:void(0);" class="btn-back" onclick="goBackStep()">← Trở lại</a>
            </div>
        </div>

        <script>
    function submitCheckout() {
        const paymentMethod = document.querySelector('input[name="payment"]:checked')?.id;
        if (!paymentMethod) {
            alert("Vui lòng chọn hình thức thanh toán!");
            return;
        }

        const showtimeId = localStorage.getItem("selectedShowtimeId");
        const selectedSeatsRaw = JSON.parse(sessionStorage.getItem("selectedSeats")) || [];
        const selectedFoods = JSON.parse(sessionStorage.getItem("selectedFoods")) || [];
        const totalPrice = parseInt(sessionStorage.getItem("finalTotal")) || 0;

        if (!showtimeId || selectedSeatsRaw.length === 0 || totalPrice <= 0) {
            alert("Thiếu dữ liệu đặt vé.");
            return;
        }

        // Lấy danh sách seat_id duy nhất dưới dạng mảng [39, 40,...]
        const seatIds = [];
        selectedSeatsRaw.forEach(item => {
            if (item.type === 'couple' && Array.isArray(item.seat_ids)) {
                seatIds.push(...item.seat_ids);
            } else if (item.seat_id) {
                seatIds.push(item.seat_id);
            }
        });

        console.log("seatIds:", seatIds);

        // Gán vào input hidden trong form
        document.getElementById("showtime_id").value = showtimeId;
        document.getElementById("payment_method").value = paymentMethod;
        document.getElementById("total_price_hidden").value = totalPrice;
        document.getElementById("selected_seats").value = JSON.stringify(seatIds);
        document.getElementById("selected_foods").value = JSON.stringify(selectedFoods);

        document.getElementById("checkout-form").submit();
    }
</script>

    </div>
</div>