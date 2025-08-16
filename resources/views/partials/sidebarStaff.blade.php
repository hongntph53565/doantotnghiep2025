<nav class="sidebar" id="sidebar">
    <div class="logo">
        <span class="logo-full">LumiStar</span>
        <span class="logo-mini">LS</span>
    </div>

    <a href="{{ route('staff.list') }}" class="{{ request()->routeIs('staff.list') ? 'active' : '' }}">
        <i class="bi bi-ticket-perforated"></i>
        <span class="menu-text">Đặt vé</span>
    </a>

    <a href="{{ route('staff.combo') }}" class="{{ request()->routeIs('staff.combo') ? 'active' : '' }}">
        <i class="bi bi-ticket-perforated"></i>
        <span class="menu-text">Đặt đồ ăn</span>
    </a>

    <a href="{{ route('staff.search_ticket_online') }}" class="{{ request()->routeIs('staff.search_ticket_online') ? 'active' : '' }}">
        <i class="bi bi-search"></i>
        <span class="menu-text">Tìm vé online</span>
    </a>

    <a href="/" class="">
        <i class="bi bi-box-arrow-right"></i>
        <span class="menu-text">Thoát quản trị</span>
    </a>
</nav>
