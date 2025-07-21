    <nav class="sidebar" id="sidebar">
        <div class="logo">
            <span class="logo-full">LumiStar</span>
            <span class="logo-mini">LS</span>
        </div>
        <a href="{{ route('admin.dashboard') }}"><i class="bi bi-house-door"></i><span class="menu-text">Tổng quan</span></a>
        <a href="{{ route('admin.static') }}"><i class="bi bi-bar-chart"></i><span class="menu-text">Thống kê</span></a>

        <a data-bs-toggle="collapse" href="#heThong" role="button">
            <i class="bi bi-building"></i><span class="menu-text">Hệ thống rạp</span>
        </a>
        <div class="collapse submenu" id="heThong">
            <a href="{{ route('cinemas.index') }}"><span class="menu-text">Rạp</span></a>
            <a href="{{ route('rooms.index') }}"><span class="menu-text">phòng chiếu</span></a>
            <a href="{{ route('cinemaseatprices.index') }}"><span class="menu-text">Quản lý giá ghế</span></a>
        </div>

        <a data-bs-toggle="collapse" href="#phimXuatChieu" role="button">
            <i class="bi bi-film"></i><span class="menu-text">Phim và Xuất Chiếu</span>
        </a>
        <div class="collapse submenu" id="phimXuatChieu">
            <a href="{{ route('genres.index') }}"><span class="menu-text">Thể Loại</span></a>
            <a href="{{ route('movies.index') }}"><span class="menu-text">Quản lý phim</span></a>
            <a href="{{ route('showtimes.index') }}"><span class="menu-text">Quản lý xuất chiếu</span></a>
        </div>

        <a data-bs-toggle="collapse" href="#sidebarfood" role="button">
            <i class="bi bi-cup-straw"></i><span class="menu-text">Đồ ăn thức uống</span>
        </a>
        <div class="collapse submenu" id="sidebarfood">
            <a href="{{ route('foods.index') }}"><span class="menu-text">Thể Loại</span></a>
            <a href="{{ route('movies.index') }}"><span class="menu-text">Quản lý </span></a>
        </div>

        <a data-bs-toggle="collapse" href="#sidebarpromoption" role="button">
            <i class="bi bi bi-gift"></i><span class="menu-text">Dịch vụ và Ưu đãi</span>
        </a>
        <div class="collapse submenu" id="sidebarpromoption">
            <a href="{{ route('promotions.index') }}"><span class="menu-text">Mã giảm giá</span></a>
            <a href="{{ route('extraprices.index') }}"><span class="menu-text">Ngày lễ</span></a>
        </div>

        <a data-bs-toggle="collapse" href="#sidebarpost" role="button">
            <i class="bi bi-journal-text"></i><span class="menu-text">Quản lý bài viết</span>
        </a>
        <div class="collapse submenu" id="sidebarpost">
            {{-- <a href="{{ route('categories.index') }}"><span class="menu-text">Danh mục</span></a> --}}
            <a href="{{ route('posts.index') }}"><span class="menu-text">Bài viết</span></a>
        </div>

        <a data-bs-toggle="collapse" href="#email" role="button">
            <i class="bi bi-envelope"></i><span class="menu-text">Email</span>
        </a>
        <div class="collapse submenu" id="email">
            <a href="{{ route('template.index') }}"><span class="menu-text">Mẫu email</span></a>
            <a href="{{ route('emaillog.index') }}"><span class="menu-text">Mail đã gửi</span></a>
        </div>
        <a href="{{ route('users.index') }}"><i class="bi bi-person"></i><span class="menu-text">Tài khoản</span></a>
    </nav>
