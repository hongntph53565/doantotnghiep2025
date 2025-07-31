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
                {{-- <a href="#" class="back-btn">
                    ← TRỞ LẠI
                </a> --}}
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

        <button class="btn1">CONCESSION</button>
        <!-- Swiper container -->
        <div class="swiper combo-swiper">
            <div class="swiper-wrapper">

                <!-- Combo 1 -->
                @foreach ($combos as $combo)
                    <div class="swiper-slide">

                        <a href="{{ route('combo.show', ['id' => $combo->food_id]) }}">
                            <div class="combo-card">
                                <img src="{{ asset('storage/' . $combo->image) }}" alt="{{ $combo->name }}" />
                                <div class="combo-content">
                                    <div class="combo-title">{{ $combo->name }}</div>
                                    <div class="combo-desc">{{ $combo->description }}
                                    </div>
                                </div>
                                <div class="combo-footer">
                                    <div class="price">
                                        {{-- <div class="fw-bold text-decoration-line-through">85.000 VND</div> --}}
                                        <div class="fw-bold fs-6">{{ number_format($combo->price, 3, '.', ',') }} VND</div>
                                    </div>
                                    <button class="buy-btn">MUA NGAY</button>
                                </div>
                            </div>
                        </a>


                    </div>
                @endforeach
            </div>

            <!-- Navigation & Pagination -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-pagination"></div>
        </div>

        <button class="btn1">KHUYẾN MÃI</button>

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
