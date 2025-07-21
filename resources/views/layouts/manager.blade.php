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

              <div class="d-flex justify-content-between align-items-center px-4 py-2 bg-light">
                  <h6 class="mb-0 fw-bold text-uppercase">@yield('title2', 'none')</h6>
                  <nav aria-label="breadcrumb">
                      <ol class="breadcrumb mb-0">
                          <li class="breadcrumb-item fw-semibold">@yield('title1', 'none')</li>
                          <li class="breadcrumb-item active" aria-current="page">@yield('title', 'none')</li>
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