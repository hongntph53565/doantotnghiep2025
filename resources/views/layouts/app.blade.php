<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>LumiStar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>

<body>

    {{-- <div id="overlay" class="overlay"></div>
    <div class="popup" id="popup" style="display:none;">
        <h2>Vui lòng chọn rạp để tiếp tục quá trình đặt hàng</h2>

        <label for="cinema">Mời bạn chọn rạp</label>
        <select id="cinema">
            <option value="">Vui lòng chọn</option>
            <!-- Thêm các rạp cụ thể tại đây -->
        </select>

        <button class="confirm-btn" onclick="closePopup()">XÁC NHẬN</button>

        <p class="thanks">
            Cám ơn bạn đã lựa chọn dịch vụ của
            <span class="highlight">LumiStar</span>!
        </p>
    </div> --}}

    <header class="header">
        <!-- <div class="top-banner">
            <img src="banner.png" alt="Children's Day Banner">
        </div> -->
        <div class="nav-bar">
            <div class="left-section">
                <div class="logo">
                    <img src="{{ asset('images/logo.jpg') }}" alt="LumiStar Logo" />
                </div>

                <nav class="menu">
                    <div class="close-btn" id="close-menu">✖</div>
                    <a href="#">NOW SHOWING</a>
                    <a href="#" id="food">ĐỒ ĂN/COMBO</a>
                    <a href="#">KHUYẾN MÃI</a>
                    <a href="#">DỊCH VỤ</a>
                    <a href="#">VỀ LUMISTAR</a>
                </nav>

                <div class="menu-overlay" id="menu-overlay"></div>
            </div>

            <div class="right-section">

                <select class="location">
                    <option>HÀ NỘI</option>
                    <option>TP. HCM</option>
                </select>
                <div class="user" style="float: right;">
                    <img src="{{ asset('images/avatar.png') }}" alt="User Avatar" />
                    <span>Hong Nguyen</span> / <a href="#">Thoát</a>
                </div>

                <div class="menu-toggle" id="menu-toggle">☰</div> <!-- thêm vào đây -->
            </div>
        </div>


    </header>
    {{-- Main Content --}}
    @yield('content')
    <footer class="footer">
        <div class="footer-container">
            <!-- Về BHD Star -->
            <div class="footer-column">
                <h2>VỀ LUMI STAR</h2>
                <div class="footer-line"></div>
                <ul>
                    <li>Hệ thống rạp</li>
                    <li>Cụm rạp</li>
                    <li>Liên hệ</li>
                </ul>
                <img src="{{ asset('images/image-21.png') }}" alt="Đã thông báo" class="gov-badge" />
            </div>

            <!-- Quy định & Điều khoản -->
            <div class="footer-column">
                <h2>QUY ĐỊNH & ĐIỀU KHOẢN</h2>
                <div class="footer-line"></div>
                <ul>
                    <li>Quy định thành viên</li>
                    <li>Điều khoản</li>
                    <li>Hướng dẫn đặt vé trực tuyến</li>
                    <li>Quy định và chính sách chung</li>
                    <li>Chính sách bảo vệ thông tin cá nhân của người tiêu dùng</li>
                </ul>
            </div>

            <!-- Chăm sóc khách hàng -->
            <div class="footer-column">
                <h2>CHĂM SÓC KHÁCH HÀNG</h2>
                <div class="footer-line"></div>
                <p><strong>Hotline:</strong> 19002099</p>
                <p>
                    <strong>Giờ làm việc:</strong> 9:00 - 22:00 (Tất cả các ngày bao gồm
                    cả Lễ, Tết)
                </p>
                <p><strong>Email hỗ trợ:</strong> cskh@lumistar.vn</p>
                <h3>MẠNG XÃ HỘI</h3>
                <div class="social-icons">
                    <img src="https://cdn-icons-png.flaticon.com/512/733/733547.png" alt="Facebook" />
                    <img src="https://cdn-icons-png.flaticon.com/512/733/733558.png" alt="Instagram" />
                    <img src="https://cdn-icons-png.flaticon.com/512/3046/3046121.png" alt="TikTok" />
                    <img src="https://cdn-icons-png.flaticon.com/512/1384/1384060.png" alt="YouTube" />
                    <img src="https://cdn-icons-png.flaticon.com/512/906/906377.png" alt="Zalo" />
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="footer-bottom-container">
                <img src="{{ asset('images/logo.jpg') }}" alt="LumiStar Logo" class="footer-logo" />
                <div class="footer-info">
                    <p>
                        <strong>Công ty TNHH MTV Ngôi Sao Cineplex LumiStar Việt Nam</strong>
                    </p>
                    <p>
                        <strong>Giấy CNĐKDN:</strong> Giấy phép kinh doanh số: 0104597158.
                        Đăng ký lần đầu ngày 12 tháng 05 năm 2025
                    </p>
                    <p>
                        <strong>Địa Chỉ:</strong> Tầng 11, Tòa nhà Hồng Hà Building, Lý
                        Thường Kiệt, P.Phan Chu Trinh, Quận Hoàn Kiếm, Hà Nội
                    </p>
                    <p><strong>Hotline:</strong> 19002099</p>
                    <p>COPYRIGHT 2025 LUMI STAR. ALL RIGHTS RESERVED</p>
                </div>
            </div>
        </div>
    </footer>

    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous">
    </script>

    <script src="{{ asset('js/test.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
