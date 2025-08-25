<div class="container mb-5">
    <div class="container-combo">

        <hr>
        @if (session('success_cash'))
            <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content text-center p-4">
                        <div class="modal-body">
                            <i class="fa-solid fa-circle-check fa-3x text-success mb-3"></i>
                            <h5 class="mb-3">Đặt vé thành công</h5>
                            <a href="{{ route('staff.search_ticket_online') }}" class="btn btn-success fw-bold">Lấy
                                vé</a>

                        </div>
                    </div>
                </div>
            </div>


            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const successModal = new bootstrap.Modal(document.getElementById('successModal'));
                    successModal.show();
                });
            </script>
        @endif
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

                {{-- <div class="payment-option">
                    <input type="radio" name="payment" id="payos">
                    <label for="payos">
                        <img src="{{ asset('images/payos.png') }}" alt="MoMo">
                        <span>Thanh toán bằng Payos</span>
                    </label>
                </div> --}}

                <div class="payment-option">
                    <input type="radio" name="payment" id="zalopay">
                    <label for="zalopay">
                        <img src="{{ asset('images/zalopay.png') }}" alt="ZaloPay">
                        <span>Zalopay QR đa năng</span>
                    </label>
                </div>
                @if (Auth::check() && Auth::user()->role_id == 3)
                    <div class="payment-option">
                        <input type="radio" name="payment" value="cash" id="cash">
                        <label for="cash">
                            <i class="fa-solid fa-money-bill-wave" style="font-size: 20px; color: #75be43;"></i>
                            <span style="font-size: 14px;">Thanh toán tiền mặt</span>
                        </label>
                    </div>
                @endif






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
                <div class="d-flex justify-content-between align-items-center p-3 border rounded" role="button"
                    data-bs-toggle="modal" data-bs-target="#voucherModal">
                    <div>
                        <i class="bi bi-ticket-perforated"></i> <strong>Mã ưu đãi</strong>
                    </div>
                    <div>
                        <span id="selected-voucher-label">Chọn mã</span> <i class="bi bi-chevron-right"></i>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="voucherModal" tabindex="-1" aria-labelledby="voucherModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">MÃ ƯU ĐÃI</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                        </div>
                        <div class="modal-body">
                            <div id="voucher-error-message" class="text-danger small mb-3"></div>
                            <div id="voucher-list">
                                @forelse ($promotions as $promo)
                                    @php
                                        $isExpired = now()->lt($promo->start_date) || now()->gt($promo->end_date);
                                        $isUsedUp = $promo->used_count >= $promo->max_uses;
                                        $isActive = $promo->status === 'active' && !$isExpired && !$isUsedUp;
                                    @endphp

                                    <div
                                        class="voucher-option mb-2 p-2 border {{ $isActive ? '' : 'bg-light text-muted' }}">
                                        <img src="{{ asset('images/logo.jpg') }}" alt="Voucher icon">
                                        <input type="radio" name="voucher" id="voucher_{{ $loop->index }}"
                                            class="d-none clickable-voucher" value="{{ $promo->discount_code }}"
                                            data-type="{{ $promo->type_discount }}"
                                            data-value="{{ $promo->discount_value }}"
                                            data-max="{{ $promo->max_discount }}"
                                            data-min="{{ $promo->min_order_value }}"
                                            {{ $isActive ? '' : 'disabled' }}>
                                        <label for="voucher_{{ $loop->index }}"
                                            class="voucher-label border rounded p-2 d-block {{ $isActive ? '' : 'opacity-50' }}">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <strong class="voucher-code">{{ $promo->discount_code }}</strong>
                                                <div class="voucher-discount">
                                                    {{ $promo->type_discount == 'percent'
                                                        ? $promo->discount_value . '%'
                                                        : number_format($promo->discount_value) . '₫' }}
                                                </div>
                                            </div>
                                            <div class="voucher-min-order mt-1 small">
                                                Đơn tối thiểu: {{ number_format($promo->min_order_value) }} VND
                                            </div>

                                            {{-- Thông báo trạng thái --}}
                                            @if ($isExpired)
                                                <div class="text-danger small">⛔ Hết hạn</div>
                                            @elseif ($isUsedUp)
                                                <div class="text-danger small">⛔ Đã hết lượt sử dụng</div>
                                            @else
                                                <div class="text-success small">✅ Còn hiệu lực</div>
                                            @endif

                                            {{-- Nếu voucher theo loại thẻ --}}
                                            @if ($promo->card_type)
                                                <div class="voucher-card-type mt-1 text-info small">
                                                    Dành cho thẻ: {{ ucfirst($promo->card_type) }}
                                                </div>
                                            @endif
                                        </label>
                                    </div>
                                @empty
                                    <p class="text-muted">Không có mã ưu đãi nào cho loại thẻ của bạn.</p>
                                @endforelse

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
                    <input type="hidden" name="movie_id" value="{{ $movie->movie_id }}">

                    <a href="javascript:void(0);" class="btn-checkout" onclick="submitCheckout()">THANH TOÁN
                        (4/4)</a>
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

            
                let finalTotal = originalTotal;
               
                document.getElementById("showtime_id").value = showtimeId;
                document.getElementById("payment_method").value = paymentMethod;
                document.getElementById("total_price_hidden").value = Math.round(finalTotal); 
                document.getElementById("selected_seats").value = JSON.stringify(seatIds);
                document.getElementById("selected_foods").value = JSON.stringify(selectedFoods);
                document.getElementById("promo_code_hidden").value = selectedVoucher ? selectedVoucher.code : "";

                document.getElementById("checkout-form").submit();
            }


            
            let selectedVoucher = null;

            function applyVoucher() {
                const checkedRadio = document.querySelector('input[name="voucher"]:checked');
                if (!checkedRadio) {
                    alert("Vui lòng chọn mã.");
                    return;
                }

                let code = checkedRadio.value;
                let type = checkedRadio.getAttribute("data-type");
                let value = parseFloat(checkedRadio.getAttribute("data-value"));
                let maxDiscount = parseFloat(checkedRadio.getAttribute("data-max")) || Infinity;
                let minOrder = parseFloat(checkedRadio.getAttribute("data-min")) || 0;

                const ticketTotal = parseInt(sessionStorage.getItem("ticketTotal")) || 0;
                const foodTotal = parseInt(sessionStorage.getItem("foodTotal")) || 0;
                const originalTotal = ticketTotal + foodTotal;

                
                if (originalTotal < minOrder) {
                    document.getElementById("voucher-error-message").innerText =
                        `Đơn hàng tối thiểu: ${minOrder.toLocaleString('vi-VN')} VND để áp dụng mã này.`;
                    return;
                } else {
                    document.getElementById("voucher-error-message").innerText = "";
                }

                
                let discount = (type === 'percent') ? originalTotal * value / 100 : value;
                discount = Math.min(discount, maxDiscount);
                const newTotal = originalTotal - discount;

               
                document.getElementById("final-total-payment").innerText =
                    newTotal.toLocaleString('vi-VN') + " VND";
                document.getElementById("selected-voucher-label").innerText =
                    code + " (-" + Math.round(discount).toLocaleString('vi-VN') + "₫)";

                
                selectedVoucher = {
                    code
                };
            }

            
            document.addEventListener("DOMContentLoaded", function() {
                let lastChecked = null;
                document.querySelectorAll('.clickable-voucher').forEach(radio => {
                    const label = document.querySelector(`label[for="${radio.id}"]`);
                    if (label) {
                        label.addEventListener('click', function(e) {
                            if (radio === lastChecked) {
                                radio.checked = false;
                                lastChecked = null;

                                document.getElementById("selected-voucher-label").innerText =
                                    "Chọn mã giảm giá";
                                document.getElementById("promo_code_hidden").value = "";
                                document.getElementById("final-total-payment").innerText =
                                    (parseInt(sessionStorage.getItem("ticketTotal") || 0) +
                                        parseInt(sessionStorage.getItem("foodTotal") || 0))
                                    .toLocaleString('vi-VN') + " VND";

                                selectedVoucher = null; 
                                e.preventDefault();
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
