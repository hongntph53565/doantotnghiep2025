@php
    $route = request()->route()->getName();

    // Kiểm tra menu đang mở
    $isCinemaMenu = request()->routeIs('manager.rooms.*') || request()->routeIs('manager.cinemaseatprices.*');
    $isShowtimeMenu = request()->routeIs('manager.showtimes.*');
    $isFoodMenu = request()->routeIs('manager.foods.*');
@endphp
@php
    $uid = auth()->user()->user_id ?? auth()->id();
    $cinemaId = \DB::table('manager_cinema')
        ->where('user_id', $uid)
        ->value('cinema_id');
    $cinemaName = \App\Models\Cinema::where('cinema_id', $cinemaId)->value('name');
@endphp

<nav class="sidebar {{ session('sidebar_collapsed') ? 'collapsed' : '' }}" id="sidebar">
    <div class="logo">
            <span class="logo-full">LumiStar <br> @if ($cinemaName)
             <p style="font-size: 18px">{{   $cinemaName }}</p>

            @endif </span>
            <span class="logo-mini">LS</span>
        </div>

    <a href="{{ route('manager.static') }}" class="{{ request()->routeIs('manager.static') ? 'active' : '' }}">
        <i class="bi bi-bar-chart"></i><span class="menu-text">Thống kê</span>
    </a>

    <a data-bs-toggle="collapse" href="#heThong" role="button" aria-expanded="{{ $isCinemaMenu ? 'true' : 'false' }}">
        <i class="bi bi-building"></i><span class="menu-text">Rạp và Phòng chiếu</span>
    </a>
    <div class="collapse submenu {{ $isCinemaMenu ? 'show' : '' }}" id="heThong">
        <a href="{{ route('manager.rooms.index') }}" class="{{ request()->routeIs('manager.rooms.*') ? 'active' : '' }}">
            <span class="menu-text">Phòng chiếu</span>
        </a>
        <a href="{{ route('manager.cinemaseatprices.index') }}" class="{{ request()->routeIs('manager.cinemaseatprices.*') ? 'active' : '' }}">
            <span class="menu-text">Quản lý giá ghế</span>
        </a>
    </div>

    <a data-bs-toggle="collapse" href="#phimXuatChieu" role="button" aria-expanded="{{ $isShowtimeMenu ? 'true' : 'false' }}">
        <i class="bi bi-film"></i><span class="menu-text">Suất Chiếu</span>
    </a>
    <div class="collapse submenu {{ $isShowtimeMenu ? 'show' : '' }}" id="phimXuatChieu">
        <a href="{{ route('manager.showtimes.index') }}" class="{{ request()->routeIs('manager.showtimes.*') ? 'active' : '' }}">
            <span class="menu-text">Quản lý suất chiếu</span>
        </a>
    </div>

    <a data-bs-toggle="collapse" href="#sidebarfood" role="button" aria-expanded="{{ $isFoodMenu ? 'true' : 'false' }}">
        <i class="bi bi-cup-straw"></i><span class="menu-text">Đồ ăn thức uống</span>
    </a>
    <div class="collapse submenu {{ $isFoodMenu ? 'show' : '' }}" id="sidebarfood">
        <a href="{{ route('manager.foods.index') }}" class="{{ request()->routeIs('manager.foods.*') ? 'active' : '' }}">
            <span class="menu-text">Quản lý món</span>
        </a>
    </div>

    <a href="/"><i class="bi bi-box-arrow-right"></i><span class="menu-text">Thoát quản trị</span></a>
</nav>
