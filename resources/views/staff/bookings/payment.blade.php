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
                <h3 style="font-weight: bold;">BHD Star The Garden</h3>
                <p><strong style="color: #67B72F;">Screen 6</strong> <span> - 13/6/2025 - Suất chiếu: 14h40</span></p>
                <p class="title">DORAEMON: NOBITA'S ART WORLD TALES</p>
                <p>
                    <span
                        style="background: #0096FF; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px;">P</span>
                    <span
                        style="background: black; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px;">PHỤ
                        ĐỀ</span>
                    <span
                        style="background: green; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px;">2D</span>
                </p>
                <p class="info">1 x Adult - Stand - 2D<br>Ghế: C15 <strong style="float:right">100.000 VND</strong></p>
                <hr>
                <div class="total">
                    <span>Tổng tiền</span>
                    <span>100.000</span>
                </div>
                <p class="note">(Đã bao gồm phụ thu)</p>
                <a href="javascript:void(0);" class="btn-checkout">THANH TOÁN (4/4)</a>
                <div class="btn-back-wrapper">
    <a href="javascript:void(0);" class="btn-back" onclick="goBackStep()">← Trở lại</a>
</div>

            </div>

        </div>
    </div>
