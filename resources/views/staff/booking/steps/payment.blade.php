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
            {{-- <div class="voucher-box mt-3">
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
</div> --}}

            <!-- Nút mở modal -->
            <div class="voucher-box mt-3">
                <h5>Mã khuyến mãi</h5>
                <div class="d-flex justify-content-between align-items-center p-3 border rounded" role="button"
                    data-bs-toggle="modal" data-bs-target="#voucherModal">
                    <div>
                        <i class="bi bi-ticket-perforated"></i> <strong>Mã ưu đãi</strong>
                    </div>
                    <div>
                        <span id="selected-voucher-label">Chọn hoặc nhập mã</span> <i class="bi bi-chevron-right"></i>
                    </div>
                </div>
            </div>
            <!-- Modal chọn mã -->
            <div class="modal fade" id="voucherModal" tabindex="-1" aria-labelledby="voucherModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">MÃ ƯU ĐÃI</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>
                        <div class="modal-body">
                            <input type="text" id="manualVoucherInput" class="form-control mb-3"
                                placeholder="Nhập mã ưu đãi">

                            <div id="voucher-list">
                                @foreach ($promotions as $promo)
                                    <div class="voucher-option mb-2 p-2 border">
                                        <img src="{{ asset('images/logo.jpg') }}" alt="Voucher icon">

                                        <input type="radio" name="voucher" id="voucher_{{ $loop->index }}"
                                            class="d-none clickable-voucher" value="{{ $promo->discount_code }}"
                                            data-type="{{ $promo->type_discount }}"
                                            data-value="{{ $promo->discount_value }}"
                                            data-max="{{ $promo->max_discount }}"
                                            data-min="{{ $promo->min_order_value }}">

                                        <label for="voucher_{{ $loop->index }}"
                                            class="voucher-label border rounded p-2 d-block">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <strong class="voucher-code">{{ $promo->discount_code }}</strong>
                                                <div class="voucher-discount">
                                                    {{ $promo->type_discount == 'percent'
                                                        ? $promo->discount_value . '%'
                                                        : number_format($promo->discount_value) . '₫' }}
                                                </div>

                                            </div>
                                            <div class="voucher-min-order mt-1 text-muted small">
                                                Đơn tối thiểu: {{ number_format($promo->min_order_value) }} VND
                                            </div>
                                        </label>
                                    </div>
                                @endforeach


                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-secondary"
                                data-bs-dismiss="modal">Đóng</button>
                            <button type="button" class="btn btn-danger" onclick="applyVoucher()">Áp dụng</button>
                        </div>
                    </div>
                </div>
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
                <form id="checkout-form" action="{{ route('booking.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="user_id" value="4">
                    <input type="hidden" name="showtime_id" id="showtime_id">
                    <input type="hidden" name="payment_method" id="payment_method">
                    <input type="hidden" name="total_price" id="total_price_hidden">
                    <input type="hidden" name="seats_id" id="selected_seats">
                    <input type="hidden" name="selected_foods" id="selected_foods">
                    <input type="hidden" name="promo_code" id="promo_code_hidden">

                    <a href="javascript:void(0);" class="btn-checkout" onclick="submitCheckout()">THANH TOÁN
                        (4/4)</a>
                </form>


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

    // 🔻 Áp dụng giảm giá trước khi submit
    const promoCode = document.getElementById("promo_code_hidden").value;
    let finalTotal = originalTotal;

    if (promoCode) {
        const selected = [...document.querySelectorAll('#promo-select option')].find(opt => opt.value === promoCode)
            || document.querySelector(`input[name="voucher"]:checked`);
        if (selected) {
            const type = selected.getAttribute('data-type');
            const value = parseFloat(selected.getAttribute('data-value'));
            const maxDiscount = parseFloat(selected.getAttribute('data-max')) || Infinity;
            const minOrder = parseFloat(selected.getAttribute('data-min')) || 0;

            if (originalTotal >= minOrder) {
                let discount = 0;
                if (type === 'percent') {
                    discount = originalTotal * value / 100;
                } else if (type === 'amount') {
                    discount = value;
                }
                discount = Math.min(discount, maxDiscount);
                finalTotal = originalTotal - discount;
            }
        }
    }

    document.getElementById("showtime_id").value = showtimeId;
    document.getElementById("payment_method").value = paymentMethod;
    document.getElementById("total_price_hidden").value = Math.round(finalTotal); // ✅ giá đã giảm
    document.getElementById("selected_seats").value = JSON.stringify(seatIds);
    document.getElementById("selected_foods").value = JSON.stringify(selectedFoods);
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
                    document.getElementById('promo-message').innerText = "Không đủ điều kiện áp dụng mã (Đơn tối thiểu: " +
                        minOrder + " VND)";
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
                document.getElementById("promo-message").innerText = "Đã áp dụng mã giảm " + Math.round(discount)
                    .toLocaleString('vi-VN') + " VND";

                // 🟢 Gửi promo_code nhưng không update totalPrice trong session
                document.getElementById("promo_code_hidden").value = selected.value;
            }
        </script>
        <script>
            let selectedVoucher = null;

            function applyVoucher() {
                const manualCode = document.getElementById('manualVoucherInput').value.trim();
                const checkedRadio = document.querySelector('input[name="voucher"]:checked');

                let type, value, maxDiscount, minOrder, code;

                if (manualCode !== '') {
                    // Mã nhập tay
                    code = manualCode;
                    // TODO: Bạn có thể xử lý gọi API để xác minh mã nhập tay ở đây
                    alert("Mã nhập tay chưa được xử lý.");
                    return;
                } else if (checkedRadio) {
                    // Mã được chọn từ danh sách
                    code = checkedRadio.value;
                    type = checkedRadio.getAttribute("data-type");
                    value = parseFloat(checkedRadio.getAttribute("data-value"));
                    maxDiscount = parseFloat(checkedRadio.getAttribute("data-max")) || Infinity;
                    minOrder = parseFloat(checkedRadio.getAttribute("data-min")) || 0;
                } else {
                    alert("Vui lòng chọn hoặc nhập mã.");
                    return;
                }

                // Tính toán
                const ticketTotal = parseInt(sessionStorage.getItem("ticketTotal")) || 0;
                const foodTotal = parseInt(sessionStorage.getItem("foodTotal")) || 0;
                const originalTotal = ticketTotal + foodTotal;

                if (originalTotal < minOrder) {
                    alert("Không đủ điều kiện áp dụng mã này.");
                    return;
                }

                let discount = 0;
                if (type === 'percent') {
                    discount = originalTotal * value / 100;
                } else if (type === 'amount') {
                    discount = value;
                }

                discount = Math.min(discount, maxDiscount);
                const newTotal = originalTotal - discount;

                // Hiển thị lại
                document.getElementById("final-total-payment").innerText = newTotal.toLocaleString('vi-VN') + " VND";
                document.getElementById("promo_code_hidden").value = code;
                document.getElementById("selected-voucher-label").innerText = code + " (-" + Math.round(discount)
                    .toLocaleString('vi-VN') + "₫)";

                // Đóng modal
                const voucherModal = bootstrap.Modal.getInstance(document.getElementById('voucherModal'));
                voucherModal.hide();
            }
        </script>
        <script>

            document.addEventListener("DOMContentLoaded", function() {
                let lastChecked = null;

                document.querySelectorAll('.clickable-voucher').forEach(radio => {
                    const label = document.querySelector(`label[for="${radio.id}"]`);
                    if (label) {
                        label.addEventListener('click', function(e) {
                            if (radio === lastChecked) {
                                // Đang click lại radio đã chọn → bỏ chọn
                                radio.checked = false;
                                lastChecked = null;
                                // Xoá text hiển thị mã đã chọn
                                document.getElementById("selected-voucher-label").innerText =
                                    "Chọn hoặc nhập mã";
                                document.getElementById("promo_code_hidden").value = "";
                                document.getElementById("final-total-payment").innerText =
                                    (parseInt(sessionStorage.getItem("ticketTotal") || 0) +
                                        parseInt(sessionStorage.getItem("foodTotal") || 0))
                                    .toLocaleString('vi-VN') + " VND";
                                e.preventDefault(); // Ngăn label click lại
                            } else {
                                lastChecked = radio;
                            }
                        });
                    }
                });
            });
        </script>
    </div>
</div>
