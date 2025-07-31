    <nav class="sidebar" id="sidebar">
        <div class="logo">
            <span class="logo-full">LumiStar</span>
            <span class="logo-mini">LS</span>
        </div>
        <a href="{{ route('manager.static') }}"><i class="bi bi-bar-chart"></i><span class="menu-text">Thống kê</span></a>

        <a data-bs-toggle="collapse" href="#heThong" role="button">
            <i class="bi bi-building"></i><span class="menu-text">Hệ thống rạp</span>
        </a>
        <div class="collapse submenu" id="heThong">
            {{-- <a href="{{ route('cinemas.index') }}"><span class="menu-text">Rạp</span></a> --}}
            <a href="{{ route('manager.rooms.index') }}"><span class="menu-text">phòng chiếu</span></a>
            <a href="{{ route('manager.cinemaseatprices.index') }}"><span class="menu-text">Quản lý giá ghế</span></a>
        </div>

        <a data-bs-toggle="collapse" href="#phimXuatChieu" role="button">
            <i class="bi bi-film"></i><span class="menu-text">Phim và Xuất Chiếu</span>
        </a>
        <div class="collapse submenu" id="phimXuatChieu">
            <a href="{{ route('manager.genres.index') }}"><span class="menu-text">Thể Loại</span></a>
            <a href="{{ route('manager.movies.index') }}"><span class="menu-text">Quản lý phim</span></a>
            <a href="{{ route('manager.showtimes.index') }}"><span class="menu-text">Quản lý xuất chiếu</span></a>
        </div>

        <a data-bs-toggle="collapse" href="#sidebarfood" role="button">
            <i class="bi bi-cup-straw"></i><span class="menu-text">Đồ ăn thức uống</span>
        </a>
        <div class="collapse submenu" id="sidebarfood">
            <a href="{{ route('manager.foods.index') }}"><span class="menu-text">Thể Loại</span></a>
            {{-- <a href="{{ route('movies.index') }}"><span class="menu-text">Quản lý </span></a> --}}
        </div>

        <a href="/"><i class="bi bi-box-arrow-right"></i><span class="menu-text">Thoát quản trị</span></a>
    </nav>
