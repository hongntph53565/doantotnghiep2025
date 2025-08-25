<!DOCTYPE html>
<html lang="vi">
  <head>
    <meta charset="UTF-8" />
    <title>Quản lý Giá Vé</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

      <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asseT('admin/css/styles.css') }}">
    <link rel="stylesheet" href="{{ asseT('admin/css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asseT('admin/css/header.css') }}">
      @stack('styles')
  </head>

  <body>
    <div class="container-fluid">
      <div class="row">

        @include('partials.managersidebar')

        {{--  --}}

        <div id="mainContent" class="col-md-9 col-lg-10 ms-sm-auto px-0">
          <!-- Header -->
          <div class="d-flex flex-column px-4 py-2 shadow-sm" style="background-color: #fff;">
              <!-- Hàng trên: nút 3 gạch + các icon -->

              @include('partials.header')

              <!-- Đường gạch ngang -->
              <hr style="margin-top: 95px">

              @php
    use Illuminate\Support\Facades\Route;

    $route = Route::currentRouteName();

    // Mặc định
    $headerTitle = 'Trang quản lý';
    $breadcrumbs = [
        ['label' => 'Dashboard', 'url' => route('manager.static', [], false) ?? '#'],
        ['label' => 'Trang hiện tại', 'url' => null],
    ];

@endphp

@switch($route)
    {{-- DASHBOARD --}}
    @case('manager.static')
    @case('manager.dashboard')
        @php
            $headerTitle = 'Thống kê';
            $breadcrumbs = [
                ['label' => 'Dashboard', 'url' => null],
            ];
        @endphp
        @break

    {{-- PHÒNG CHIẾU --}}
    @case('manager.rooms.index')
        @php
            $headerTitle = 'Rạp và phòng chiếu';
            $breadcrumbs = [
                ['label' => 'Phòng chiếu', 'url' => null],
                ['label' => 'Danh sách', 'url' => null],
            ];
        @endphp
        @break

    @case('manager.rooms.create')
        @php
            $headerTitle = 'Rạp và phòng chiếu';
            $breadcrumbs = [
                ['label' => 'Phòng chiếu', 'url' => null],
                ['label' => 'Tạo mới', 'url' => null],
            ];
        @endphp
        @break

    @case('manager.rooms.edit')
        @php
            $headerTitle = 'Rạp và phòng chiếu';
            $breadcrumbs = [
                ['label' => 'Phòng chiếu', 'url' => null],
                ['label' => 'Cập nhật', 'url' => null],
            ];
        @endphp
        @break

    {{-- SUẤT CHIẾU --}}
    @case('manager.showtimes.index')
        @php
            $headerTitle = 'suất chiếu';
            $breadcrumbs = [
                ['label' => 'Suất chiếu', 'url' => null],
                ['label' => 'Danh sách', 'url' => null],
            ];
        @endphp
        @break

    @case('manager.showtimes.create')
        @php
            $headerTitle = 'suất chiếu';
            $breadcrumbs = [
                ['label' => 'Suất chiếu', 'url' => null],
                ['label' => 'Tạo mới', 'url' => null],
            ];
        @endphp
        @break

    {{-- GIÁ GHẾ --}}
    @case('manager.cinemaseatprices.index')
        @php
            $headerTitle = 'Rạp và Phòng chiếu';
            $breadcrumbs = [
                ['label' => 'Giá ghế', 'url' => null],
                ['label' => 'Danh sách', 'url' => null],
            ];
        @endphp
        @break

    {{-- ĐỒ ĂN --}}
    @case('manager.foods.index')
        @php
            $headerTitle = 'Đồ ăn & thức uống';
            $breadcrumbs = [
                ['label' => 'Đồ ăn thức uống', 'url' => null],
                ['label' => 'Danh sách', 'url' => null],
            ];
        @endphp
        @break

    {{-- HÓA ĐƠN --}}
    @case('manager.bills.index')
        @php
            $headerTitle = 'Hóa đơn';
            $breadcrumbs = [
                ['label' => 'Hóa đơn', 'url' => null],
                ['label' => 'Danh sách', 'url' => null],
            ];
        @endphp
        @break
    @case('manager.bills.show')
        @php
            $headerTitle = 'Hóa đơn';
            $breadcrumbs = [
                ['label' => 'Hóa đơn', 'url' => null],
                ['label' => 'Chi tiết', 'url' => null],
            ];
        @endphp
        @break
    @default

@endswitch

<div class="d-flex justify-content-between align-items-center px-4 py-2 bg-light">
    <h6 class="mb-0 fw-bold text-uppercase">{{ $headerTitle }}</h6>
    <nav aria-label="breadcrumb">
        @php
    $count = count($breadcrumbs);
    $parentIndex = $count >= 2 ? $count - 2 : null;
@endphp

<ol class="breadcrumb mb-0">
    @foreach ($breadcrumbs as $i => $bc)
        @php
            $isActive = empty($bc['url']);
            $isParent = $parentIndex !== null && $i === $parentIndex;
        @endphp

        <li class="breadcrumb-item {{ $isActive ? 'active' : '' }}" @if($isActive) aria-current="page" @endif>
            @if (!empty($bc['url']))
                <a href="{{ $bc['url'] }}" class="{{ $isParent ? 'fw-bold' : '' }}">
                    {{ $bc['label'] }}
                </a>
            @else
                <span class="{{ $isParent ? 'fw-bold' : '' }}">
                    {{ $bc['label'] }}
                </span>
            @endif
        </li>
    @endforeach
</ol>
    </nav>
</div>


          </div>

          <!-- Nội dung -->
          <main class="container mt-4">
            @yield('content')
          </main>
        </div>

        {{--  --}}
      </div>
    </div>
    <script src="{{ asset('admin/js/sidebar.js') }}"></script>
      @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>

    </script>
  </body>
</html>
