<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Trang Phim')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Open+Sans&display=swap">
    
    @push('styles')
<link rel="stylesheet" href="{{ asset('css/headerLogin.css') }}">
@endpush
    @stack('styles')
</head>

<body>
    <div class="header-banner">
        <img src="{{ asset('images/Z1-1748x155-1.jpg') }}" alt="Banner Summer" class="w-100">
    </div>
    <div class="topbar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-4 d-flex justify-content-start">
                    <!-- Bỏ trống hoặc để sau -->
                </div>

                <div class="col-4 d-flex justify-content-center">
                    <a href="{{ url('/') }}">
                        <img style="width: 150px; height: 70px;"
                            src="{{ asset('images/z6776223534015_3ec1a499b9bb824d97c41f77d3a677be-removebg-preview.png') }}"
                            alt="Logo">
                    </a>
                </div>

                <div class="col-4 d-flex justify-content-end align-items-center">
                    <ul class="navbar-nav d-flex flex-row gap-2 me-3">
                        <li class="nav-item"><a class="nav-link" href="#">Quy Định</a></li>
                        <li class="nav-item"><a class="nav-link" href="#">FAQ</a></li>
                    </ul>
                    <div class="dropdown hover-dropdown">
                        <button class="btn btn-outline-success dropdown-toggle" type="button">
                            Hà Nội
                        </button>
                        <ul class="dropdown-menu custom-dropdown">
                            <li><a class="dropdown-item" href="#">Hà Nội</a></li>
                            <li><a class="dropdown-item" href="#">TP. Hồ Chí Minh</a></li>
                            <li><a class="dropdown-item" href="#">Đà Nẵng</a></li>
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

    <script>
        const registerForm = document.getElementById("registerForm");
        if (registerForm) {
            registerForm.addEventListener("submit", function(e) {
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
        }
    </script>

    @stack('scripts')
</body>

</html>
