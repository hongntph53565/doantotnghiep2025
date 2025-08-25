@extends('layouts.staff')


@push('styles')
    <style>
        /* Font chữ */
        body {
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            color: #222;
        }

        /* ---------- TOP SECTION (Rạp + Cart) ---------- */

        .content-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
            margin-bottom: 30px;
        }

        /* Dropdown chọn rạp */
        .cinema-select {
            padding: 10px 14px;
            font-size: 16px;
            border-radius: 6px;
            border: 1px solid #ccc;
            background-color: #fff;
            color: #333;
        }

        /* Wrapper chứa nút quay lại + giỏ */
        .cart-wrapper {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        /* Nút trở lại */
        .back-btn {
            font-weight: 600;
            font-size: 15px;
            color: #222;
            text-decoration: none;
            padding: 8px 14px;
            border: 1px solid #ccc;
            border-radius: 6px;
            transition: background-color 0.2s ease;
        }

        .back-btn:hover {
            background-color: #f1f1f1;
        }

        .cart-link {
            position: relative;
            background-color: #72BE43;
            /* nền xanh lá */
            border-radius: 50%;
            width: 48px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }

        .cart-link:hover {
            background-color: #5ca836;
        }

        .cart-icon img {
            width: 24px;
            height: 24px;
            filter: brightness(0) invert(1);
            /* chuyển icon thành trắng */
        }

        /* Badge hiển thị số lượng */
        .cart-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            background-color: #fff;
            color: #72BE43;
            font-size: 12px;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 50%;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }


        /* ---------- COMBO CARD STYLE ---------- */

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: none;
        }

        .card-img-top {
            height: 220px;
            object-fit: cover;
            border-bottom: 1px solid #eee;
        }

        .card-title {
            font-weight: 600;
            font-size: 1.1rem;
            color: #72BE43;
            margin-bottom: 10px;
            transition: color 0.2s ease;
        }

        /* Hover: đổi màu tiêu đề sang đen (KHÔNG áp dụng trên .card:hover mà tách riêng) */
        .card-title:hover {
            color: #000;
        }

        /* Mô tả combo */
        .card-text {
            font-size: 16px;
            color: #222;
            margin-bottom: 6px;
        }

        /* Giá */
        .card-text.fw-bold.text-success {
            font-size: 15px;
        }

        /* Nút MUA NGAY */
        .btn.btn-success {
            background-color: #8beef1;
            border: none;
            font-weight: 600;
            border-radius: 6px;
            padding: 8px 20px;
            font-size: 14px;
            color: white;
            transition: none;
        }

        /* Hover đổi màu nền và chữ */
        .btn.btn-success:hover {
            background-color: #5ca836;
            color: white;
        }

        /* Căn giữa */
        .card-body {
            text-align: center;
        }

        .section-title {
            background-color: white;
            border: 2px solid #99e0c6;
            color: #050505;
            font-weight: bold;
            padding: 6px 20px;
            display: inline-block;
            border-radius: 6px;
            margin: 30px 0 20px;
        }

        /* Container chứa giá và nút MUA NGAY */
        .price-buy-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        /* Giá tiền bên trái */
        .combo-price {
            text-align: left;
        }

        /* Màu gạch giá cũ */
        .combo-price del {
            color: #555;
            font-size: 13px;
            display: block;
            margin-bottom: 4px;
        }

        /* Màu giá khuyến mãi */
        .combo-price .text-success {
            color: #222;
            font-weight: bold;
            font-size: 15px;
        }

        /* Nút mua ngay */
        .btn-buy-now {
            background-color: #9ddfc7;
            color: #222;
            font-weight: bold;
            font-size: 16px;
            padding: 8px 18px;
            border-radius: 6px;
            border: none;
            transition: background-color 0.2s ease;
        }

        .btn-buy-now:hover {
            background-color: #71aa54;
            color: white;
        }

        .btn-delete-item {
            background-color: #000;
            border: none;
            border-radius: 50%;
            width: 28px;
            height: 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            transition: background-color 0.2s;
        }

        .btn-delete-item:hover {
            background-color: #444;
        }
    </style>
@endpush
@push('styles')
    <style>
        p.col-md-5.p-0 {
            padding: 0 !important;
            margin: 0 !important;
            display: block;
        }

        .cart-container {
            padding-top: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
        }

        .cart-summary,
        .cart-checkout {
            flex: 1 1 400px;
        }

        .order-box,
        .checkout-box {
            padding: 1.5rem;
            border-radius: 10px;
            border: 1px solid #eeeeee;
        }

        .order-title {
            color: #72BE43;
        }

        .order-method {
            background: #91D3B0;
            color: white;
            padding: 9px 15px;
            border-radius: 10px;
            display: inline-block;
            margin-bottom: 1rem;
        }

        .order-method:hover {
            background: #72be43;
        }

        .order-item {
            display: flex;
            gap: 1rem;
            align-items: flex-start;
            margin-bottom: 40px;
            flex-wrap: wrap;
        }

        .order-item img {
            width: 70px;
            height: auto;
            flex-shrink: 0;
            object-fit: contain;
            margin-top: 50px;
        }

        .order-info {
            flex: 1;
            min-width: 250px;
        }

        @media (max-width: 768px) {
            .order-item {
                flex-direction: column;
                align-items: center;
                text-align: left;
            }

            .order-item img {
                width: 120px;
                margin-bottom: 1rem;
            }

            .order-info {
                width: 100%;
                text-align: left;
            }
        }

        .combo-name {
            font-weight: bold;
            color: #72BE43;
            margin-bottom: 0.25rem;
        }

        .combo-desc {
            margin-bottom: 0.5rem;
        }

        .strike {
            text-decoration: line-through;
            color: #888;
        }

        .price {
            color: #72BE43;
        }

        .quantity-control {
            display: flex;
            align-items: center;
            margin-top: 0.5rem;
            gap: 0px !important;
        }

        button,
        input {
            border: none;
            outline: none;
            /* (tuỳ chọn) để bỏ viền khi focus */
        }

        .quantity-control button {
            width: 30px;
            height: 30px;
            cursor: pointer;
            background-color: #f4f5f6;

        }

        .quantity-control input {
            width: 40px;
            height: 30px;
            text-align: center;
            background-color: #f4f5f6;

        }

        .total-row {
            padding-top: 1rem;
            display: flex;
            justify-content: space-between;
        }

        .customer-info p,
        .payment-methods p,
        .payment-methods label {
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .payment-methods label {
            display: block;
        }

        .confirm-row {
            margin-top: 1.5rem;
        }

        .confirm-row label {
            font-size: 0.85rem;
            display: block;
            margin-bottom: 1rem;
        }

        .confirm-row a {
            color: #72BE43;
            text-decoration: underline;
        }

        .confirm-btn {
            width: 100%;
            padding: 0.7rem;
            background: #91D3B0;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }

        .confirm-btn:hover {
            background: #72be43;
        }

        @media (max-width: 768px) {
            .cart-container {
                flex-direction: column;
            }

            .order-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .quantity-control {
                justify-content: flex-start;
            }
        }

        .field-label {
            font-weight: normal;
            color: #72BE43;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        .checkout-row {
            margin-bottom: 1rem;
            display: flex;
            justify-content: space-between;
        }

        .checkout-row input[type="date"] {
            margin-top: 0.5rem;
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 0.95rem;
            width: 250px;
        }

        .customer-info p {
            margin: 0.5rem 0;
            font-weight: bold;
        }

        .inline-fields {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .inline-fields p {
            flex: 1 1 45%;
        }

        .payment-methods {
            margin-top: 1rem;
        }

        .payment-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.8rem;
            margin-top: 0.5rem;
        }

        .payment-grid label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            border: 1px solid #ccc;
            padding: 0.6rem;
            border-radius: 6px;
            cursor: pointer;
        }

        .payment-grid img {
            width: 30px;
            height: 30px;
        }

        .payment-grid input[type="radio"] {
            accent-color: #72BE43;
        }

        .icon-calendar::before {
            content: "📅";
        }

        .icon-user::before {
            content: "👤";
        }

        .icon-phone::before {
            content: "📞";
        }

        .icon-mail::before {
            content: "✉️";
        }

        .icon-location::before {
            content: "📍";
        }

        .icon-home::before {
            content: "🏠";
        }

        .icon-wallet::before {
            content: "💳";
        }

        @media (max-width: 768px) {
            .inline-fields {
                flex-direction: column;
            }

            .payment-grid {
                grid-template-columns: 1fr;
            }
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            background: #f8f8f8;
            border-bottom: 1px solid #e0e0e0;
            flex-wrap: wrap;
        }

        .cinema-select {
            padding: 0.5rem 1rem;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 1rem;
        }

        .top-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        /* Responsive */
        @media (max-width: 600px) {
            .top-bar {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.8rem;
            }

            .top-actions {
                align-self: flex-end;
            }
        }
    </style>
    <style>
        /* Biến container promo thành swiper */
        .promo-container {
            width: 100%;
            overflow: hidden;
            position: relative;
        }

        /* Gộp từng promo-card thành slide */
        .promo-container .swiper-wrapper {
            display: flex;
        }

        .promo-container .swiper-slide {
            flex-shrink: 0;
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
        }

        /* Điều chỉnh hiển thị trên các màn hình lớn */
        @media (min-width: 768px) {
            .promo-container .swiper-slide {
                width: 50%;
            }
        }

        @media (min-width: 1024px) {
            .promo-container .swiper-slide {
                width: 33.3333%;
            }
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: white !important;
            padding: 20px;
            border-radius: 50%;
            width: 90px;
            height: 90px;
            top: 50%;
            transform: translateY(-50%);
            opacity: 0;
            transition: all 0.3s ease;
            z-index: 20;
            position: absolute;
            cursor: pointer;
            pointer-events: auto;
            /* ✅ Cho phép click */
        }

        /* Mặc định ẩn nút */
        .promo-container .swiper-button-next,
        .promo-container .swiper-button-prev {
            opacity: 0;
            visibility: hidden;
        }

        /* Khi hover thì hiện ra */
        .promo-container:hover .swiper-button-next,
        .promo-container:hover .swiper-button-prev {
            opacity: 1;
            visibility: visible;
        }


        /* Swiper bullets */
        .swiper-pagination-bullet {
            width: 12px !important;
            height: 12px !important;
            margin: 0 6px !important;
            background-color: #bbb !important;
            border-radius: 50% !important;
            opacity: 1 !important;
            transition: all 0.3s ease !important;
        }

        .swiper-pagination-bullet-active {
            background-color: #72BE43 !important;
            transform: scale(1.2);
        }
    </style>
@endpush





@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const dateInput = document.getElementById('delivery-date');
    const today = new Date().toISOString().split('T')[0];
    if (dateInput) {
        dateInput.setAttribute('min', today);
        if (!dateInput.value) {
            dateInput.value = today;
        }
    }

    // Tăng / Giảm số lượng
    document.querySelectorAll('.btn-increase, .btn-decrease').forEach(button => {
        button.addEventListener('click', async function() {
            const wrapper = this.closest('.quantity-control');
            const input = wrapper.querySelector('.qty-input');
            const foodId = input.dataset.foodId;
            const price = parseInt(input.dataset.price);
            let quantity = parseInt(input.value);

            if (this.classList.contains('btn-increase')) {
                quantity++;
            } else {
                quantity = Math.max(0, quantity - 1);
            }

            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const response = await fetch("{{ route('cart.update') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({
                    food_id: foodId,
                    quantity: quantity
                })
            });

            const result = await response.json();

            if (result.success) {
                if (result.removed) {
                    wrapper.closest('.order-item').remove();
                    if (document.querySelectorAll('.order-item').length === 0) {
                        location.reload();
                    }
                } else {
                    input.value = quantity;
                    const priceEl = wrapper.closest('.order-item').querySelector('.price');
                    priceEl.textContent = (price * quantity).toLocaleString('vi-VN') + ' VND';
                }

                document.querySelector('.total-row .price').textContent = result.totalAll;

                const cartBadge = document.querySelector('.cart-badge');
                if (cartBadge && result.totalQuantity !== undefined) {
                    cartBadge.textContent = result.totalQuantity;
                }
            }
        });
    });

    // ✅ Đặt hàng
    const confirmBtn = document.querySelector('.confirm-btn');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function(e) {
            e.preventDefault();

            const selectedPayment = document.querySelector('input[name="payment"]:checked');
            if (!selectedPayment) {
                alert('Vui lòng chọn phương thức thanh toán');
                return;
            }
            document.getElementById('payment_method').value = selectedPayment.value;

            const foodData = [];
            document.querySelectorAll('.qty-input').forEach(input => {
                const qty = parseInt(input.value);
                if (qty > 0) {
                    foodData.push({
                        food_id: input.dataset.foodId,
                        qty: qty
                    });
                }
            });
            document.getElementById('selected_foods_input').value = JSON.stringify(foodData);

            const totalText = document.querySelector('.total-row .price').textContent.replace(/[^\d]/g, '');
            document.getElementById('total_price_hidden').value = parseInt(totalText);

            document.getElementById('food-only-form').submit();
        });
    }
});

    </script>
    <!-- SwiperJS CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- SwiperJS JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        const swiper = new Swiper('.promo-container.swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            },
            breakpoints: {
                768: {
                    slidesPerView: 2
                },
                1024: {
                    slidesPerView: 3
                }
            }
        });
    </script>
@endpush
@section('content')
    <div class="container">
        <hr>
              @if (session('success_cash'))
    <!-- Modal -->
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center p-4">
                <div class="modal-body">
                    <i class="fa-solid fa-circle-check fa-3x text-success mb-3"></i>
                    <h5 class="mb-3">Đặt đồ ăn thành công</h5>
                    <a href="{{ route('staff.cart.clearAndRedirect') }}" class="btn btn-success fw-bold">Lấy vé</a>

                </div>
            </div>
        </div>
    </div>

    <!-- Auto show modal -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        });
    </script>
@endif
        <div class="content-top">
            <form method="GET" action="{{ route('staff.combo') }}">
                <select class="cinema-select" name="cinema_id" onchange="this.form.submit()">
                    <option value="">Chọn rạp</option>
                    @foreach ($cinemas as $cinema)
                        <option value="{{ $cinema->cinema_id }}" {{ $cinemaId == $cinema->cinema_id ? 'selected' : '' }}>
                            {{ $cinema->name }}
                        </option>
                    @endforeach
                </select>
            </form>
            <div class="cart-wrapper">
                <a href="{{ route('staff.combo') }}" class="back-btn">
                    ← TRỞ LẠI
                </a>
                <div class="cart-link">
                    <a href="{{ route('cart', ['cinema_id' => $cinemaId]) }}">
                        <div class="cart-icon">
                            <img src="{{ asset('images/cart.svg') }}" alt="">
                        </div>
                    </a>

                    <div class="cart-badge">{{ $totalQuantity }}</div>
                </div>
            </div>
        </div>
        @if (empty($cart))
            <div id="empty-cart-message" class="text-center py-5">
                <h5 class="text-muted">Giỏ hàng của bạn đang trống.</h5>
                <a href="{{ route('staff.combo') }}" class="btn btn-success mt-3">Tiếp tục mua sắm</a>
            </div>
        @else
            <main class="cart-container">
                <section class="cart-summary">
                    <div class="order-box">
                        <h3 class="order-title fs-5 fw-bold">Chi tiết đơn hàng</h3>
                        <hr>
                        <span class="order-method fw-bold">NHẬN TẠI RẠP</span>

                        @php $totalAll = 0; @endphp

                        @foreach ($cart as $item)
                            @php
                                $total = $item['price'] * $item['quantity'];
                                $totalAll += $total;
                            @endphp
                            <div class="order-item d-flex align-items-center gap-3 mb-3">
                                <img src="{{ asset('storage/' . $item['image']) }}" alt="Combo"
                                    style="width: 80px; height: 100px; object-fit: cover; border-radius: 5px;">

                                <div class="order-info flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <p class="combo-name fs-5 fw-semibold mb-1">{{ $item['name'] }}</p>

                                        <!-- 🔴 Nút xoá sản phẩm -->
                                        <form action="{{ route('cart.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="food_id" value="{{ $item['food_id'] }}">
                                            <button type="submit" class="btn-delete-item">
                                                <i class="fa-solid fa-xmark text-white"></i>
                                            </button>
                                        </form>
                                    </div>

                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <p class="combo-desc mb-0 text-muted">{{ $item['description'] }}</p>
                                        <span class="price fw-bold fs-5">
                                            {{ number_format($item['price'], 0, '.', ',') }} VND
                                        </span>
                                    </div>

                                    <div class="quantity-control d-flex align-items-center gap-2 mt-2">
                                        <button type="button" class="btn-decrease fw-bold">-</button>
                                        <input type="text" class="qty-input text-center"
                                            data-food-id="{{ $item['food_id'] }}" data-price="{{ $item['price'] }}"
                                            value="{{ $item['quantity'] }}" style="width: 50px;" />
                                        <button type="button" class="btn-increase fw-bold">+</button>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <hr>
                        <div class="d-flex justify-content-between align-items-center total-row mt-3">
                            <span class="fw-bold fs-5">Tổng tiền</span>
                            <strong class="price fw-bold fs-5">
                                {{ number_format($totalAll, 0, '.', ',') }} VND
                            </strong>
                        </div>
                    </div>
                </section>


                <!-- Bên phải: Thông tin giao hàng -->
                <section class="cart-checkout">
                    <div class="checkout-box">

                      

                        <div class="customer-info">
                    
                            @if ($selectedCinema)
                                <p><span class="field-label"><i class="fa-solid fa-location-dot"
                                            style="color: #75be43;"></i>
                                        Cụm rạp:</span><br>
                                    {{ $selectedCinema->name }}
                                </p>
                                <p><span class="field-label"><i class="fa-solid fa-location-dot"
                                            style="color: #75be43;"></i>
                                        Địa chỉ:</span><br>
                                    {{ $selectedCinema->address_detail }}
                                </p>
                            @else
                                <p class="text-danger mt-2">Vui lòng chọn rạp để hiển thị thông tin cụm rạp.</p>
                            @endif
                        </div>


                        <!-- Phương thức thanh toán -->
                        <div class="payment-methods">
                            <p class="field-label"><i class="fa-solid fa-credit-card" style="color: #75be43;"></i></i> Hình
                                thức
                                thanh
                                toán</p>
                            <div class="payment-grid">
                                <label><input type="radio" name="payment" value="vnpay" id="vnpay">
                                    <img src="{{ asset('images/vnpay.png') }}" alt="VNPay" />
                                    <span style="font-size: 14px;">Thanh toán qua VNPAY</span>
                                </label>
                                <label><input type="radio" name="payment" value="payos" id="payos">
                                    <img src="{{ asset('images/momo.png') }}" alt="PayOS" /> Thanh toán bằng PayOS
                                </label>
                                <label><input type="radio" name="payment" value="zalopay" id="zalopay">
                                    <img src="{{ asset('images/zalopay.png') }}" alt="ZaloPay" /> Zalopay QR đa năng
                                </label>
                                 <label>
            <input type="radio" name="payment" value="cash" id="cash">
            <i class="fa-solid fa-money-bill-wave" style="font-size: 20px; color: #75be43;"></i>
            <span style="font-size: 14px;">Thanh toán tiền mặt</span>
        </label>
                            </div>
                        </div>
                        <hr>
                        <!-- Xác nhận -->
                        <div class="confirm-row">
                            <label><input type="checkbox" /> Tôi đã đọc và đồng ý với <a href="#">Điều khoản thanh
                                    toán</a></label>
                            <form id="food-only-form" action="{{ route('booking.foodOnly') }}" method="POST">
                                @csrf
                                <input type="hidden" name="user_id" value="{{ Auth::user()->user_id }}">
                                <input type="hidden" name="payment_method" id="payment_method">
                                <input type="hidden" name="total_price" id="total_price_hidden">
                                <input type="hidden" name="selected_foods" id="selected_foods_input">
                                <input type="hidden" name="promo_code" id="promo_code_hidden">

                                <button type="submit" class="confirm-btn fw-bold">XÁC NHẬN</button>
                            </form>
                        </div>

                    </div>
                </section>
            </main>
        @endif
        <br><br>

    </div>
@endsection
