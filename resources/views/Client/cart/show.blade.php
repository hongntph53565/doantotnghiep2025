@extends('layouts.app')

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
    </style>
    <style>
        .qty-input:focus {
            outline: none;
            box-shadow: none;
            border: none;
        }

        /* Tiêu đề combo: giới hạn 2 dòng */
        .combo-title {
            font-weight: bold;
            font-size: 16px;
            line-height: 1.3;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* Giới hạn 2 dòng */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Mô tả combo: giới hạn 2 dòng */
        .combo-desc {
            font-size: 14px;
            color: #666;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* Giới hạn 2 dòng */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Bắt buộc cho Swiper hoạt động đúng */
        .swiper-slide {
            width: auto;
            /* Không cho Swiper ép width */
            display: flex;
            justify-content: center;
        }

        /* Combo phải có kích thước rõ ràng */
        .combo-card {
            width: 100%;
            margin-bottom: 70px;
            /* Để combo tự giãn trong slide */
            max-width: 300px;
            /* Combo không bị quá to */
        }


        .color {
            color: #72be43;
        }

        .addToCart {
            border: 1px solid #666666;
            background-color: white;
            color: #666666;
            border-radius: 10px;
            padding: 10px;

        }

        .addToCart:hover {
            color: white;
            background-color: #72be43;
            border: 1px solid #72be43;
        }

        .text-dark {
            line-height: 1.6;
        }

        .quantity-box {
            width: 100px;
            overflow: hidden;
            background-color: #F4F5F6;
            text-align: center;
        }

        .quantity-box button {
            width: 30px;
            height: 30px;
            text-align: center;
            border: none;
            background-color: #F4F5F6;

        }

        .quantity-box input.qty-input {
            width: 30px;
            height: 30px;
            border: none;
            background-color: #F4F5F6;


        }

        .btn-buy-now {
            background-color: #91d3b0;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 24px;
            font-weight: 600;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
            transition: 0.3s ease;
        }

        .btn-buy-now:hover {
            background-color: #72be43;
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
@section('content')
    <div class="container">
        <div class="content-top">
            <form method="GET" action="{{ route('combo.show', $combo->food_id) }}">
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
                <a href="{{ route('combo', ['cinema_id' => $cinemaId]) }}" class="back-btn">← TRỞ LẠI</a>

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

        <div class="combo-container">
            <!-- Nhúng Google Fonts -->
            <link href="https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;600;700&display=swap"
                rel="stylesheet">

            <div class="container-fluid my-5" style="font-family: 'Be Vietnam Pro', sans-serif;">
                <div class="row align-items-start">
                    <!-- Cột trái: hình ảnh -->
                    <div class="col-md-6">
                        <img src="{{ asset('storage/' . $combo->image) }}" alt="Combo" style="width:100%">
                    </div>

                    <!-- Cột phải: thông tin combo -->
                    <div class="col-md-6">
                        <div class="product-details">
                            <h5 class="fw-bold fs-4 mb-4 color">{{ $combo->name }}</h5>

                            <p class="text-dark mb-4">{{ $combo->description }}</p>

                            <hr>

                            <div class="d-flex justify-content-between mb-4">
                                <span class="text-muted">Giá bán</span>
                                <span class="fw-bold fs-5 color" id="unit-price"
                                    data-price="{{ $combo->price }}">{{ number_format($combo->price, 0, '.', ',') }}
                                    VND</span>
                            </div>

                            <!-- Form thêm vào giỏ -->
                            <form action="{{ route('cart.addCart') }}" method="POST" id="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="food_id" value="{{ $combo->food_id }}">
                                <input type="hidden" name="cinema_id" value="{{ $cinemaId }}">

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="text-muted">Số lượng</span>
                                    <div class="quantity-box">
                                        <button class="minus-btn">-</button>
                                        <input type="text" name="quantity" id="quantity" class="text-center qty-input"
                                            value="1">
                                        <button class="plus-btn">+</button>
                                    </div>
                                </div>

                                <hr>

                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <span class="text-muted">Tổng tiền</span>
                                    <span class="fw-bold fs-5 color" id="total-price">
                                        {{ number_format($combo->price, 0, '.', ',') }} VND
                                    </span>

                                </div>

                                <hr>

                                <div class="d-flex justify-content-end gap-3">
                                    <button type="submit" name="action" value="add"
                                        class="addToCart fw-semibold btn btn-outline-primary">THÊM VÀO
                                        GIỎ</button>
                                    <button type="submit" name="action" value="buy_now"
                                        class="btn-buy-now btn btn-primary">MUA NGAY</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>


        </div>


        <div class="text-center">
            <div class="section-title">Sản phẩm liên quan</div>
        </div>


        <div class="row mt-4">
            @foreach ($relatedCombos as $combo)
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="{{ asset('storage/' . $combo->image) }}" class="card-img-top" alt="{{ $combo->name }}">
                        <div class="card-body">
                            <h5 class="card-title">{{ $combo->name }}</h5>
                            <p class="card-text">{{ $combo->description }}</p>
                            <div class="price-buy-row d-flex justify-content-between align-items-center">
                                <div class="combo-price text-start">
                                    {{-- <del>{{ number_format($combo->original_price, 0, '.', ',') }} VND</del><br> --}}
                                    <br>
                                    <span class="text-success fw-bold">{{ number_format($combo->price, 0, '.', ',') }}
                                        VND</span>
                                </div>
                                {{-- <form action="{{ route('cart.addCart') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="food_id" value="{{ $combo->food_id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="action" value="buy_now">
                                        <button type="submit" class="btn-buy-now">MUA NGAY</button>
                                    </form> --}}
                                <a href="{{ route('combo.show', ['id' => $combo->food_id, 'cinema_id' => request('cinema_id')]) }}"
                                    class="btn btn-primary btn-buy-now">MUA NGAY</a>


                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>





    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const plusBtn = document.querySelector('.plus-btn');
            const minusBtn = document.querySelector('.minus-btn');
            const qtyInput = document.querySelector('#quantity');
            const totalPrice = document.querySelector('#total-price');
            const priceElement = document.querySelector('#unit-price');

            if (!plusBtn || !minusBtn || !qtyInput || !totalPrice || !priceElement) {
                console.warn("Thiếu phần tử HTML cần thiết.");
                return;
            }

            const pricePerItem = parseFloat(priceElement.dataset.price);

            function formatVND(value) {
                return value.toLocaleString('vi-VN') + ' VND';
            }

            function updateTotal() {
                let qty = parseInt(qtyInput.value);
                if (isNaN(qty) || qty < 1) qty = 1;
                qtyInput.value = qty;
                const total = qty * pricePerItem;
                totalPrice.textContent = formatVND(total);
            }

            plusBtn.addEventListener('click', function(e) {
                e.preventDefault();
                qtyInput.value = parseInt(qtyInput.value || 1) + 1;
                updateTotal();
            });

            minusBtn.addEventListener('click', function(e) {
                e.preventDefault();
                const qty = Math.max(1, parseInt(qtyInput.value || 1) - 1);
                qtyInput.value = qty;
                updateTotal();
            });

            qtyInput.addEventListener('input', updateTotal);

            updateTotal(); // initial run
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
        new Swiper('.combo-swiper', {
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
                576: {
                    slidesPerView: 2
                },
                768: {
                    slidesPerView: 3
                },
                1200: {
                    slidesPerView: 4
                }
            }
        });
    </script>
@endpush
