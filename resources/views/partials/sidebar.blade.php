@php
    $route = request()->route()->getName();
@endphp

<nav class="sidebar {{ session('sidebar_collapsed') ? 'collapsed' : '' }}" id="sidebar">
    <div class="logo">
        <span class="logo-full">LumiStar</span>
        <span class="logo-mini">LS</span>
    </div>

    {{-- Tổng quan --}}
    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-house-door"></i><span class="menu-text">Tổng quan</span>
    </a>

    {{-- Thống kê --}}
    <a href="{{ route('admin.static') }}" class="{{ request()->routeIs('admin.static') ? 'active' : '' }}">
        <i class="bi bi-bar-chart"></i><span class="menu-text">Thống kê</span>
    </a>

    {{-- Hệ thống rạp --}}
    @php
        $isCinemaMenu = request()->routeIs('cinemas.*') || request()->routeIs('rooms.*') || request()->routeIs('cinemaseatprices.*');
    @endphp
    <a data-bs-toggle="collapse" href="#heThong" role="button" aria-expanded="{{ $isCinemaMenu ? 'true' : 'false' }}">
        <i class="bi bi-building"></i><span class="menu-text">Hệ thống rạp</span>
    </a>
    <div class="collapse submenu {{ $isCinemaMenu ? 'show' : '' }}" id="heThong">
        <a href="{{ route('cinemas.index') }}" class="{{ request()->routeIs('cinemas.*') ? 'active' : '' }}">
            <span class="menu-text">Rạp</span>
        </a>
        <a href="{{ route('rooms.index') }}" class="{{ request()->routeIs('rooms.*') ? 'active' : '' }}">
            <span class="menu-text">Phòng chiếu</span>
        </a>
        <a href="{{ route('cinemaseatprices.index') }}" class="{{ request()->routeIs('cinemaseatprices.*') ? 'active' : '' }}">
            <span class="menu-text">Quản lý giá ghế</span>
        </a>
    </div>

    {{-- Phim và Xuất Chiếu --}}
    @php
        $isMovieMenu = request()->routeIs('genres.*') || request()->routeIs('movies.*') || request()->routeIs('showtimes.*');
    @endphp
    <a data-bs-toggle="collapse" href="#phimXuatChieu" role="button" aria-expanded="{{ $isMovieMenu ? 'true' : 'false' }}">
        <i class="bi bi-film"></i><span class="menu-text">Phim và Xuất Chiếu</span>
    </a>
    <div class="collapse submenu {{ $isMovieMenu ? 'show' : '' }}" id="phimXuatChieu">
        <a href="{{ route('genres.index') }}" class="{{ request()->routeIs('genres.*') ? 'active' : '' }}">
            <span class="menu-text">Thể loại</span>
        </a>
        <a href="{{ route('movies.index') }}" class="{{ request()->routeIs('movies.*') ? 'active' : '' }}">
            <span class="menu-text">Quản lý phim</span>
        </a>
        <a href="{{ route('showtimes.index') }}" class="{{ request()->routeIs('showtimes.*') ? 'active' : '' }}">
            <span class="menu-text">Quản lý xuất chiếu</span>
        </a>
    </div>

    {{-- Đồ ăn thức uống --}}
    @php
        $isFoodMenu = request()->routeIs('foods.*');
    @endphp
    <a data-bs-toggle="collapse" href="#sidebarfood" role="button" aria-expanded="{{ $isFoodMenu ? 'true' : 'false' }}">
        <i class="bi bi-cup-straw"></i><span class="menu-text">Đồ ăn thức uống</span>
    </a>
    <div class="collapse submenu {{ $isFoodMenu ? 'show' : '' }}" id="sidebarfood">
        <a href="{{ route('foods.index') }}" class="{{ request()->routeIs('foods.*') ? 'active' : '' }}">
            <span class="menu-text">Thể Loại</span>
        </a>
    </div>

    {{-- Dịch vụ và Ưu đãi --}}
    @php
        $isPromoMenu = request()->routeIs('promotions.*') || request()->routeIs('extraprices.*');
    @endphp
    <a data-bs-toggle="collapse" href="#sidebarpromoption" role="button" aria-expanded="{{ $isPromoMenu ? 'true' : 'false' }}">
        <i class="bi bi-gift"></i><span class="menu-text">Dịch vụ và Ưu đãi</span>
    </a>
    <div class="collapse submenu {{ $isPromoMenu ? 'show' : '' }}" id="sidebarpromoption">
        <a href="{{ route('promotions.index') }}" class="{{ request()->routeIs('promotions.*') ? 'active' : '' }}">
            <span class="menu-text">Mã giảm giá</span>
        </a>
        <a href="{{ route('extraprices.index') }}" class="{{ request()->routeIs('extraprices.*') ? 'active' : '' }}">
            <span class="menu-text">Ngày lễ</span>
        </a>
    </div>

    {{-- Quản lý bài viết --}}
    @php
        $isPostMenu = request()->routeIs('posts.*');
    @endphp
    <a data-bs-toggle="collapse" href="#sidebarpost" role="button" aria-expanded="{{ $isPostMenu ? 'true' : 'false' }}">
        <i class="bi bi-journal-text"></i><span class="menu-text">Quản lý bài viết</span>
    </a>
    <div class="collapse submenu {{ $isPostMenu ? 'show' : '' }}" id="sidebarpost">
        <a href="{{ route('posts.index') }}" class="{{ request()->routeIs('posts.*') ? 'active' : '' }}">
            <span class="menu-text">Bài viết</span>
        </a>
    </div>

    {{-- Email --}}
    @php
        $isEmailMenu = request()->routeIs('template.*') || request()->routeIs('emaillog.*');
    @endphp
    <a data-bs-toggle="collapse" href="#email" role="button" aria-expanded="{{ $isEmailMenu ? 'true' : 'false' }}">
        <i class="bi bi-envelope"></i><span class="menu-text">Email</span>
    </a>
    <div class="collapse submenu {{ $isEmailMenu ? 'show' : '' }}" id="email">
        <a href="{{ route('template.index') }}" class="{{ request()->routeIs('template.*') ? 'active' : '' }}">
            <span class="menu-text">Mẫu email</span>
        </a>
        <a href="{{ route('emaillog.index') }}" class="{{ request()->routeIs('emaillog.*') ? 'active' : '' }}">
            <span class="menu-text">Mail đã gửi</span>
        </a>
    </div>

    {{-- Tài khoản --}}
    <a href="{{ route('users.index') }}" class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
        <i class="bi bi-person"></i><span class="menu-text">Tài khoản</span>
    </a>

    {{-- Thoát quản trị --}}
    <a href="/" class="">
        <i class="bi bi-box-arrow-right"></i><span class="menu-text">Thoát quản trị</span>
    </a>
</nav>
