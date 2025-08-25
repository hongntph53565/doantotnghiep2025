@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4 ms-2">
        <div>
            <h4>Thống kế trên toàn hệ thống</strong></h4>
            <p class="text-muted">Thống kê tổng quan trên toàn hệ thống Lumistar</p>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted">Doanh thu</h6>
                        <p class="fs-3 fw-bold">{{ number_format($currentMonthRevenue, 0, ',', '.') }} ₫</p>
                    </div>
                    <div class="overview br1">
                        <img src="{{ asset('admin/pictures/money.svg') }}" alt="money">
                    </div>
                </div>

                <div class="br {{ $revenueChange < 0 ? 'text-danger' : 'text-success' }}">
                    <i class="fas {{ $revenueChange < 0 ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                    {{ number_format(abs($revenueChange), 2) }}%
                </div>
                <p class="text-muted">so với tháng trước</p>
            </div>
        </div>



        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted">Số vé tháng này</h6>
                        <p class="fs-3 fw-bold">{{ number_format($currentMonthTickets) }} vé</p>
                    </div>
                    <div class="overview br2">
                        <img src="{{ asset('admin/pictures/ticket.svg') }}" alt="ticket">
                    </div>
                </div>

                <div class="br {{ $ticketChange < 0 ? 'text-danger' : 'text-success' }}">
                    <i class="fas {{ $ticketChange < 0 ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                    {{ number_format(abs($ticketChange), 2) }}%
                </div>
                <p class="text-muted">so với tháng trước</p>
            </div>
        </div>



        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted">Khách hàng mới</h6>
                        <p class="fs-3 fw-bold">{{ number_format($currentMonthCustomers) }}</p>
                    </div>
                    <div class="overview br3">
                        <img src="{{ asset('admin/pictures/person.svg') }}" alt="person">
                    </div>
                </div>

                <div class="br {{ $customerChange < 0 ? 'text-danger' : 'text-success' }}">
                    <i class="fas {{ $customerChange < 0 ? 'fa-arrow-down' : 'fa-arrow-up' }}"></i>
                    {{ number_format(abs($customerChange), 2) }}%
</div>
                <p class="text-muted">so với tháng trước</p>
            </div>
        </div>

        <div class="col-md-3">
            <div class="stat-card">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-muted">Suất chiếu tháng này</h6>
                        <p class="fs-4 fw-bold">{{ $currentMonthShowtimes }} suất</p>
                    </div>
                    <div class="overview br4">
                        <img src="{{ asset('admin/pictures/tv.svg') }}" alt="showtime">
                    </div>
                </div>
                <div class="br {{ $showtimeChange >= 0 ? 'text-success' : 'text-danger' }}">
                    <i class="fas {{ $showtimeChange >= 0 ? 'fa-arrow-up' : 'fa-arrow-down' }}"></i>
                    {{ number_format(abs($showtimeChange), 2) }}%
                </div>
                <p class="text-muted">so với tháng trước</p>
            </div>
        </div>

    </div>
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Doanh thu</h5>
                        <select id="yearSelect" class="form-select w-auto">
                            @for ($i = now()->year; $i >= 2020; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>

                    <div class="text-center my-2 bg-light p-3">
                        <h6 class="text-muted">Tổng doanh thu</h6>
                        <h5 class="fw-bold text-primary" id="totalRevenue"></h5>
                    </div>

                    <br>
                    <div class="chart-container">
                        <canvas id="revenueChart"></canvas>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">Tỷ lệ đặt ghế</h5>
                    <div class="chart-container">
                        <canvas id="seatTypeChart" height="250"></canvas>
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
                        <div class="movie-card bg-light text-dark">
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
                        <div class="movie-card bg-light text-dark">
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
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

    <style>
        .overview {
            border-radius: 8px;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .br {
            background-color: #F3F6F9;
            width: 80px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 3px;
        }

        .br1 {
            background-color: #DAF4F0;
        }

        .br2 {
            background-color: #DFF0FA;
        }


        .br3 {
            background-color: #FEF4E4;
        }

        .br4 {
            background-color: #E2E5ED;
        }

        .overview img {
            width: 28px;
            height: 28px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        const colorPalette = ['#018bf3', '#f7ba00', '#00db91']; // xanh, xanh lá, vàng

        fetch("{{ route('seatType.stats') }}")
            .then(res => res.json())
            .then(data => {
                // Tạo map từ loại ghế -> số lượng
                const seatMap = {
                    'standard': 0,
                    'vip': 0,
                    'double': 0,
                    'couple': 0,
                };

                data.forEach(s => {
                    if (s.seat_type === 'standard') seatMap['standard'] = s.total;
                    if (s.seat_type === 'vip') seatMap['vip'] = s.total;
                    if (s.seat_type === 'double' || s.seat_type === 'couple') seatMap['double'] = s.total;
                });

                // Đặt lại đúng thứ tự bạn muốn
                const labels = ['Ghế Thường', 'Ghế VIP', 'Ghế Đôi'];
                const counts = [
                    seatMap['standard'],
                    seatMap['vip'],
                    seatMap['double']
                ];

                const total = counts.reduce((a, b) => a + b, 0);

                const ctx = document.getElementById('seatTypeChart').getContext('2d');
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: labels,
                        datasets: [{
                            data: counts,
backgroundColor: colorPalette,
                            hoverBorderColor: "rgba(234, 236, 244, 1)",
                        }],
                    },
                    options: {
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    padding: 20
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        const value = context.raw;
                                        const percent = ((value / total) * 100).toFixed(1);
                                        return context.label + ": " + value + " (" + percent + "%)";
                                    }
                                }
                            },
                            datalabels: {
                                color: '#fff',
                                formatter: (value, ctx) => {
                                    let percentage = (value / total * 100).toFixed(1) + "%";
                                    return percentage;
                                },
                            }
                        },
                        cutout: '70%',
                    },
                    plugins: [ChartDataLabels],
                });
            });
    </script>



    <script>
        let revenueChart;

        function loadRevenue(year) {
            fetch("{{ route('revenue.data') }}?year=" + year)
                .then(res => res.json())
                .then(res => {
                    const data = res.monthly;
                    const labels = data.map(r => "Tháng " + r.month);
                    const revenues = data.map(r => r.total);

                    // tổng doanh thu từ DB
                    document.getElementById("totalRevenue").innerText =
                        Number(res.total).toLocaleString("vi-VN") + " VND";


                    if (revenueChart) {
                        revenueChart.data.labels = labels;
                        revenueChart.data.datasets[0].data = revenues;
                        revenueChart.update();
                    } else {
                        const ctx = document.getElementById("revenueChart").getContext("2d");
                        revenueChart = new Chart(ctx, {
                            type: "bar",
                            data: {
                                labels: labels,
                                datasets: [{
                                    label: "Doanh thu (VND)",
                                    data: revenues,
                                    backgroundColor: "rgba(78, 115, 223, 0.7)",
borderRadius: 6
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
                                                return value.toLocaleString("vi-VN") + " VND";
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    }
                });
        }


        // load mặc định năm hiện tại
        loadRevenue(new Date().getFullYear());

        // đổi năm thì gọi lại API
        document.getElementById("yearSelect").addEventListener("change", function() {
            loadRevenue(this.value);
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