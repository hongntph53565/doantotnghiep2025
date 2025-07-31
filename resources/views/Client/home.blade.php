@extends('layouts.app')

@section('title', 'Trang chủ')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('client/css/home.css') }}">
@endpush



@section('content')
<div class="container">
    <div id="bannerCarousel" class="carousel slide" data-bs-ride="carousel">


        <!-- ✅ Dot Indicators -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#bannerCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>

        <!-- ✅ Slide nội dung -->
        <div class="carousel-inner p-0">

            <!-- Slide 1 -->
            <div class="carousel-item active">
                <div class="banner"><img src="{{ asset('images/web-phim-thang-6.jpg') }}" class="d-block w-100"
                        alt="Banner 1"></div>
                <a href="/phim-thang-6" class="label-phim">PHIM HAY THÁNG 6</a>
                <a href="/danh-sach-phim" class="btn-xem-them">XEM THÊM<img
                        src="{{ asset('images/ticket-svgrepo-com.svg') }}" alt=""></a>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <div class="banner"><img src="{{ asset('images/banner-2.jpg') }}" class="d-block w-100" alt="Banner 2">
                </div>
                <a href="/phim-thang-6" class="label-phim">ĐIỀU ƯỚC CUỐI CÙNG</a>
                <a href="/danh-sach-phim" class="btn-xem-them">ĐẶT VÉ NGAY<img
                        src="{{ asset('images/ticket-svgrepo-com.svg') }}" alt=""></a>
            </div>
            <!-- Slide 2 -->
            <div class="carousel-item">
                <div class="banner"><img src="{{ asset('images/banner-1.jpg') }}" class="d-block w-100" alt="Banner 2">
                </div>
                <a href="/phim-thang-6" class="label-phim">F1</a>
                <a href="/danh-sach-phim" class="btn-xem-them">ĐẶT VÉ NGAY<img
                        src="{{ asset('images/ticket-svgrepo-com.svg') }}" alt=""></a>
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
        </button>

    </div>
    <button class="btn1">PHIM ĐANG CHIẾU</button>

    <div class="slider-container">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">

                @foreach ($movies as $movie)
                    <div class="swiper-slide">
                        <div class="movie-box">
                            <div class="movie-img">
                                <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}">

                                @if (!empty($movie->trailer))
                                    <a href="javascript:void(0);" class="play-button" onclick="openTrailer(this)"
                                        data-trailer="{{ $movie->trailer }}"></a>
                                @endif

                                <a href="{{ route('Client.booking.home', ['movie_id' => $movie->movie_id]) }}"
                                    class="buy-button">
                                    MUA VÉ NGAY
                                    <img src="{{ asset('images/ticket-svgrepo-com.svg') }}" alt="vé">
                                </a>
                            </div>
                            <div class="info">
                                <div class="labels">
                                    <span class="label age">{{ $movie->age_rating }}</span>
                                    <span class="label subtitle">PHỤ ĐỀ</span>
                                    <span class="label type">{{ $movie->format }}</span>
                                </div>
                                <h4>{{ $movie->title }}</h4>
                                <p>Thể loại phim: <span
                                        class="tag horror">{{ $movie->genre->genre_name ?? 'Không rõ' }}</span></p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
    <div class="trailer-overlay" id="trailerOverlay">
        <div class="trailer-content">
            <iframe id="trailerIframe" src="" allowfullscreen></iframe>
            <button class="close-btn" onclick="closeTrailer()">×</button>
        </div>
    </div>
    <button class="btn1">KHUYẾN MÃI</button>
        <div class="promo-container swiper">
            <!-- Wrapper -->
            <div class="swiper-wrapper">
                <!-- Promo 1 -->
                <div class="promo-card swiper-slide">
                    <img src="{{ asset('images/HAPPY-DAY-2.jpg') }}" alt="Giữ xe miễn phí" />
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
                    <img src="{{ asset('images/GIA-VE-48K.jpg') }}" alt="Xem phim khuyến mãi 50K" />
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
                    <img src="{{ asset('images/PHIM-KHUYA.jpg') }}" alt="Happy Day 45K" />
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
            <div class="swiper-button-next promo-next"></div>
            <div class="swiper-button-prev promo-prev"></div>
            <div class="swiper-pagination promo-pagination"></div>
        </div>
        <button class="btn1">PHIM SẮP CHIẾU</button>
        <button class="btn1">TIN MỚI NHẤT</button>
        <div class="featured-news swiper">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide">
                    <a href="#">
                        <img src="{{ asset('images/tin1.jpg') }}" alt="">
                    </a>
                </div>

                <!-- Slide 2 -->
                <div class="swiper-slide">
                    <a href="#">
                        <img src="{{ asset('images/tin2.jpg') }}" alt="">
                    </a>
                </div>

                <!-- Slide 3 -->
                <div class="swiper-slide">
                    <a href="#">
                        <img src="{{ asset('images/tin3.webp') }}" alt="">
                    </a>
                </div>
                <!-- ... thêm slide nếu cần ... -->
            </div>

            <!-- Nếu cần navigation -->
            <div class="swiper-button-next news-next"></div>
            <div class="swiper-button-prev news-prev"></div>
            <div class="swiper-pagination news-pagination"></div>
        </div>
    </div>
    </div>
@endsection
@push('styles')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    {{-- slider --}}
    <style>
        .carousel,
        .carousel-inner,
        .carousel-item,
        .banner {
            padding: 0 !important;
            margin: 0 !important;
        }

        .carousel-inner {
            min-height: auto;
            /* Loại bỏ min-height cố định */
            overflow: hidden;
        }

        .carousel-item {
            height: auto;
            /* Cho phép chiều cao tự động */
            position: relative;
        }

        .carousel-item .banner {
            height: 100%;
        }

        .carousel-item .banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        @media (min-width: 768px) {

            .carousel-inner,
            .carousel-item {
                min-height: 400px;
                /* Giá trị tối thiểu trên màn hình lớn */
            }
        }

        @media (max-width: 767px) {

            .carousel-inner,
            .carousel-item {
                min-height: 200px;
                /* Điều chỉnh cho thiết bị nhỏ */
            }
        }
    </style>
    <style>
        .btn-xem-them img {
            width: 18px;
            margin-bottom: 3px;
            margin-left: 3px;
        }

        .label-phim {
            position: absolute;
            bottom: 80px;
            left: 20px;
            background-color: #fff;
            color: #4CAF50;
            font-weight: bold;
            border-radius: 10px;
            padding: 6px 16px;
            font-size: 16px;
            border: 1px solid #4CAF50;
            z-index: 10;
            text-decoration: none;
        }

        .label-phim:hover {
            color: black;
        }

        .btn-xem-them {
            position: absolute;
            bottom: 20px;
            left: 20px;
            background: linear-gradient(to right, #7ddc2f, #5ac630);
            color: white;
            font-weight: bold;
            padding: 6px 18px;
            border-radius: 6px;
            font-size: 14px;
            z-index: 10;
            text-decoration: none;
            display: inline-block;
        }

        .btn-xem-them:hover {
            background: linear-gradient(to left, #7ddc2f, #5ac630);
        }

        .carousel-indicators [data-bs-target] {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #6c757d;
            margin: 0 6px;
            opacity: 0.7;
        }

        .carousel-indicators .active {
            background-color: #28a745;
            opacity: 1;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            padding: 10px;
        }
    </style>

    {{-- phim đang+ sắp chiếu --}}
    <style>
        h2.title {
            text-align: center;
            margin-bottom: 30px;
        }

        .slider-container {
            width: 100%;
            max-width: 1400px;
            margin: 0 auto;
        }

        .swiper {
            width: 100%;
            height: auto;
        }

        .swiper-slide {
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            transition: 0.8s ease;
            height: 500px;
            width: 260px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }

        .swiper-slide img {
            width: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        .info {
            margin-top: 10px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            text-align: left;
        }

        .swiper-slide h4 {
            font-size: 15px;
            margin: 5px 0;
            font-weight: bold;
            line-height: 20px;
            height: 20px;
            /* Chiều cao đúng bằng 1 dòng */
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
        }


        .swiper-slide p {
            font-size: 14px;
            margin: 0;
        }

        .labels {
            margin-bottom: 5px;
        }

        .label {
            display: inline-block;
            font-size: 12px;
            padding: 3px 6px;
            margin-right: 4px;
            border-radius: 4px;
            color: #fff;
            font-weight: bold;
        }

        .label.age {
            background: #a00;
        }

        .label.subtitle {
            background: #000;
        }

        .label.type {
            background: #0a0;
        }

        .tag {
            font-weight: bold;
        }

        .tag.horror {
            color: red;
        }

        .tag.family {
            color: green;
        }

        .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            margin: 0 6px !important;
            background-color: #bbb;
            border-radius: 50%;
            opacity: 1;
            transition: 0.3s ease;
        }

        .swiper-pagination-bullet-active {
            background-color: #72BE43;
            transform: scale(1.2);
        }

        .swiper-button-next,
        .swiper-button-prev {
            color: #fff;
            padding: 10px;
            border-radius: 50%;
            width: 90px;
            height: 90px;
            top: 45%;
            transform: translateY(-50%);
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 50px;
            font-weight: bolder;
        }

        /* Khi hover vào container thì hiện nút */
        .slider-container:hover .swiper-button-next,
        .slider-container:hover .swiper-button-prev {
            opacity: 1;
            pointer-events: auto;
        }

        .movie-img {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
            transition: box-shadow 0.3s ease;
        }

        .movie-img:hover {
            box-shadow: 0 8px 12px 0 #99CE78;
        }


        .movie-img img {
            width: 100%;
            height: 360px;
            object-fit: cover;
            border-radius: 10px;
        }

        .movie-box {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .play-button,
        .buy-button {
            position: absolute;
            opacity: 0;
            transition: 0.3s ease;
            z-index: 2;
            text-decoration: none;
        }

        /* PLAY BUTTON */
        .play-button {
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: 3px solid white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .play-button::before {
            content: '';
            width: 0;
            height: 0;
            border-left: 14px solid white;
            border-top: 8px solid transparent;
            border-bottom: 8px solid transparent;
        }

        /* BUY BUTTON */
        .buy-button {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #a3dfb4;
            color: white;
            font-weight: bold;
            font-size: 15px;
            text-transform: uppercase;
            padding: 12px 24px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
            opacity: 0;
            transition: 0.3s;
            cursor: pointer;
            white-space: nowrap;
            /* ✅ ép nằm cùng 1 dòng */
            text-decoration: none;
        }


        .buy-button img {
            width: 20px;
            height: 20px;
            margin-bottom: 2px;
        }

        .buy-button:hover {
            background-color: #72BE43;
        }

        /* HOVER VÀO ẢNH MỚI HIỆN NÚT */
        .movie-img:hover .play-button,
        .movie-img:hover .buy-button {
            opacity: 1;
        }

        .trailer-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        .trailer-content {
            position: relative;
            width: 80%;
            max-width: 800px;
            aspect-ratio: 16/9;
            background: #000;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.5);
            z-index: 10000;
        }

        .trailer-content iframe {
            width: 100%;
            height: 100%;
            border: none;
            display: block;
        }

        .close-btn {
            position: absolute;
            top: -14px;
            right: -14px;
            background: #fff;
            color: #000;
            border: none;
            font-size: 22px;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            cursor: pointer;
            z-index: 10001;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.4);
            /* display: block !important; */
        }

        #trailerOverlay .trailer-content .close-btn {
            display: block;
        }
    </style>
    <style>
        /* Gộp từng promo-card thành slide */
        .promo-container .swiper-wrapper {
            display: flex;
        }

        .promo-container .swiper-slide {
            flex-shrink: 0;
            width: 100%;
            height: 100%;
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
    <style>
        .featured-news {
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .featured-news .swiper-slide {
            width: 100%;
            height: auto;
        }

        .featured-news .swiper-slide img {
            width: 100%;
            height: auto;
            display: block;
            border-radius: 8px;
        }

        /* Nút điều hướng */
        .featured-news .swiper-button-next,
        .featured-news .swiper-button-prev {
            color: #fff;
            padding: 10px;
            border-radius: 50%;
            width: 90px;
            height: 90px;
            top: 45%;
            transform: translateY(-50%);
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s ease;
        }

        .featured-news:hover .swiper-button-next,
        .featured-news:hover .swiper-button-prev {
            opacity: 1;
            pointer-events: auto;
        }

        /* Pagination */
        .news-pagination .swiper-pagination-bullet {
            background: #bbb;
        }

        .news-pagination .swiper-pagination-bullet-active {
            background: #72BE43;
        }

        .news-pagination {
            position: absolute;
            bottom: 20px;
            left: 0;
            width: 100%;
            text-align: center;
            z-index: 10;
        }

        .news-pagination .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            margin: 0 6px;
            background-color: #bbb;
            border-radius: 50%;
            opacity: 0.8;
            transition: 0.3s ease;
        }

        .news-pagination .swiper-pagination-bullet-active {
            background-color: #72BE43;
            transform: scale(1.2);
        }


        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 50px;
            font-weight: bolder;
        }

        /* Khi hover vào container thì hiện nút */
        .featured-news:hover .swiper-button-next,
        .featured-news:hover .swiper-button-prev {
            opacity: 1;
            pointer-events: auto;
        }
    </style>
@endpush
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var carousel = new bootstrap.Carousel(document.getElementById('bannerCarousel'), {
                interval: 5000,
                ride: 'carousel'
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <script>
        function openTrailer(el) {
            const url = el.getAttribute("data-trailer");
            const overlay = document.getElementById("trailerOverlay");
            const iframe = document.getElementById("trailerIframe");
            iframe.src = url + "?autoplay=1";
            overlay.style.display = "flex";
        }

        function closeTrailer() {
            const overlay = document.getElementById("trailerOverlay");
            const iframe = document.getElementById("trailerIframe");
            overlay.style.display = "none";
            iframe.src = "";
        }
        // Swiper phim
        const swiperBanner = new Swiper(".mySwiper", {
            slidesPerView: 5,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 10000,
                disableOnInteraction: false
            },
            pagination: {
                el: ".banner-pagination",
                clickable: true
            },
            navigation: {
                nextEl: ".banner-next",
                prevEl: ".banner-prev"
            },
            breakpoints: {
                320: {
                    slidesPerView: 1
                },
                640: {
                    slidesPerView: 2
                },
                768: {
                    slidesPerView: 3
                },
                1024: {
                    slidesPerView: 5
                }
            }
        });

        // Swiper khuyến mãi
        const swiperPromo = new Swiper('.promo-container.swiper', {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            pagination: {
                el: '.promo-pagination',
                clickable: true
            },
            navigation: {
                nextEl: '.promo-next',
                prevEl: '.promo-prev'
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
        const swiperNews = new Swiper('.featured-news.swiper', {
            slidesPerView: 1,
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false
            },
            pagination: {
                el: '.news-pagination',
                clickable: true
            },
            navigation: {
                nextEl: '.news-next',
                prevEl: '.news-prev'
            }
        });
    </script>
@endpush
