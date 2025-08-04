@extends('layouts.app')

@section('title', 'LumiStar')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush



@section('content')
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
                <a href="/lich-chieu-phim" class="label-phim">PHIM HAY THÁNG 7</a>
                <a href="/lich-chieu-phim" class="btn-xem-them">XEM THÊM<img
                        src="{{ asset('images/ticket-svgrepo-com.svg') }}" alt=""></a>
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item">
                <div class="banner"><img src="{{ asset('images/banner-2.jpg') }}" class="d-block w-100" alt="Banner 2">
                </div>
                <a href="/lich-chieu-phim" class="label-phim">ĐIỀU ƯỚC CUỐI CÙNG</a>
                <a href="/lich-chieu-phim" class="btn-xem-them">ĐẶT VÉ NGAY<img
                        src="{{ asset('images/ticket-svgrepo-com.svg') }}" alt=""></a>
            </div>
            <!-- Slide 2 -->
            <div class="carousel-item">
                <div class="banner"><img src="{{ asset('images/banner-1.jpg') }}" class="d-block w-100" alt="Banner 2">
                </div>
                <a href="/lich-chieu-phim" class="label-phim">F1</a>
                <a href="/lich-chieu-phim" class="btn-xem-them">ĐẶT VÉ NGAY<img
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
                                    <span class="label subtitle">{{ $movie->language }}</span>
                                    <span class="label type">{{ $movie->format }}</span>
                                </div>
                                <h4 class="movie-title" title="{{ $movie->title }}">{{ $movie->title }}</h4>
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
@endsection
@prepend('scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <script>
        function openTrailer(el) {
            const url = el.getAttribute("data-trailer");
            if (!url) {
                alert("Phim này chưa có trailer!");
                return;
            }
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
