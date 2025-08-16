@extends('layouts.app')

@section('title', 'Về chúng tôi')

@push('styles')
    <style>
        .about-section {
            max-width: 900px;
            margin: 0 auto 40px auto;
            text-align: center;
        }

        .about-section p {
            line-height: 1.8;
            font-size: 16px;
        }

        .carousel-inner img {
            max-height: 400px;
            object-fit: cover;
        }

        .carousel-caption {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 15px 20px;
            border-radius: 10px;
        }

        .carousel-caption h5 {
            font-size: 20px;
            font-weight: bold;
        }

        .carousel-caption p {
            font-size: 15px;
            margin: 0;
        }

        .theater-title {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        hr {
            width: 100px;
            margin: 30px auto;
            border-top: 3px solid #f15f2c;
        }
    </style>
@endpush

@section('content')
    <div class="container text-center">
        <hr>
        <h3 class="theater-title">Về chúng tôi</h3>

        <!-- Carousel ảnh + nội dung riêng -->
        <div id="aboutCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
            <div class="carousel-inner">

                <!-- Slide 1 -->
                <div class="carousel-item active">
                    <img src="{{ asset('images/quay.png') }}" class="d-block w-100" alt="Sảnh rạp">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Khởi đầu tại Việt Nam</h5>
                        <p>LumiStar bắt đầu với 3 phòng chiếu vào năm 2025, mang trải nghiệm điện ảnh chất lượng đến khách hàng Việt Nam.</p>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div class="carousel-item">
                    <img src="{{ asset('images/ghe.png') }}" class="d-block w-100" alt="Ghế ngồi">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Mở rộng mạnh mẽ</h5>
                        <p>Từ năm 2026, chúng tôi mong muốn mở rộng nhanh chóng tại TP.HCM, Hà Nội, Huế và nhiều tỉnh thành khác.</p>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div class="carousel-item">
                    <img src="{{ asset('images/phong.png') }}" class="d-block w-100" alt="Quầy rạp">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Trải nghiệm khách hàng là ưu tiên</h5>
                        <p>BHD Star Cineplex luôn được trang bị kỹ lưỡng về âm thanh hình ảnh luôn được áp dụng các công nghệ tối tân nhất mang lại trải nghiệm chân thật nhất, không gian thoải mái, sạch sẽ để khách hàng luôn yên tâm khi sử dụng dịch vụ và đội ngũ nhân viên được cam kết phục vụ đầy đủ, chuyên nghiệp thoả mãn các yêu cầu của khách hàng kịp thời.</p>
                    </div>
                </div>

            </div>

            <!-- Nút điều hướng -->
            <button class="carousel-control-prev" type="button" data-bs-target="#aboutCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#aboutCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>

        <!-- Nội dung giới thiệu tổng quan -->
        <div class="about-section">
            <p>
                LumiStar được biết đến với cụm rạp đầu tiên với 3 phòng chiếu vào năm 2025. Từ 2026, LumiStar mong muốn có sự phát triển mạnh mẽ, qua việc liên tục mở thêm các vị trí rạp mới, ở những khu vực đắc địa của TP.HCM, Hà Nội và các tỉnh thành khác.
            </p>
            <p>
                Bên cạnh việc tiếp tục mở rộng, giá trị cốt lõi của thương hiệu LumiStar là luôn bảo đảm trải nghiệm của khách hàng thông qua chất lượng phục vụ đồng nhất tại tất cả các cụm rạp.
            </p>
        </div>
    </div>
@endsection
