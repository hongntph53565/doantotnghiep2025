@extends('layouts.app')

@section('content')
    <div id="bannerCarousel" class="carousel slide mt-4" data-bs-ride="carousel">

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

        <!-- ✅ Nút điều hướng -->
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
                <!-- Slide 1 -->
                <div class="swiper-slide">
                    <div class="movie-box">

                        <div class="movie-img">
                            <img src="{{ asset('images/1.jpg') }}" alt="Út Lan">
                            <!-- Nút play - dẫn đến trailer -->
                            <a href="javascript:void(0);" class="play-button" onclick="openTrailer(this)"
                                data-trailer="https://www.youtube.com/embed/YOUR_TRAILER_ID"></a>



                            <!-- Nút mua vé -->
                            <a href="dat-ve.html" class="buy-button">
                                MUA VÉ NGAY
                                <img src="{{ asset('images/ticket-svgrepo-com.svg') }}" alt="vé">
                            </a>

                        </div>
                        <div class="info">
                            <div class="labels">
                                <span class="label age">T18</span>
                                <span class="label subtitle">PHỤ ĐỀ</span>
                                <span class="label type">2D</span>
                            </div>
                            <h4>ÚT LAN: OÁN LINH GIỮ CỬA</h4>
                            <p>Thể loại phim: <span class="tag horror">Horror</span></p>
                        </div>
                    </div>
                </div>


                <!-- Slide 2 -->
                <div class="swiper-slide">
                    <div class="movie-box">

                        <div class="movie-img">
                            <img src="{{ asset('images/2.jpg') }}" alt="Út Lan">
                            <!-- Nút play - dẫn đến trailer -->
                            <a href="javascript:void(0);" class="play-button" onclick="openTrailer(this)"
                                data-trailer="https://www.youtube.com/embed/YOUR_TRAILER_ID"></a>



                            <!-- Nút mua vé -->
                            <a href="dat-ve.html" class="buy-button">
                                MUA VÉ NGAY
                                <img src="{{ asset('images/ticket-svgrepo-com.svg') }}" alt="vé">
                            </a>

                        </div>
                        <div class="info">
                            <div class="labels">
                                <span class="label age">T18</span>
                                <span class="label subtitle">PHỤ ĐỀ</span>
                                <span class="label type">2D</span>
                            </div>
                            <h4>ÚT LAN: OÁN LINH GIỮ CỬA</h4>
                            <p>Thể loại phim: <span class="tag horror">Horror</span></p>
                        </div>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="swiper-slide">
                    <div class="movie-box">

                        <div class="movie-img">
                            <img src="{{ asset('images/banner-1.jpg') }}" alt="Út Lan">
                            <!-- Nút play - dẫn đến trailer -->
                            <a href="javascript:void(0);" class="play-button" onclick="openTrailer(this)"
                                data-trailer="https://www.youtube.com/embed/YOUR_TRAILER_ID"></a>



                            <!-- Nút mua vé -->
                            <a href="dat-ve.html" class="buy-button">
                                MUA VÉ NGAY
                                <img src="{{ asset('images/ticket-svgrepo-com.svg') }}" alt="vé">
                            </a>

                        </div>
                        <div class="info">
                            <div class="labels">
                                <span class="label age">T18</span>
                                <span class="label subtitle">PHỤ ĐỀ</span>
                                <span class="label type">2D</span>
                            </div>
                            <h4>ÚT LAN: OÁN LINH GIỮ CỬA</h4>
                            <p>Thể loại phim: <span class="tag horror">Horror</span></p>
                        </div>
                    </div>
                </div>

                <!-- Slide 4 -->
                <div class="swiper-slide">
                    <div class="movie-box">

                        <div class="movie-img">
                            <img src="{{ asset('images/banner-2.jpg') }}" alt="Út Lan">
                            <!-- Nút play - dẫn đến trailer -->
                            <a href="javascript:void(0);" class="play-button" onclick="openTrailer(this)"
                                data-trailer="https://www.youtube.com/embed/YOUR_TRAILER_ID"></a>



                            <!-- Nút mua vé -->
                            <a href="dat-ve.html" class="buy-button">
                                MUA VÉ NGAY
                                <img src="{{ asset('images/ticket-svgrepo-com.svg') }}" alt="vé">
                            </a>

                        </div>
                        <div class="info">
                            <div class="labels">
                                <span class="label age">T18</span>
                                <span class="label subtitle">PHỤ ĐỀ</span>
                                <span class="label type">2D</span>
                            </div>
                            <h4>ÚT LAN: OÁN LINH GIỮ CỬA</h4>
                            <p>Thể loại phim: <span class="tag horror">Horror</span></p>
                        </div>
                    </div>
                </div>

                <!-- Slide 5 -->
                <div class="swiper-slide">
                    <div class="movie-box">

                        <div class="movie-img">
                            <img src="{{ asset('images/slide3.jpg') }}" alt="Út Lan">
                            <!-- Nút play - dẫn đến trailer -->
                            <a href="javascript:void(0);" class="play-button" onclick="openTrailer(this)"
                                data-trailer="https://www.youtube.com/embed/YOUR_TRAILER_ID"></a>



                            <!-- Nút mua vé -->
                            <a href="dat-ve.html" class="buy-button">
                                MUA VÉ NGAY
                                <img src="{{ asset('images/ticket-svgrepo-com.svg') }}" alt="vé">
                            </a>

                        </div>
                        <div class="info">
                            <div class="labels">
                                <span class="label age">T18</span>
                                <span class="label subtitle">PHỤ ĐỀ</span>
                                <span class="label type">2D</span>
                            </div>
                            <h4>ÚT LAN: OÁN LINH GIỮ CỬA</h4>
                            <p>Thể loại phim: <span class="tag horror">Horror</span></p>
                        </div>
                    </div>
                </div>
                <!-- Slide 6 -->
                <div class="swiper-slide">
                    <div class="movie-box">

                        <div class="movie-img">
                            <img src="{{ asset('images/web-phim-thang-6.jpg') }}" alt="Út Lan">
                            <!-- Nút play - dẫn đến trailer -->
                            <a href="javascript:void(0);" class="play-button" onclick="openTrailer(this)"
                                data-trailer="https://www.youtube.com/embed/YOUR_TRAILER_ID"></a>



                            <!-- Nút mua vé -->
                            <a href="dat-ve.html" class="buy-button">
                                MUA VÉ NGAY
                                <img src="{{ asset('images/ticket-svgrepo-com.svg') }}" alt="vé">
                            </a>

                        </div>
                        <div class="info">
                            <div class="labels">
                                <span class="label age">T18</span>
                                <span class="label subtitle">PHỤ ĐỀ</span>
                                <span class="label type">2D</span>
                            </div>
                            <h4>ÚT LAN: OÁN LINH GIỮ CỬA</h4>
                            <p>Thể loại phim: <span class="tag horror">Horror</span></p>
                        </div>
                    </div>
                </div>

                <!-- Slide 7 -->
                <div class="swiper-slide">
                    <div class="movie-box">

                        <div class="movie-img">
                            <img src="{{ asset('images/662722.png') }}" alt="Út Lan">
                            <!-- Nút play - dẫn đến trailer -->
                            <a href="javascript:void(0);" class="play-button" onclick="openTrailer(this)"
                                data-trailer="https://www.youtube.com/embed/YOUR_TRAILER_ID"></a>



                            <!-- Nút mua vé -->
                            <a href="dat-ve.html" class="buy-button">
                                MUA VÉ NGAY
                                <img src="{{ asset('images/ticket-svgrepo-com.svg') }}" alt="vé">
                            </a>

                        </div>
                        <div class="info">
                            <div class="labels">
                                <span class="label age">T18</span>
                                <span class="label subtitle">PHỤ ĐỀ</span>
                                <span class="label type">2D</span>
                            </div>
                            <h4>ÚT LAN: OÁN LINH GIỮ CỬA</h4>
                            <p>Thể loại phim: <span class="tag horror">Horror</span></p>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Buttons and Pagination -->
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
@endsection

@push('styles')
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
            height: 360px;
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
@endpush

@prepend('scripts')
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
        var swiper = new Swiper(".mySwiper", {
            slidesPerView: 5,
            spaceBetween: 20,
            loop: true,
            autoplay: {
                delay: 10000,
                disableOnInteraction: false
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
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
    </script>
@endprepend

@push('scripts')
    <script>
        console.log('Chạy sau');
    </script>
@endpush
