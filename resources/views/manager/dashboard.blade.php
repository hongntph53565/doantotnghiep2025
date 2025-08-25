@extends('layouts.manager')

@section('content')
    <div class="container-fluid py-4">
        <!-- Header Section -->
        <section class="mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h4 fw-bold">Thống Kê Rạp {{ $cinemaName }}</h1>
                <div class="text-muted small">Cập nhật: {{ now()->format('d/m/Y') }}</div>
            </div>
        </section>

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
                <label class="form-label">Phim</label>
                <select class="form-select" name="movie_id">
                    <option value="">--- Tất cả ---</option>
                    @foreach ($movies as $movie)
                        <option value="{{ $movie->movie_id }}"
                            {{ request('movie_id') == $movie->movie_id ? 'selected' : '' }}>
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
            <div class="col-md-4">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <h6>Tổng doanh thu tháng</h6>
                        <h4 class="text-primary">
                            {{ number_format($totalRevenue, 0, ',', '.') }} ₫
                        </h4>
                        <p class="card-text small text-muted">{{ $startDate->format('d/m/Y') }} -
                            {{ $endDate->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        @if ($topMovie)
                            <h6>Phim doanh thu cao nhất</h6>
                            <h5 class="fw-bold">{{ $topMovie->title }}</h5>
                            <small>{{ number_format($topMovie->total_revenue, 0, ',', '.') }} ₫</small>
                        @else
                            <h6>Phim doanh thu cao nhất</h6>
                            <h5>không có doanh thu</h5>
                        @endif
                    </div>
                </div>
            </div>
<div class="col-md-4">
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
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Doanh thu theo phim</h6>
                        <canvas id="theoPhimChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title">Phương thức thanh toán</h6>
                        <canvas id="ptttChart"></canvas>
                    </div>
                </div>
            </div>

        </div>

        <div style="height: 50px"></div>
    @endsection

    @push('scripts')
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
    @endpush