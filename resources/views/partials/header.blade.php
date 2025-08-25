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
        <button class="d-flex align-items-center bg-light rounded px-2 py-1 text-decoration-none dropdown-toggle border-0"
                id="userDropdown"
                data-bs-toggle="dropdown"
                aria-expanded="false">
            <img src="https://i.pravatar.cc/40" class="rounded-circle me-2" width="36" height="36" alt="avatar">
            <div class="lh-sm d-none d-md-block text-start">
                <div class="fw-semibold">
                    @switch(Auth::user()->role_id)
                        @case(1) Admin @break
                        @case(2) Manager @break
                        @case(3) Staff @break
                        @default User
                    @endswitch
                </div>
                <small class="text-muted text-uppercase" style="font-size: 11px;">
                    {{ Auth::user()->full_name }}
                </small>
            </div>
        </button>

        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="dropdown-item">Đăng xuất</button>
                </form>
            </li>
        </ul>
    @else
        <a href="{{ route('login') }}" class="btn btn-primary">Đăng nhập</a>
    @endauth
</div>


    </div>
</div>
