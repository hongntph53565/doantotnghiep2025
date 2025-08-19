<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Trang Phim')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        /* HEADER SUMMER STYLE */
        .summer-banner {
            background-color: #dff6fd;
            border-bottom: 1px solid #ccc;
        }

        .summer-banner img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .header-bar {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .steps .step {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            border: 2px dashed #ccc;
            color: #888;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            background-color: #fefefe;
            font-size: 15px;
        }

        .steps .step.active {
            border-color: #28a745;
            color: #28a745;
            background-color: #e7f8ec;
        }

        @media (max-width: 768px) {
            .header-bar {
                flex-direction: column;
                text-align: center;
            }

            .steps {
                justify-content: center;
                margin-top: 10px;
            }
        }

        /* Các style còn lại bạn đã có sẵn */
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
            margin-bottom: 30px;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
            flex-wrap: wrap;
            gap: 12px;
        }

        .cinema-box img {
            width: 120px;
            height: auto;
            border-radius: 8px;
            margin: 0;
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

        .btn-detail {
            background-color: #7bc043;
            color: white;
            font-weight: 500;
            border: none;
        }

        .btn-detail:hover {
            background-color: #5fa334;
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
        }

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

        .header-divider {
            border: none;
            border-top: 1px solid #000;
            margin: 0 auto;
            width: 100%;
            max-width: 1140px;
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
    </style>
    @stack('styles')

</head>

<body>

    {{-- HEADER MÙA HÈ --}}
    <header class="summer-header">
        <div class="summer-banner">
            <img src="{{ asset('images/Z1-1748x155-1.jpg') }}" alt="Hello Summer" class="w-100">
        </div>

        <div class="header-bar container d-flex justify-content-between align-items-center flex-wrap">
            <div class="d-flex align-items-center flex-wrap">
                <a id="logo-link" href="{{ url('/home') }}">
                    <img src="{{ asset('images/z6776223534015_3ec1a499b9bb824d97c41f77d3a677be-removebg-preview.png') }}"
                        alt="Logo" class="me-3" style="width: 180px; height: auto;">
                </a>
                <div class="steps d-flex gap-4">
                    @for ($i = 1; $i <= 4; $i++)
                        <div class="step {{ $i == 1 ? 'active' : '' }}">
                            {{ sprintf('%02d', $i) }}
                        </div>
                    @endfor
                </div>
            </div>

            <div class="d-flex align-items-center mt-3 mt-md-0 flex-wrap justify-content-end gap-3">
                <a href="#" class="text-decoration-none text-dark fw-semibold">Quy định</a>
                <a href="#" class="text-decoration-none text-dark fw-semibold">FAQ</a>

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
                                <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" width="24"
                                    class="me-1">
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
                                        <a href="#" class="small text-white">Quên mật khẩu?</a>
                                    </div>
                                    <button type="submit" class="btn btn-success mb-2">Đăng nhập</button>
                                </form>

                                <a href="{{ route('register.form') }}" class="btn btn-primary w-100">Đăng ký thành
                                    viên</a>

                            </div>
                            <script>
                                document.getElementById("registerForm").addEventListener("submit", function(e) {
                                    e.preventDefault();
                                    const formData = new FormData(this);

                                    fetch("{{ route('register') }}", {
                                            method: "POST",
                                            body: formData,
                                            headers: {
                                                'X-Requested-With': 'XMLHttpRequest',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                            }
                                        })
                                        .then(res => res.json())
                                        .then(data => {
                                            if (data.message === "Đăng ký thành công") {
                                                window.location.href = "{{ route('login.form') }}";
                                            } else {
                                                alert(data.message || "Có lỗi xảy ra!");
                                            }
                                        })
                                        .catch(err => console.error(err));
                                });
                            </script>
                        </div>
                    @endif
                </div>
            </div>
    </header>

    <hr class="header-divider my-0">

    {{-- Nội dung động --}}
    @yield('content')

    {{-- FOOTER --}}
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
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const logoLink = document.getElementById("logo-link");
        if (logoLink) {
            logoLink.addEventListener("click", function(e) {
                e.preventDefault();
                sessionStorage.clear();
                window.location.href = this.href;
            });
        }
    });
</script>
