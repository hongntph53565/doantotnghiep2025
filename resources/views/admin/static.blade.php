@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/css/static.css') }}">
    
@endpush

@section('title2')
    Thống Kê
@endsection

@section('title1')
    Thống Kê
@endsection

@section('title')
    Thống Kê
@endsection
@section('content')
    <form class="row g-3 align-items-end mb-4" method="GET">
        <div class="col">
            <label class="form-label">Ngày bắt đầu</label>
            <input type="date" name="Sdate" class="form-control" value="{{ request('Sdate') }}">
        </div>
        <div class="col">
            <label class="form-label">Ngày kết thúc</label>
            <input type="date" name="Edate" class="form-control" value="{{ request('Edate') }}">
        </div>
        <div class="col">
            <label class="form-label">Khu vực</label>
            <select class="form-select" name="city">
                <option value="">--- Tất cả ---</option>
                @foreach ($cities as $city)
                    <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>
                        {{ $city }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <label class="form-label">Rạp chiếu</label>
            <select class="form-select" name="cinema_id">
                <option value="">--- Tất cả ---</option>
                @foreach ($cinemas as $cinema)
                    <option value="{{ $cinema->cinema_id }}"
                        {{ request('cinema_id') == $cinema->cinema_id ? 'selected' : '' }}>
                        {{ $cinema->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col">
            <label class="form-label">Phim</label>
            <select class="form-select" name="movie_id">
                <option value="">--- Tất cả ---</option>
                @foreach ($movies as $movie)
                    <option value="{{ $movie->movie_id }}" {{ request('movie_id') == $movie->movie_id ? 'selected' : '' }}>
                        {{ $movie->title }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary">Lọc</button>
        </div>
    </form>



    <!-- Tổng quan -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h5>Tổng doanh thu tháng</h5>
                    <h4 class="text-primary">
                        {{ number_format($totalRevenue, 0, ',', '.') }} ₫
                    </h4>
                    <p class="card-text small text-muted">{{ $startDate->format('d/m/Y') }} -
                        {{ $endDate->format('d/m/Y') }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    @if ($highestCinemaRevenue)
                        <h6>Rạp có doanh thu cao nhất</h6>
                        <h5>{{ $highestCinemaRevenue->cinema_name }}</h5>
                        <h4 class="text-primary">
                            {{ number_format($highestCinemaRevenue->total_revenue, 0, ',', '.') }} ₫
                        </h4>
                    @else
                        <h5>Rạp có doanh thu cao nhất</h5>
                        <h5>Chưa có doanh thu</h5>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    @if ($topMovie)
                        <h5>Phim doanh thu cao nhất</h5>

                        <img src="{{ asset('storage/' . $topMovie->poster) }}" alt="{{ $topMovie->title }}"
                            style="height:125px; width:100px; object-fit:cover;">
                        <br>
                        <br>
                        <h5>{{ $topMovie->title }}</h5>

                        <h4 class="text-primary">
                            {{ number_format($topMovie->total_revenue, 0, ',', '.') }} ₫
                        </h4>
                    @else
                        <h6>Phim doanh thu cao nhất</h6>
                        <h5>Chưa có doanh thu</h5>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    @if ($topFood)
                        <h6>Đồ ăn bán chạy nhất</h6>
                        <h5>{{ $topFood->name }}</h5>
                        <img src="{{ asset('storage/' . $topFood->image) }}" alt="{{ $topFood->name }}"
                            style="height:125px; width:100px; object-fit:cover;">
                        <br>
                        <small>Đã bán: {{ $topFood->total_quantity }}</small>
                        <br>
                        <small>Doanh thu: {{ number_format($topFood->total_revenue, 0, ',', '.') }} đ</small>
                    @else
                        <h6>Đồ ăn bán chạy nhất</h6>
                        <h5>Chưa có sản phẩm nào được bán</h5>
                    @endif
                </div>
            </div>
        </div>

        {{-- <div class="col-md-3 mt-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    @if ($topPaymentMethod)
                        <h6>PTTT phổ biến</h6>
                        <h5>{{ strtoupper($topPaymentMethod->payment_method) }}</h5>
                        <small>Chiếm {{ $percentage }}%</small>
                    @else
                        <h6>PTTT phổ biến</h6>
                        <h5>ko có thông tin</h5>
                    @endif
                </div>
            </div>
        </div> --}}

        <div class="col-md-3 mt-3">
    <div class="card shadow-sm text-center">
        <img src="{{ asset('images/payos.png') }}" alt="VNPAY" class="payment-logo" style="top: 10px; right: 10px; font-size: 30px;">
        <div class="card-body">
            <h6>Tổng tiền PTTT PayOS</h6>
            <h5>{{ number_format($payosRevenue, 0, ',', '.') }} đ</h5>
        </div>
    </div>
</div>
<div class="col-md-3 mt-3">
    <div class="card shadow-sm text-center position-relative">
        <img src="{{ asset('images/vnpay.png') }}" alt="VNPAY" class="payment-logo">
        <div class="card-body">
            <h6>Tổng tiền PTTT VNPAY</h6>
            <h5>{{ number_format($vnpayRevenue , 0, ',', '.') }} đ</h5>
        </div>
    </div>
</div>

<div class="col-md-3 mt-3">
    <div class="card shadow-sm text-center position-relative">
        <img src="{{ asset('images/zalopay.png') }}" alt="ZaloPay" class="payment-logo">
        <div class="card-body">
            <h6>Tổng tiền PTTT ZALOPAY</h6>
            <h5>{{ number_format($zalopayRevenue, 0, ',', '.') }} đ</h5>
        </div>
    </div>
</div>

<div class="col-md-3 mt-3">
    <div class="card shadow-sm text-center position-relative">
        <i class="fa-solid fa-money-bill-wave text-success position-absolute" 
   style="top: 10px; right: 10px; font-size: 30px;"></i>
        <div class="card-body">
            <h6>Tổng tiền PTTT tiền mặt</h6>
            <h5>{{ number_format($cashRevenue, 0, ',', '.') }} đ</h5>
        </div>
    </div>
</div>


    </div>
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Doanh thu theo phim</h6>
            <canvas id="theoPhimChart"></canvas>
        </div>
    </div>
    <div class="card">
        <div class="card-header fw-bold">Doanh thu theo rạp</div>
        <div class="card-body">
            <canvas id="theoRapChart"></canvas>
        </div>
    </div>

    <div class="card">
        <div class="card-header fw-bold">Phương thức thanh toán</div>
        <div class="card-body">
            <canvas id="ptttChart"></canvas>
        </div>
    </div>

    <div style="height: 50px"></div>
@endsection

@push('scripts')
    <script>
        const xuHuongLabels = {!! json_encode($labels) !!};
        const xuHuongData = {!! json_encode($data) !!};

        new Chart(document.getElementById("xuHuongChart"), {
            type: "line",
            data: {
                labels: xuHuongLabels,
                datasets: [{
                    label: "Doanh thu (₫)",
                    data: xuHuongData,
                    fill: true,
                    tension: 0.3,
                    borderColor: "#DAF4F0",
                    backgroundColor: "rgba(13,110,253,0.2)",
                }, ],
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        ticks: {
                            callback: (value) => value.toLocaleString("vi-VN") + " ₫",
                        },
                    },
                },
                plugins: {
                    legend: {
                        position: "top",
                    },
                },
            },
        });
    </script>
    <script>
        const ptttLabels = {!! json_encode($plabels) !!};
        const ptttData = {!! json_encode($pdata) !!};

        new Chart(document.getElementById("ptttChart"), {
            type: "line", // 🔥 đổi từ bar -> line
            data: {
                labels: ptttLabels,
                datasets: [{
                    label: "Số lượng",
                    data: ptttData,
                    borderColor: "#0d6efd", // màu đường
                    backgroundColor: "rgba(13, 110, 253, 0.2)", // màu fill dưới đường
                    fill: true, // tô màu dưới đường
                    tension: 0.3, // bo tròn đường (0 = thẳng, 1 = cong nhiều)
                    pointBackgroundColor: "#0d6efd", // màu chấm
                    pointRadius: 5
                }],
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                    },
                },
            },
        });
    </script>


    <script>
        const movieLabels = {!! json_encode($movieRevenue->pluck('title')) !!};
        const movieData = {!! json_encode($movieRevenue->pluck('total_revenue')) !!};

        new Chart(document.getElementById("theoPhimChart"), {
            type: "bar",
            data: {
                labels: movieLabels,
                datasets: [{
                    label: "Doanh thu (VNĐ)", // hiện trong legend
                    data: movieData,
                    backgroundColor: "rgba(13, 110, 253, 0.3)",
                    borderColor: "#0d6efd",
                    borderWidth: 1,
                }],
            },
            options: {
                responsive: true,
                indexAxis: "x",
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('vi-VN').format(value);
                            }
                        },
                        title: {
                            display: true,
                            text: "Doanh thu (VNĐ)" // chữ dọc ở Y
                        }
                    },
                    x: {
                        ticks: {
                            // autoSkip: false,
                            // maxRotation: 90,
                            // minRotation: 90
                            display: false
                        },
                        title: {
                            // display: true,
                            // text: "Tên phim"
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true, // bật legend
                        position: 'top', // đưa chú thích lên trên đầu
                        labels: {
                            boxWidth: 20,
                            padding: 15
                        }
                    },
                    title: {
                        display: false // tắt tiêu đề chart để không bị trùng
                    }
                },
            },
        });
    </script>



    <script>
        const cinemaRevenue = @json($cinemaRevenue);
        const cinemaLabels = cinemaRevenue.map(item => item.cinema_name);
        const cinemaData = cinemaRevenue.map(item => item.total_revenue);

        new Chart(document.getElementById("theoRapChart"), {
            type: "bar",
            data: {
                labels: cinemaLabels,
                datasets: [{
                    label: "Doanh thu (₫)",
                    data: cinemaData,
                    backgroundColor: ["#0d6efd", "#198754", "#ffc107", "#dc3545", "#6f42c1"],
                }],
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        ticks: {
                            callback: function(value) {
                                return new Intl.NumberFormat('vi-VN').format(value) + " ₫";
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                },
            },
        });
    </script>
@endpush
