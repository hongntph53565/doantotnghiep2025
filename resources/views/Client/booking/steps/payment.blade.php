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
                    <input type="radio" name="payment" id="momo">
                    <label for="momo">
                        <img src="{{ asset('images/momo.png') }}" alt="MoMo">
                        <span>Thanh toán bằng Ví điện tử MoMo</span>
                    </label>
                </div>

                <div class="payment-option">
                    <input type="radio" name="payment" id="zalopay">
                    <label for="zalopay">
                        <img src="{{ asset('images/zalopay.png') }}" alt="ZaloPay">
                        <span>Zalopay QR đa năng</span>
                    </label>
                </div>

                <div class="payment-option">
                    <input type="radio" name="payment" id="shopeepay">
                    <label for="shopeepay">
                        <img src="{{ asset('images/shopeepay.png') }}" alt="ShopeePay">
                        <span>Thanh toán qua SHOPEEPAY</span>
                    </label>
                </div>
            </div>
        </div>

        <div class="right-box">
            @if ($selectedShowtime && $selectedShowtime->room && $selectedShowtime->movie)
                <h3 style="font-weight: bold;">{{ $selectedShowtime->room->cinema->name }}</h3>
                <p>
                    <strong style="color: #67B72F;">{{ $selectedShowtime->room->room_name }}</strong>
                    <span> - {{ \Carbon\Carbon::parse($selectedShowtime->date)->format('d/m/Y') }} - Suất chiếu:
                        {{ \Carbon\Carbon::parse($selectedShowtime->start_time)->format('H:i') }}</span>
                </p>
                <p class="title">{{ $selectedShowtime->movie->title }}</p>
                <p>
                    <span
                        style="background: #0096FF; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px;">
                        {{ $selectedShowtime->movie->rated ?? 'P' }}
                    </span>
                    <span
                        style="background: black; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px;">
                        {{ $selectedShowtime->movie->language ?? 'PHỤ ĐỀ' }}
                    </span>
                    <span
                        style="background: green; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px;">
                        {{ $selectedShowtime->movie->format ?? '2D' }}
                    </span>
                </p>
            @endif

            <p class="info" id="final-seat-info">Đang tải ghế...</p>

            <hr>
            <div class="total">
                <span>Tổng tiền</span>
                <span id="final-total-payment">0 VND</span>
            </div>
            <p class="note">(Đã bao gồm phụ thu)</p>
            <a href="javascript:void(0);" class="btn-checkout">THANH TOÁN (4/4)</a>
            <div class="btn-back-wrapper">
                <a href="javascript:void(0);" class="btn-back" onclick="goBackStep()">← Trở lại</a>
            </div>
        </div>


    </div>
</div>
