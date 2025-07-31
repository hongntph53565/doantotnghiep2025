@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content-top">
            <select class="cinema-select">
                <option>BHD Star 3.2</option>
                <option>BHD Star Huế</option>
                <option>BHD Star Thảo Điền</option>
            </select>
            <div class="cart-wrapper">
                <a href="{{ route('combo') }}" class="back-btn">
                    ← TRỞ LẠI
                </a>
                <div class="cart-link">
                    <a href="{{ route('cart') }}">
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
                <a href="{{ route('combo') }}" class="btn btn-success mt-3">Tiếp tục mua sắm</a>
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
                            <div class="order-item">
                                <img src="{{ asset('storage/' . $item['image']) }}" alt="Combo">
                                <div class="order-info">
                                    <p class="combo-name fs-5">{{ $item['name'] }}</p>
                                    <div class="d-flex row">
                                        <p class="combo-desc col-md-8">{{ $item['description'] }}</p>
                                        <p class="col-md-4 p-0">
                                            <span class="price fw-bold fs-5 ms-3 me-0">
                                                {{ number_format($item['price'], 3, '.', ',') }} VND
                                            </span>
                                        </p>
                                    </div>
                                    <div class="quantity-control d-flex align-items-center gap-2">
                                        <button type="button" class="btn-decrease fw-bold">-</button>
                                        <input type="text" class="qty-input text-center"
                                            data-food-id="{{ $item['food_id'] }}" data-price="{{ $item['price'] }}"
                                            value="{{ $item['quantity'] }}" />
                                        <button type="button" class="btn-increase fw-bold">+</button>

                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <hr>
                        <div class="total-row">
                            <span class="fw-bold fs-5">Tổng tiền</span>
                            <strong class="price fw-bold fs-5">
                                {{ number_format($totalAll, 3, '.', ',') }} VND
                            </strong>
                        </div>
                    </div>
                </section>
                <!-- Bên phải: Thông tin giao hàng -->
                <section class="cart-checkout">
                    <div class="checkout-box">

                        <!-- Ngày nhận hàng -->
                        <div class="checkout-row">
                            <label class="field-label">
                                <i class="fa-regular fa-calendar" style="color: #72be43;"></i> Ngày nhận hàng
                            </label>
                            <input type="date" value="2025-05-19" />
                        </div>

                        <!-- Thông tin khách hàng -->
                        <div class="customer-info">
                            <p><span class="field-label"><i class="fa-regular fa-user" style="color: #72be43;"></i>Họ
                                    tên:</span>
                                <br>Nguyen Hong
                            </p>
                            <div class="inline-fields">
                                <p><span class="field-label"><i class="fa-solid fa-phone" style="color: #75be43;"></i>
                                        SĐT:</span><br>
                                    0987654321</p>
                                <p><span class="field-label"><i class="fa-solid fa-envelope" style="color: #75be43;"></i>
                                        Email:</span><br>
                                    hongntph53565@gmail.com</p>
                            </div>
                            <p><span class="field-label"><i class="fa-solid fa-location-dot" style="color: #75be43;"></i>
                                    Cụm
                                    rạp:</span><br> BHD Star 3.2</p>
                            <p><span class="field-label"><i class="fa-solid fa-location-dot" style="color: #75be43;"></i>
                                    Địa
                                    chỉ:</span><br> Lầu 5, Siêu Thị Vincom 3/2, 3C Đường 3/2, Quận 10, TPHCM</p>
                        </div>

                        <!-- Phương thức thanh toán -->
                        <div class="payment-methods">
                            <p class="field-label"><i class="fa-solid fa-credit-card" style="color: #75be43;"></i></i> Hình
                                thức
                                thanh
                                toán</p>
                            <div class="payment-grid">
                                <label><input type="radio" name="payment" />
                                    <img src="{{ asset('images/vnpay.png') }}" alt="VNPay" />
                                    <span style="font-size: 14px;">Thanh toán qua VNPAY
                                        (Visa, Master, Amex,
                                        JCB,...)
                                    </span>
                                </label>
                                <label><input type="radio" name="payment" />
                                    <img src="{{ asset('images/momo.png') }}" alt="MoMo" /> Thanh toán bằng Ví điện tử
                                    MoMo
                                </label>
                                <label><input type="radio" name="payment" />
                                    <img src="{{ asset('images/zalopay.png') }}" alt="ZaloPay" /> Zalopay QR đa năng
                                </label>
                                <label><input type="radio" name="payment" />
                                    <img src="{{ asset('images/shopeepay.png') }}" alt="ShopeePay" /> Thanh toán qua
                                    SHOPEEPAY
                                </label>
                            </div>
                        </div>
                        <hr>
                        <!-- Xác nhận -->
                        <div class="confirm-row">
                            <label><input type="checkbox" /> Tôi đã đọc và đồng ý với <a href="#">Điều khoản thanh
                                    toán</a></label>
                            <button class="confirm-btn fw-bold">XÁC NHẬN</button>
                        </div>

                    </div>
                </section>
            </main>
        @endif
        <br><br>
        <hr>
        <button class="btn1">ƯU ĐÃI ĐẶC BIỆT</button>

        <!-- Swiper Container -->
        <div class="promo-container swiper">
            <!-- Wrapper -->
            <div class="swiper-wrapper">
                <!-- Promo 1 -->
                <div class="promo-card swiper-slide">
                    <img src="{{ asset('images/GIA-VE-48K.jpg') }}" alt="Giữ xe miễn phí" />
                    <div class="promo-content">
                        <div class="promo-title">
                            MIỄN PHÍ VÉ GỬI XE – ĐI XEM PHIM THẢ GA, KHÔNG LO PHÍ GIỮ XE
                        </div>
                        <div class="promo-desc">
                            Từ nay, đi xem phim tại BHD Star Cineplex lại càng tiện lợi và
                            tiết kiệm hơn bao giờ hết! Chúng tôi chính thức triển khai chương
                            trình <strong>MIỄN PHÍ VÉ GỬI XE</strong> dành cho tất cả khách
                            hàng khi mua vé xem phim tại rạp BHS Star – Huế.<br />📌 Áp dụng
                            cho khách […]
                        </div>
                    </div>
                </div>

                <!-- Promo 2 -->
                <div class="promo-card swiper-slide">
                    <img src="{{ asset('images/GIAI-NHIEIT-CUNG-LUMI-STAR.jpg') }}" alt="Xem phim khuyến mãi 50K" />
                    <div class="promo-content">
                        <div class="promo-title">
                            🔥 XEM PHIM KHUYA – GIÁ CỰC MÊ CHỈ TỪ 50K 🔥
                        </div>
                        <div class="promo-desc">
                            Bạn là “cú đêm” chính hiệu? Bạn muốn tìm một hoạt động thú vị sau
                            22h? BHD Star Cineplex có ngay deal hấp dẫn dành cho bạn! 🎬
                            <strong>XEM PHIM TRỄ – GIÁ CỰC MÊ</strong> 📍 Áp dụng cho tất cả
                            các suất chiếu sau 22h tại một vài cụm rạp BHD Star Cineplex 🟢
                            […]
                        </div>
                    </div>
                </div>

                <!-- Promo 3 -->
                <div class="promo-card swiper-slide">
                    <img src="{{ asset('images/GIAI-NHIEIT-CUNG-LUMI-STAR.jpg') }}" alt="Happy Day 45K" />
                    <div class="promo-content">
                        <div class="promo-title">Happy Day – Vé chỉ từ 45k</div>
                        <div class="promo-desc">
                            Vào thứ hai hàng tuần – Happy Day, giá vé
                            <strong>CHỈ TỪ 45K</strong>. Thưởng thức phim cả ngày không lo về
                            giá. Ưu đãi 45.000đ/vé áp dụng tại cụm rạp: BHD Star Phú Mỹ, BHD
                            Star Huế. Ưu đãi 50.000đ/vé áp dụng tại cụm rạp: BHD Star The
                            Garden; BHD Star Phạm Ngọc […]
                        </div>
                    </div>
                </div>
                <!-- Promo 3 -->
                <div class="promo-card swiper-slide">
                    <img src="{{ asset('images/HAPPY-DAY-2.jpg') }}" alt="Happy Day 45K" />
                    <div class="promo-content">
                        <div class="promo-title">Happy Day – Vé chỉ từ 45k</div>
                        <div class="promo-desc">
                            Vào thứ hai hàng tuần – Happy Day, giá vé
                            <strong>CHỈ TỪ 45K</strong>. Thưởng thức phim cả ngày không lo về
                            giá. Ưu đãi 45.000đ/vé áp dụng tại cụm rạp: BHD Star Phú Mỹ, BHD
                            Star Huế. Ưu đãi 50.000đ/vé áp dụng tại cụm rạp: BHD Star The
                            Garden; BHD Star Phạm Ngọc […]
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation + Pagination -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>


    </div>
@endsection

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
        document.querySelectorAll('.btn-increase, .btn-decrease').forEach(btn => {
            btn.addEventListener('click', function() {
                console.log('Clicked!');
            });

            btn.addEventListener('click', async function() {
                const wrapper = this.closest('.quantity-control');
                const input = wrapper.querySelector('.qty-input');
                const foodId = input.dataset.foodId;
                let quantity = parseInt(input.value);

                // Tăng/giảm
                if (this.classList.contains('btn-increase')) {
                    quantity++;
                } else {
                    quantity--; // Cho giảm về 0 để xóa
                }

                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                try {
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
                            const orderItem = input.closest('.order-item');
                            orderItem.remove();

                            // Nếu không còn sản phẩm nào thì reload trang
                            if (document.querySelectorAll('.order-item').length === 0) {
                                location.reload();
                            }
                        } else {
                            input.value = quantity;
                        }

                        document.querySelector('.total-row .price').textContent = result.totalAll;
                    }


                } catch (err) {
                    console.error('Lỗi cập nhật giỏ hàng:', err);
                }
            });
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
