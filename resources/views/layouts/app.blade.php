<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Trang Phim')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }

        .section-title {
            background-color: white;
            border: 2px solid #00cc66;
            color: #00cc66;
            font-weight: bold;
            padding: 6px 20px;
            display: inline-block;
            border-radius: 6px;
            margin: 30px 0 20px;
        }

        .movie-card img {
            border-radius: 10px;
            height: auto;
            width: 100%;
        }

        .movie-title {
            font-weight: bold;
            font-size: 14px;
            margin-top: 6px;
        }

        .movie-meta {
            font-size: 12px;
            color: #555;
        }

        .movie-tags span {
            font-size: 10px;
            margin-right: 4px;
            padding: 2px 6px;
            border-radius: 4px;
        }

        .review-section img {
            width: 100%;
            border-radius: 10px;
            margin-top: 40px;
        }

        .review-text {
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
            font-size: 20px;
            color: white;
            background-color: #000;
            display: inline-block;
            padding: 6px 12px;
            border-radius: 8px;
        }

        .cinema-title {
            font-weight: bold;
            margin: 20px 0;
        }

        .cinema-box {
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 16px;
            background: white;
            display: flex;
            align-items: flex-start;
            /* ← chỉnh từ center thành flex-start nếu bạn muốn chữ bắt đầu từ top */
            margin-bottom: 30px;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            flex-wrap: wrap;
            gap: 12px;
            /* thêm chút khoảng cách tự nhiên */
        }

        .cinema-box img {
            width: 120px;
            /* ← nhỏ lại để khớp chiều cao nội dung */
            height: auto;
            border-radius: 8px;
            margin: 0;
            /* ← bỏ margin-right nếu bạn dùng gap trong flex */
            object-fit: cover;
        }

        .cinema-box>div {
            flex: 1;
            padding-top: 4px;
            /* ← nếu cần dịch xuống một chút cho cân */
        }

        .cinema-box h6 {
            color: #28a745;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .cinema-info {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 15px;
            color: #333;
            line-height: 1.4;
        }


        .cinema-name {
            margin: 10px 0;
            font-weight: 500;
            color: #333;
        }

        .btn-detail {
            background-color: #7bc043;
            color: white;
            font-weight: 500;
            border: none;
        }

        .btn-detail:hover {
            background-color: #5fa334;
        }

        .topbar {
            background-color: #f8f8f8;
            padding: 10px 0;
        }

        .topbar .nav-link {
            color: black;
            font-weight: 500;
        }

        .topbar .btn-location {
            background-color: #d9f3cc;
            border: 1px solid #a8e38b;
            font-weight: 600;
            color: black;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .dropdown-toggle:hover {
            color: #7bc043 !important;
            font-weight: 600;
        }

        /* Dropdown custom style */
        .dropdown-menu.custom-dropdown {
            background-color: rgba(0, 0, 0, 0.6);
            border: none;
            border-radius: 10px;
            padding: 10px;
        }

        .dropdown-menu.custom-dropdown a {
            color: #f1f1f1;
            font-weight: 500;
        }

        .dropdown-menu.custom-dropdown a:hover {
            color: #7bc043;
            background-color: transparent;
        }

        .navbar {
            background-color: transparent !important;
            box-shadow: none !important;
            padding: 0;
        }

        footer a:hover {
            color: #8bc34a !important;
            transition: 0.3s;
        }

        footer a.social-icon:hover {
            color: white !important;
        }

        .social-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            font-size: 24px;
            color: white;
            text-decoration: none;
            background-color: gray;
            /* fallback nếu class riêng không có */
        }

        /* Màu cố định theo mạng xã hội */
        .social-icon.facebook {
            background-color: #1877f2;
        }

        .social-icon.instagram {
            background-color: #e1306c;
        }

        .social-icon.tiktok {
            background-color: #000000;
        }

        .social-icon.youtube {
            background-color: #ff0000;

        }

        /* Loại bỏ mọi hiệu ứng hover/focus/active */
        .social-icon:hover,
        .social-icon:focus,
        .social-icon:active {
            background-color: inherit;
            color: white;
            filter: none;
            transform: none;
            outline: none;
            box-shadow: none;
        }
    </style>
    @stack('styles')
</head>

<body>

    {{-- Navbar --}}
    <div class="topbar">
        <div class="topbar">
            <div class="container d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img style=" width: 100px; height: 100px;" src="{{ asset('images/logo.jpg') }}" alt="Logo">
                    <nav class="navbar navbar-expand-lg">
                        <div class="container">
                            <a class="navbar-brand" href="{{ url('/home') }}">LumiStar</a>


                            <div class="collapse navbar-collapse">
                                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle active" href="#" role="button"
                                            data-bs-toggle="dropdown">
                                            NOW SHOWING
                                        </a>
                                        <ul class="dropdown-menu custom-dropdown">
                                            <li>
                                                <a class="dropdown-item" href="{{ url('/lich-chieu-theo-rap') }}">LỊCH
                                                    CHIẾU RẠP</a>
                                            </li>
                                            <li>
                                                <a class="dropdown-item" href="{{ url('/lich-chieu-phim') }}">LỊCH CHIẾU
                                                    PHIM</a>
                                            </li>
                                        </ul>

                                    </li>
                                    <li class="nav-item"><a class="nav-link" href="#">ĐỒ ĂN/COMBO</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#">KHUYẾN MÃI</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#">DỊCH VỤ</a></li>
                                    <li class="nav-item dropdown">
                                        <a class="nav-link dropdown-toggle active" href="#" role="button"
                                            data-bs-toggle="dropdown">
                                            VỀ BHD STAR
                                        </a>
                                        <ul class="dropdown-menu custom-dropdown">
                                            <li><a class="dropdown-item" href="{{ url('/he-thong-rap') }}">HỆ THỐNG
                                                    RẠP</a></li>
                                            <li><a class="dropdown-item" href="#">VỀ CHÚNG TÔI</a></li>
                                            <li><a class="dropdown-item" href="#">TUYỂN DỤNG</a></li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </nav>
                </div>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        <button class="btn btn-outline-success dropdown-toggle" type="button" id="dropdownLocation"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Hà Nội
                        </button>
                        <ul class="dropdown-menu custom-dropdown" aria-labelledby="dropdownLocation">
                            <li><a class="dropdown-item" href="#">Hà Nội</a></li>
                            <li><a class="dropdown-item" href="#">TP. Hồ Chí Minh</a></li>
                            <li><a class="dropdown-item" href="#">Đà Nẵng</a></li>
                        </ul>
                    </div>
                    <a href="{{ url('/profile') }}" class="text-decoration-none text-dark">
                        <div class="d-flex align-items-center ms-3">
                            <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" width="24"
                                class="me-1">
                            <span>Gia Hưng / <strong>Thoát</strong></span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Nội dung động --}}
    @yield('content')

    {{-- Footer --}}
    <footer class="bg-dark text-white pt-5">
        <div class="container">
            <div class="row">

                <!-- Về BHD Star -->
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold">VỀ BHD STAR</h5>
                    <hr class="mt-0"
                        style="height: 5px;width: 120px;border: none;background-color: #7fe784;border-radius: 10px;filter: drop-shadow(0 0 8px #7fe784) drop-shadow(0 0 16px #7fe784);">
                    <ul class="list-unstyled mt-3">
                        <li><a href="#" class="text-white text-decoration-none">Hệ thống rạp</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Cụm rạp</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Liên hệ</a></li>
                    </ul>
                    <img src="{{ asset('images\image-21.png') }}" alt="Đã thông báo" width="200">
                </div>

                <!-- Quy định & Điều khoản -->
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold">QUY ĐỊNH & ĐIỀU KHOẢN</h5>
                    <hr class="mt-0"
                        style="height: 5px;width: 120px;border: none;background-color: #7fe784;border-radius: 10px;filter: drop-shadow(0 0 8px #7fe784) drop-shadow(0 0 16px #7fe784);">

                    <ul class="list-unstyled mt-3">
                        <li><a href="#" class="text-white text-decoration-none">Quy định thành viên</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Điều khoản</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Hướng dẫn đặt vé trực tuyến</a>
                        </li>
                        <li><a href="#" class="text-white text-decoration-none">Chính sách & điều khoản
                                chung</a>
                        </li>
                        <li><a href="#" class="text-white text-decoration-none">Chính sách bảo vệ thông tin</a>
                        </li>
                    </ul>
                </div>

                <!-- Chăm sóc khách hàng -->
                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold">CHĂM SÓC KHÁCH HÀNG</h5>
                    <hr class="mt-0"
                        style="height: 5px;width: 120px;border: none;background-color: #7fe784;border-radius: 10px;filter: drop-shadow(0 0 8px #7fe784) drop-shadow(0 0 16px #7fe784);">
                    <p><strong>Hotline:</strong> 19002099</p>
                    <p><strong>Giờ làm việc:</strong> 9:00 - 22:00 (Tất cả các ngày bao gồm cả Lễ, Tết)</p>
                    <p><strong>Email hỗ trợ:</strong> <a href="mailto:cskh@bhdstar.vn"
                            class="text-white">cskh@bhdstar.vn</a></p>
                    <p class="fw-bold">MẠNG XÃ HỘI</p>
                    <div class="d-flex gap-3">
                        <a href="#" class="social-icon facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon tiktok"><i class="fab fa-tiktok"></i></a>
                        <a href="#" class="social-icon youtube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
            <hr class="border-secondary">
            <div class="row align-items-center">
                <div class="col-md-1 mb-2">
                    <img style=" width: 100px; height: 100px;" src="{{ asset('images/logo.jpg') }}" alt="Logo">
                </div>
                <div class="col-md-11">
                    <p class="mb-1 fw-bold">Công ty TNHH MTV Ngôi Sao Cineplex Lumi Việt Nam</p>
                    <p class="mb-1">Giấy CNĐKDN: 0104597158. Đăng ký lần đầu ngày 15 tháng 04 năm 2010</p>
                    <p class="mb-1">Địa chỉ: Tầng 11, Tòa nhà Hồng Hà Building, Lý Thường Kiệt, P.Phăn Chu Trinh,
                        Q.Hoàn
                        Kiếm, Hà Nội</p>
                    <p class="mb-1">Hotline: 19002099</p>
                    <p class="mb-0">COPYRIGHT 2010 BHD STAR. ALL RIGHTS RESERVED</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
