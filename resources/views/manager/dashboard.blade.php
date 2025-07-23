@extends('layouts.admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Header Section -->
    <section class="mb-4">
        <div class="d-flex justify-content-between align-items-center">
            <h1 class="h4 fw-bold">Thống Kê Rạp Phim</h1>
            <div class="text-muted small">Cập nhật: {{ now()->format('d/m/Y') }}</div>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="mb-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Bộ Lọc</h5>
                <form class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Từ ngày</label>
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date', now()->startOfMonth()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Đến ngày</label>
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date', now()->format('Y-m-d')) }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Khu vực</label>
                        <select class="form-select" name="district">
                            <option value="">Tất cả</option>
                            @foreach($districts as $district)
                            <option value="{{ $district }}" {{ request('district') == $district ? 'selected' : '' }}>{{ $district }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Rạp chiếu</label>
                        <select class="form-select" name="cinema">
                            <option value="">Tất cả</option>
                            @foreach($cinemas as $cinema)
                            <option value="{{ $cinema->id }}" {{ request('cinema') == $cinema->id ? 'selected' : '' }}>{{ $cinema->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Áp dụng</button>
                        <a href="" class="btn btn-outline-secondary">Đặt lại</a>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Summary Stats Section -->
    <section class="mb-4">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6 class="card-subtitle mb-2 text-muted">Tổng doanh thu</h6>
                        <h3 class="card-title text-primary">{{ number_format($totalRevenue / 1000000, 2) }}tr ₫</h3>
                        <p class="card-text small text-muted">{{ $startDate->format('d/m/Y') }} - {{ $endDate->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6 class="card-subtitle mb-2 text-muted">Rạp hàng đầu</h6>
                        <h5 class="card-title">{{ $topCinema->name ?? 'N/A' }}</h5>
                        <p class="card-text small text-muted">{{ $topCinema ? number_format($topCinema->total_revenue / 1000000, 2).'tr ₫' : '' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6 class="card-subtitle mb-2 text-muted">Phim bán chạy</h6>
                        <h5 class="card-title">{{ $topMovie->title ?? 'N/A' }}</h5>
                        <p class="card-text small text-muted">{{ $topMovie ? number_format($topMovie->ticket_count).' vé' : '' }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card shadow-sm h-100">
                    <div class="card-body text-center">
                        <h6 class="card-subtitle mb-2 text-muted">PTTT phổ biến</h6>
                        <h5 class="card-title">{{ $topPaymentMethod->method ?? 'N/A' }}</h5>
                        <p class="card-text small text-muted">{{ $topPaymentMethod ? $topPaymentMethod->percentage.'%' : '' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Charts Section -->
    <section class="mb-4">
        <div class="row g-3">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Xu hướng doanh thu</h5>
                        <div style="height: 300px;">
                            <canvas id="revenueTrendChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title">Phân bổ doanh thu</h5>
                        <div style="height: 300px;">
                            <canvas id="revenueDistributionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Top Movies Section -->
    <section>
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="card-title mb-0">Top 10 phim</h5>
                    <a href="{{ route('admin.movies.index') }}" class="btn btn-sm btn-outline-primary">Xem tất cả</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên phim</th>
                                <th>Doanh thu</th>
                                <th>Số vé</th>
                                <th>Tỷ lệ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($topMovies as $index => $movie)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $movie->title }}</td>
                                <td>{{ number_format($movie->revenue) }} ₫</td>
                                <td>{{ number_format($movie->ticket_count) }}</td>
                                <td>{{ number_format(($movie->revenue / $totalRevenue) * 100, 1) }}%</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Revenue Trend Chart
    const trendCtx = document.getElementById('revenueTrendChart').getContext('2d');
    new Chart(trendCtx, {
        type: 'line',
        data: {
            labels: @json($trendLabels),
            datasets: [{
                label: 'Doanh thu (₫)',
                data: @json($trendData),
                borderColor: '#4e73df',
                backgroundColor: 'rgba(78, 115, 223, 0.05)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString() + ' ₫';
                        }
                    }
                }
            }
        }
    });

    // Revenue Distribution Chart
    const distCtx = document.getElementById('revenueDistributionChart').getContext('2d');
    new Chart(distCtx, {
        type: 'doughnut',
        data: {
            labels: @json($distributionLabels),
            datasets: [{
                data: @json($distributionData),
                backgroundColor: [
                    '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', 
                    '#e74a3b', '#858796', '#5a5c69', '#3a3b45'
                ]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right'
                }
            }
        }
    });
</script>
@endpush