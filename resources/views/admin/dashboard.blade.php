@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4>Xin chào, <strong>{{ session('my_name') ?? 'Guest' }}!</strong></h4>
            <p class="text-muted">Đây là bảng tổng quan các số liệu thống kê</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
    <h6 class="text-muted">Tổng doanh thu</h6>
    <p class="fs-4 fw-bold">{{ number_format($totalRevenue, 0, ',', '.') }} đ</p>
</div>
                    <div class="{{ $revenueChange < 0 ? 'text-danger' : 'text-success' }}">
                        <i class="fas {{ $revenueChange < 0 ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                        {{ number_format(abs($revenueChange), 2) }}%
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted">Hóa đơn</h6>
                        <p class="fs-4 fw-bold">{{ $currentMonthInvoices }}</p>
                    </div>
                    <div class="{{ $invoiceChange < 0 ? 'text-danger' : 'text-success' }}">
                        <i class="fas {{ $invoiceChange < 0 ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                        {{ number_format(abs($invoiceChange), 2) }}%
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-4">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted">Rạp hoạt động</h6>
                        <p class="fs-4 fw-bold">{{ $activeCinemas }}/{{ $totalCinemas }}</p>
                    </div>
                    <div class="text-success">
                        <i class="fas fa-check-circle"></i> {{ $activePercent }}%
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Doanh thu 7 ngày gần đây</h5>
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Phân bổ thể loại</h5>
                    <div class="chart-container">
                        <canvas id="genreChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Lịch chiếu theo giờ</h5>
            <div class="chart-container" style="height: 200px;">
                <canvas id="scheduleChart"></canvas>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="card-title mb-0">Danh sách phim</h5>
                <div>
                    <button class="btn btn-sm btn-outline-primary"
                        onclick="window.location.href='{{ route('movies.create') }}'"><i class="fas fa-plus"></i> Thêm
                        phim</button>
                </div>
            </div>
            <div class="genre-tabs">
                <button class="btn btn-primary genre-btn active" data-genre="all">
                    <i class="fas fa-list"></i> Tất cả
                </button>
                @foreach ($movie as $value)
                    <button class="btn btn-primary genre-btn active" data-genre="{{ $value->genre->genre_name }}">
                        <i class="fas fa"></i> {{ $value->genre->genre_name }}
                    </button>
                @endforeach
            </div>
            <div class="genre-content active" id="all">
                @foreach ($movie as $value)
                    <div class="col-md-3 col-sm-6">
                        <div class="movie-card bg-primary">
                            <span class="badge badge-genre">{{ $value->genre->genre_name }}</span>
                            <h6>{{ $value->title }}</h6>
                            <p class="small">{{ $value->duration }} phút | {{ $value->age_rating }}</p>
                            <div class="d-flex justify-content-between">
                                <span class="small">{{ $value->status == 'active' ? 'Đang chiếu' : 'Ngưng chiếu' }}
                                    @if (isset($averageRatings[$value->movie_id]))
                                        <small>({{ number_format($averageRatings[$value->movie_id], 1) }}/5★)</small>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @foreach ($moviesByGenre as $genreName => $movies)
                <div class="genre-content" id="{{ $genreName }}">
                    <div class="col-md-3 col-sm-6">
                        <div class="movie-card bg-primary">
                            <span class="badge badge-genre">{{ $genreName }}</span>
                            @foreach ($movies as $value)
                                <h6>{{ $value->title }}</h6>
                                <p class="small">{{ $value->duration }} phút | {{ $value->age_rating }}</p>
                                <div class="d-flex justify-content-between">
                                    <span class="small">{{ $value->status == 'active' ? 'Đang chiếu' : 'Ngưng chiếu' }}
                                        @if (isset($averageRatings[$value->movie_id]))
                                            <small>({{ number_format($averageRatings[$value->movie_id], 1) }}/5★)</small>
                                        @endif
                                        </small>
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <div style="height: 50px"></div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('admin/css/dashboard.css') }}">
@endpush

@push('scripts')
    <script>
        const colorPalette = [
            '#4e73df', '#1cc88a', '#e74a3b', '#f6c23e', '#36b9cc',
            '#8e44ad', '#ff9f40', '#2ecc71', '#3498db', '#fd7e14'
        ];

        function getRandomColor() {
            const letters = '0123456789ABCDEF';
            let color = '#';
            for (let i = 0; i < 6; i++) {
                color += letters[Math.floor(Math.random() * 16)];
            }
            return color;
        }

        function generateColors(numColors) {
            const colors = [...colorPalette];
            while (colors.length < numColors) {
                colors.push(getRandomColor());
            }
            return colors.slice(0, numColors);
        }

        const genres = @json($genresstart);

        const labels = genres.map(g => g.genre_name);
        const data = genres.map(g => g.movie_count);
        const backgroundColors = generateColors(labels.length);
        const hoverBackgroundColors = backgroundColors;

        const genreCtx = document.getElementById('genreChart').getContext('2d');
        const genreChart = new Chart(genreCtx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: backgroundColors,
                    hoverBackgroundColor: hoverBackgroundColors,
                    hoverBorderColor: "rgba(234, 236, 244, 1)",
                }],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right'
                    }
                },
                cutout: '70%',
            }
        });
    </script>

    <script>
        const revenues = @json($revenues);

        const date = revenues.map(r => r.date);
        const revenuedata = revenues.map(r => r.total);


        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: date,
                datasets: [{
                    label: 'Doanh thu (VND)',
                    data: revenuedata,
                    fill: true,
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.05)',
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return (value / 1000000).toFixed(1) + 'tr';
                            }
                        }
                    }
                }
            }
        });
    </script>

    <script>
        const showtimes = @json($showtime);

        const hour = showtimes.map(r => r.hour);
        const showtimesdata = showtimes.map(r => r.total);

        const scheduleCtx = document.getElementById('scheduleChart').getContext('2d');
        const scheduleChart = new Chart(scheduleCtx, {
            type: 'bar',
            data: {
                labels: hour,
                datasets: [{
                    label: 'Số suất chiếu',
                    data: showtimesdata,
                    backgroundColor: 'rgba(78, 115, 223, 0.8)',
                    borderColor: 'rgba(78, 115, 223, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>

    <script>
        // Xử lý tab thể loại phim
        document.querySelectorAll('.genre-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                // Xóa active tất cả các nút
                document.querySelectorAll('.genre-btn').forEach(b => {
                    b.classList.remove('active');
                    b.classList.remove('btn-primary');
                    b.classList.add('btn-outline-primary');
                });

                // Thêm active cho nút được click
                this.classList.add('active');
                this.classList.add('btn-primary');
                this.classList.remove('btn-outline-primary');

                // Ẩn tất cả nội dung
                document.querySelectorAll('.genre-content').forEach(content => {
                    content.classList.remove('active');
                });

                // Hiển thị nội dung tương ứng
                const genre = this.getAttribute('data-genre');
                document.getElementById(genre).classList.add('active');
            });
        });
    </script>
@endpush