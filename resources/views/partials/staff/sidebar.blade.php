<nav class="sidebar" id="sidebar">
    <div class="logo">
        <a href="{{ route('staff.index') }}"><span class="logo-full">LumiStar</span></a>
        <span class="logo-mini">LS</span>
    </div>

    <!-- Tìm khách -->
    <a href="">
        <i class="bi bi-search"></i><span class="menu-text">Tìm khách</span>
    </a>

    <!-- Phim và Xuất Chiếu -->
    <a data-bs-toggle="collapse" href="#phimXuatChieu" role="button">
        <i class="bi bi-film"></i><span class="menu-text">Phim và Xuất Chiếu</span>
    </a>
    <div class="collapse submenu" id="phimXuatChieu">
        <a href="{{ route('staff.nowShowing') }}"><i class="bi bi-camera-reels"></i><span class="menu-text">Phim đang chiếu</span></a>
        <a href="{{ route('staff.comingSoon') }}"><i class="bi bi-calendar-event"></i><span class="menu-text">Phim sắp chiếu</span></a>
    </div>

    <!-- Đồ ăn thức uống -->
    <a href="{{ route('foods.index') }}">
        <i class="bi bi-cup-straw"></i><span class="menu-text">Đồ ăn thức uống</span>
    </a>

    <!-- Khách hàng -->
    <a data-bs-toggle="collapse" href="#sidebarpromoption" role="button">
        <i class="bi bi-person-vcard"></i><span class="menu-text">Khách hàng</span>
    </a>

    <!-- Vé Online -->
    <a href="#">
        <i class="bi bi-ticket-perforated"></i><span class="menu-text">Vé Online</span>
    </a>

</nav>
