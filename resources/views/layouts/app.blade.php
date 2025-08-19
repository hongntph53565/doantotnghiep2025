<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Trang Phim')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Rubik+Mono+One&display=swap"rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

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
            width: 100%;
            height: auto;
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
            margin-bottom: 30px;
            width: 100%;
            flex-wrap: wrap;
            gap: 12px;
        }

        .cinema-box img {
            width: 120px;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
        }

        .cinema-box>div {
            flex: 1;
            padding-top: 4px;
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
    padding: 12px 0;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}
.topbar {
    transition: all 0.3s ease;
    padding: 12px 0;
}

.topbar.shrink {
    padding: 4px 0;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}



        .topbar .nav-link {
            color: rgb(153, 152, 152);
            font-weight: 500;
        }

        .topbar .btn-location {
            background-color: #d9f3cc;
            border: 1px solid #a8e38b;
            font-weight: 600;
            color: black;
        }

        .topbar .d-flex.align-items-center>*:not(:last-child) {
            margin-right: 2px;
        }


        .navbar {
            background-color: transparent !important;
            box-shadow: none !important;
            padding: 0;
            height: 70px;
            display: flex;
            align-items: center;
            margin-bottom: 0;
        }

        .navbar-nav {
            display: flex;
            align-items: center;
            height: 100%;
        }

        .navbar-nav .nav-link,
        .navbar-nav .dropdown-toggle {
            display: flex;
            align-items: center;
            height: 100%;
            font-family: 'Roboto', sans-serif;
            font-size: 15px;
            font-weight: 700;
            color: rgb(116, 114, 114) !important;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .dropdown-toggle:hover {
            color: #7bc043 !important;
        }


        .dropdown-menu.custom-dropdown {
            background-color: rgba(0, 0, 0, 0.6);
            border: none;
            border-radius: 10px;
            padding: 10px;
            display: none;

        }


        .nav-item.hover-dropdown:hover .dropdown-menu {
            display: block;
            margin-top: 0;
        }

        .dropdown-menu.custom-dropdown a {
            color: #f1f1f1;
            font-weight: 500;
        }

        .dropdown-menu.custom-dropdown a:hover {
            color: #7bc043;
            background-color: transparent;
        }

        .hover-dropdown:hover .dropdown-menu {
            display: block !important;
        }



        .header-banner img {
            width: 100%;
            height: auto;
            display: block;
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
        }

        .social-icon.facebook {
            background-color: #1877f2;
        }

        .social-icon.instagram {
            background-color: #e1306c;
        }

        .social-icon.tiktok {
            background-color: #000;
        }

        .social-icon.youtube {
            background-color: #ff0000;
        }

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


        .auth-hover-parent {
            position: relative;
            margin-left: 20px;
        }

        .auth-hover-box {
            position: absolute;
            top: 100%;
            right: 0;
            width: 320px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 15px;
            border-radius: 8px;
            display: none;
            z-index: 1000;
            backdrop-filter: blur(4px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .auth-hover-parent:hover .auth-hover-box {
            display: block;
        }

        .auth-hover-box form {
            margin-bottom: 8px;
        }

        .auth-hover-box input {
            background: white;
            color: black;
            border-radius: 6px;
            font-size: 14px;
            padding: 8px 12px;
        }

        .auth-hover-box button {
            width: 100%;
            border-radius: 6px;
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .auth-hover-box .mb-2 label {
            font-weight: 500;
            font-size: 13px;
            margin-bottom: 4px;
        }

        .auth-hover-box a {
            font-size: 12px;
            color: white;
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .auth-hover-box a:hover {
            color: #4caf50;
        }

        .auth-hover-box button.btn-success {
            background: #87d8a6;
            border: none;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .auth-hover-box button.btn-success:hover {
            background: #6ec893;
            transform: translateY(-2px);
        }

        .auth-hover-box button.btn-primary {
            background: #4caf50;
            border: none;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .auth-hover-box button.btn-primary:hover {
            background: #43a047;
            transform: translateY(-2px);
        }

        footer a:hover {
            color: #8bc34a !important;
            transition: 0.3s;
        }

        footer a.social-icon:hover {
            color: white !important;
        }
        .nav-link.active-link {
    color: #7bc043 !important;
    font-weight: 700;
}

    </style>
    @stack('styles')
</head>

<body>
    @if (session('message'))
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                showToast(@json(session('message')));
            });
        </script>
    @endif
    <div class="header-banner">
        <img src="{{ asset('images/Z1-1748x155-1.jpg') }}" alt="Banner Summer" class="w-100">
    </div>
    <div class="topbar sticky-top">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <a href="{{ url('/') }}">
                <img style="width: 150px; height: 70px;"
                    src="{{ asset('images/z6776223534015_3ec1a499b9bb824d97c41f77d3a677be-removebg-preview.png') }}"
                    alt="Logo">
            </a>
            <nav class="navbar navbar-expand-lg align-items-center">
                <div class="container">
                    <div class="collapse navbar-collapse">
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <li class="nav-item dropdown hover-dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->is('lich-chieu-rap') || request()->is('lich-chieu-phim') ? 'active-link' : '' }}"
                                    href="#">
                                    NOW SHOWING
                                </a>
                                <ul class="dropdown-menu custom-dropdown">
                                    <li><a class="dropdown-item" href="{{ route('Client.cinemaShowtime') }}">LỊCH
                                            CHIẾU RẠP</a></li>
                                    <li><a class="dropdown-item" href="{{ url('/lich-chieu-phim') }}">LỊCH CHIẾU
                                            PHIM</a></li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->is('cua-hang*') ? 'active-link' : '' }}"
                                    href="{{ url('/cua-hang') }}">THỨC ĂN & NƯỚC</a>
                            </li>
                            <li class="nav-item dropdown hover-dropdown">
                                <a class="nav-link dropdown-toggle {{ request()->is('he-thong-rap') || request()->is('ve-chung-toi') || request()->is('tuyen-dung') ? 'active-link' : '' }}"
                                    href="#">
                                    GIỚI THIỆU
                                </a>
                                <ul class="dropdown-menu custom-dropdown">
                                    <li><a class="dropdown-item" href="{{ url('/he-thong-rap') }}">HỆ THỐNG RẠP</a>
                                    </li>
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
            @php
                $selectedCity = session('selected_city') ?? 'Chọn khu vực của bạn';
            @endphp

            <div class="dropdown hover-dropdown">
                <button class="btn btn-outline-success dropdown-toggle" type="button">
                    {{ $selectedCity }}
                </button>
                <ul class="dropdown-menu custom-dropdown">
                    @foreach ($cities as $city)
                        <li><a class="dropdown-item"
                                href="{{ route('set.city', ['city' => $city]) }}">{{ $city }}</a></li>
                    @endforeach
                </ul>
            </div>

            @if (Auth::check())
                <a href="{{ url('/profile') }}" class="text-decoration-none text-dark">
                    <div class="d-flex align-items-center ms-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" width="24" class="me-1">
                        <span>{{ Auth::user()->full_name }} /
                            <strong>
                                <a href="#"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                    class="text-dark text-decoration-none">Thoát</a>
                            </strong>
                        </span>
                    </div>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            @else
                <div class="auth-hover-parent">
                    <button class="btn btn-success">Đăng nhập/Đăng ký</button>
                    <div class="auth-hover-box">
                        <form action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <label>Email *</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-2">
                                <label>Mật khẩu *</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="mb-2 text-end">
                                <a href="{{ route('forgotPassword') }}" class="forgot-password">Quên mật khẩu?</a>
                            </div>
                            <button type="submit" class="btn btn-success mb-2">Đăng nhập</button>
                        </form>

                        <button class="btn btn-primary w-100"
                            onclick="window.location.href='{{ route('register.form') }}'">
                            Đăng ký thành viên
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>


    @yield('content')

    <footer class="bg-dark text-white pt-5">
        <div class="container">
            <div class="row">


                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold">VỀ LUMI STAR</h5>
                    <hr class="mt-0"
                        style="height: 5px;width: 120px;border: none;background-color: #7fe784;border-radius: 10px;filter: drop-shadow(0 0 8px #7fe784) drop-shadow(0 0 16px #7fe784);">
                    <ul class="list-unstyled mt-3">
                        <li><a href="#" class="text-white text-decoration-none">Hệ thống rạp</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Cụm rạp</a></li>
                        <li><a href="#" class="text-white text-decoration-none">Liên hệ</a></li>
                    </ul>
                    <img src="{{ asset('images\image-21.png') }}" alt="Đã thông báo" width="200">
                </div>


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


                <div class="col-md-4 mb-4">
                    <h5 class="fw-bold">CHĂM SÓC KHÁCH HÀNG</h5>
                    <hr class="mt-0"
                        style="height: 5px;width: 120px;border: none;background-color: #7fe784;border-radius: 10px;filter: drop-shadow(0 0 8px #7fe784) drop-shadow(0 0 16px #7fe784);">
                    <p><strong>Hotline:</strong> 19002099</p>
                    <p><strong>Giờ làm việc:</strong> 9:00 - 22:00 (Tất cả các ngày bao gồm cả Lễ, Tết)</p>
                    <p><strong>Email hỗ trợ:</strong> <a href="mailto:cskh@bhdstar.vn"
                            class="text-white">cskh@lumistar.vn</a></p>
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
                    <p class="mb-0">COPYRIGHT 2010 LUMI STAR. ALL RIGHTS RESERVED</p>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const topbar = document.querySelector('.topbar');

        window.addEventListener('scroll', function () {
            if (window.scrollY > 50) {
                topbar.classList.add('shrink');
            } else {
                topbar.classList.remove('shrink');
            }
        });
    });
</script>

    @stack('scripts')
    @if (session('success'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
            <div id="toastSuccess" class="toast align-items-center text-white bg-success border-0 show"
                role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>

        <script>
            const toastEl = document.getElementById('toastSuccess');
            const toast = new bootstrap.Toast(toastEl, {
                delay: 4000
            });
            toast.show();
        </script>
    @endif
    @if ($errors->has('login_error'))
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
            <div id="toastError" class="toast align-items-center text-white bg-danger border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ $errors->first('login_error') }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>

        <script>
            const toastErrorEl = document.getElementById('toastError');
            const toastError = new bootstrap.Toast(toastErrorEl, {
                delay: 4000
            });
            toastError.show();
        </script>
    @endif

</body>

</html>
