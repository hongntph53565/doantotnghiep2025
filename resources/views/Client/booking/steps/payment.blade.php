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
            <div class="voucher-box mt-3">
    <h5>Mã khuyến mãi</h5>
    <select id="promo-select" class="form-select mb-2">
        <option value="">-- Chọn mã khuyến mãi --</option>
        @foreach ($promotions as $promo)
            <option 
                value="{{ $promo->discount_code }}"
                data-type="{{ $promo->type_discount }}"
                data-value="{{ $promo->discount_value }}"
                data-max="{{ $promo->max_discount }}"
                data-min="{{ $promo->min_order_value }}"
            >
                {{ $promo->discount_code }} - 
                {{ $promo->type_discount == 'percent' ? $promo->discount_value . '%' : number_format($promo->discount_value) . '₫' }}
            </option>
        @endforeach
    </select>
    <button class="btn btn-outline-primary btn-sm" onclick="applyPromo()">Áp dụng</button>
    <div id="promo-message" class="text-success mt-2"></div>
</div>
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
        <input type="hidden" name="promo_code" id="promo_code_hidden">

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
    const ticketTotal = parseInt(sessionStorage.getItem("ticketTotal")) || 0;
    const foodTotal = parseInt(sessionStorage.getItem("foodTotal")) || 0;
    const originalTotal = ticketTotal + foodTotal;

    if (!showtimeId || selectedSeatsRaw.length === 0 || originalTotal <= 0) {
        alert("Thiếu dữ liệu đặt vé.");
        return;
    }

    const seatIds = [];
    selectedSeatsRaw.forEach(item => {
        if (item.type === 'couple' && Array.isArray(item.seat_ids)) {
            seatIds.push(...item.seat_ids);
        } else if (item.seat_id) {
            seatIds.push(item.seat_id);
        }
    });

    document.getElementById("showtime_id").value = showtimeId;
    document.getElementById("payment_method").value = paymentMethod;
    document.getElementById("total_price_hidden").value = originalTotal; // 🟢 Gửi giá gốc
    document.getElementById("selected_seats").value = JSON.stringify(seatIds);
    document.getElementById("selected_foods").value = JSON.stringify(selectedFoods);

    const promoSelect = document.getElementById("promo-select");
    const promoCode = promoSelect?.value || "";
    document.getElementById("promo_code_hidden").value = promoCode;

    document.getElementById("checkout-form").submit();
}


    let appliedDiscount = 0;
function applyPromo() {
    const promo = document.getElementById('promo-select');
    const selected = promo.options[promo.selectedIndex];
    const type = selected.getAttribute('data-type');
    const value = parseFloat(selected.getAttribute('data-value'));
    const maxDiscount = parseFloat(selected.getAttribute('data-max')) || Infinity;
    const minOrder = parseFloat(selected.getAttribute('data-min')) || 0;

    // 🟢 Lấy tổng tiền gốc (không thay đổi finalTotal)
    const ticketTotal = parseInt(sessionStorage.getItem("ticketTotal")) || 0;
    const foodTotal = parseInt(sessionStorage.getItem("foodTotal")) || 0;
    const originalTotal = ticketTotal + foodTotal;

    if (originalTotal < minOrder) {
        document.getElementById('promo-message').innerText = "Không đủ điều kiện áp dụng mã (Đơn tối thiểu: " + minOrder + " VND)";
        return;
    }

    let discount = 0;
    if (type === 'percent') {
        discount = (originalTotal * value / 100);
    } else if (type === 'amount') {
        discount = value;
    }

    discount = Math.min(discount, maxDiscount);
    const newTotal = originalTotal - discount;

    document.getElementById("final-total-payment").innerText = newTotal.toLocaleString('vi-VN') + " VND";
    document.getElementById("promo-message").innerText = "Đã áp dụng mã giảm " + Math.round(discount).toLocaleString('vi-VN') + " VND";

    // 🟢 Gửi promo_code nhưng không update totalPrice trong session
    document.getElementById("promo_code_hidden").value = selected.value;
}


</script>


    </div>
</div>