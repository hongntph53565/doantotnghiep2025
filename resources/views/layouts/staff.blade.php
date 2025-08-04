<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <title>Quản lý Giá Vé</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Rubik+Mono+One&display=swap"rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('admin/css/styles.css') }}">
<link rel="stylesheet" href="{{ asset('admin/css/sidebar.css') }}">
<link rel="stylesheet" href="{{ asset('admin/css/header.css') }}">

    @stack('styles')    
</head>

<body>
    <div class="container-fluid">
        <div class="row">

            @include('partials.sidebarStaff')

            {{--  --}}

            <div id="mainContent" class="col-md-9 col-lg-10 ms-sm-auto px-0">
                <!-- Header -->
                <div class="d-flex flex-column px-4 py-2 shadow-sm" style="background-color: #fff;">
                    <!-- Hàng trên: nút 3 gạch + các icon -->

                    @include('partials.header')

                    <!-- Đường gạch ngang -->
                    <hr style="margin-top: 95px">

                    {{-- <div class="d-flex justify-content-between align-items-center px-4 py-2 bg-light">
                        <h6 class="mb-0 fw-bold text-uppercase">@yield('title2', 'none')</h6>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item fw-semibold">@yield('title1', 'none')</li>
                                <li class="breadcrumb-item active" aria-current="page">@yield('title', 'none')</li>
                            </ol>
                        </nav>
                    </div> --}}

                </div>

                <!-- Nội dung -->
                <main class="container-fluid">
                    @yield('content')
                </main>
            </div>

            {{--  --}}
        </div>
    </div>
    <br><br><br>
    <script src="{{ asset('admin/js/sidebar.js') }}"></script>
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script></script>
</body>

</html>
