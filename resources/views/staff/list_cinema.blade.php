@extends('layouts.staff')

@section('title', 'Home')

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')

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
                           <a href="{{ asset('staff/booking1') }}" class="buy-button">
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
