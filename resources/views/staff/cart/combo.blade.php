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
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="content-top">
            {{-- Form chọn rạp --}}
            <form method="GET" action="{{ route('staff.combo') }}">

                <select class="cinema-select" name="cinema_id" onchange="this.form.submit()">
                    <option value="">Chọn rạp</option>
                    @foreach ($cinemas as $cinema)
                        <option value="{{ $cinema->cinema_id }}" {{ (request('cinema_id') == $cinema->cinema_id) ? 'selected' : '' }}>
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
                    <a href="{{ route('staff.cart') }}">
                        <div class="cart-icon">
                            <img src="{{ asset('images/cart.svg') }}" alt="">
                        </div>
                    </a>
                    <div class="cart-badge">{{ $totalQuantity }}</div>
                </div>
            </div>
        </div>

        <div class="text-center">
            <div class="section-title">Đồ ăn - Combo</div>
        </div>

        {{-- Nếu chưa chọn rạp --}}
        @if (!request('cinema_id'))
            <div class="alert alert-warning text-center mt-4">
                Vui lòng chọn rạp để xem danh sách combo đồ ăn.
            </div>

        {{-- Nếu đã chọn rạp nhưng không có combo --}}
        @elseif(isset($combos) && count($combos) === 0)
            <div class="alert alert-info text-center mt-4">
                Hiện không có combo nào cho rạp này.
            </div>

        {{-- Nếu có combo --}}
        @elseif(isset($combos) && count($combos))
            <div class="row mt-4">
                @foreach ($combos as $combo)
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
                                        <span class="text-success fw-bold">{{ number_format($combo->price, 0, '.', ',') }} VND</span>
                                    </div>
                                    {{-- <form action="{{ route('cart.addCart') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="food_id" value="{{ $combo->food_id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="action" value="buy_now">
                                        <button type="submit" class="btn-buy-now">MUA NGAY</button>
                                    </form> --}}
                                   <a href="{{ route('staff.combo.show', ['id' => $combo->food_id, 'cinema_id' => request('cinema_id')]) }}" class="btn btn-primary btn-buy-now">MUA NGAY</a>


                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <br><br>
    </div>
@endsection


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
