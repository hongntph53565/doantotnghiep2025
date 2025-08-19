<div class="header d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-3">
        <button onclick="toggleSidebar()" class="btn btn-outline-light text-dark fs-4 border-0">
            <i class="bi bi-list"></i>
        </button>
    </div>

    <div class="d-flex align-items-center gap-3">
        <!-- Fullscreen -->
        <button onclick="toggleFullscreen()"
            class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center"
            style="width: 36px; height: 36px;">
            <i class="bi bi-arrows-fullscreen"></i>
        </button>

        <!-- Toggle theme -->
        <button onclick="toggleTheme()"
            class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center"
            style="width: 36px; height: 36px;">
            <i class="bi bi-moon" id="theme-icon"></i>
        </button>

        <!-- Avatar -->
        <div class="dropdown">
            @auth
                <a href="#"
                    class="d-flex align-items-center bg-light rounded px-2 py-1 text-decoration-none dropdown-toggle"
                    data-bs-toggle="dropdown">
                    <img src="https://i.pravatar.cc/40" class="rounded-circle me-2" width="36" height="36"
                        alt="avatar">
                    <div class="lh-sm d-none d-md-block">
                        <div class="fw-semibold">
                            @switch(Auth::user()->role_id) {{-- dùng role_id thay vì user_id --}}
                                @case(1)
                                    Admin
                                @break
                                @case(2)
                                    Manager
                                @break
                                @case(3)
                                    Staff
                                @break
                                @default
                                    User
                            @endswitch
                        </div>
                        <small class="text-muted text-uppercase" style="font-size: 11px;">
                            {{ Auth::user()->full_name }}
                        </small>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="#"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Đăng xuất
                        </a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </ul>
            @else
                <!-- Nếu chưa đăng nhập -->
               <a href="{{ auth()->check() ? route('home') : route('register.form') }}" class="btn btn-primary">
    Đăng nhập
</a>

            @endauth
        </div>
    </div>
</div>
