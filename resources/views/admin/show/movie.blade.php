@extends('layouts.admin')

@section('content')
    <div class="d-flex align-items-center mb-3">
        <h4 class="mb-0">Thông tin chi tiết phim</h4>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Thông tin cơ bản</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 text-center">
                    <img src="{{ asset('storage/' . $movie->poster) ?? asset('/img/default-movie-poster.jpg') }}"
                        class="img-fluid rounded mb-3" alt="Poster phim">
                    <div class="d-grid gap-2">
                        <button class="btn btn-warning"
                            onclick="window.location.href='{{ route('movies.edit', ['id' => $movie->movie_id]) }}'">Chỉnh
                            sửa</button>
                        <button class="btn btn-danger">Xóa phim</button>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Tên phim:</strong> {{ $movie->title }}</p>
                            <p><strong>Thể loại:</strong>
                                <span class="badge bg-secondary">{{ $movie->genre->genre_name }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Đạo diễn:</strong> {{ $movie->director }}</p>
                            <p><strong>Diễn viên:</strong> {{ $movie->cast }}</p>
                            <p><strong>Thời lượng:</strong> {{ $movie->duration }} phút</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <p><strong>Ngày khởi chiếu:</strong> {{ date('d/m/Y', strtotime($movie->release_date)) }}</p>
                            <p><strong>Ngày kết thúc:</strong> {{ date('d/m/Y', strtotime($movie->end_date)) }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Ngôn ngữ:</strong> {{ $movie->language }}</p>
                            <p><strong>Định dạng:</strong> {{ $movie->format }}</p>
                            <p><strong>Độ tuổi:</strong> <span
                                    class="badge bg-{{ $movie->age_rating == 'T18' ? 'danger' : 'warning' }}">{{ $movie->age_rating }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="mb-3">
                        <h6>Mô tả phim:</h6>
                        <p>{{ $movie->description }}</p>
                    </div>

                    <div class="mb-3">
                        <h6>Trailer:</h6>
                        <div class="ratio ratio-16x9">
                            <iframe src="{{ str_replace('watch?v=', 'embed/', $movie->trailer) }}"
                                allowfullscreen></iframe>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Lịch chiếu</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Rạp</th>
                            <th>Phòng</th>
                            <th>Ngày chiếu</th>
                            <th>Giờ bắt đầu</th>
                            <th>Giờ kết thúc</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($showtimes as $showtime)
                            <tr>
                                <td>{{ $showtime->room->cinema->name }}</td>
                                <td>{{ $showtime->room->room_name }}</td>
                                <td>{{ \Carbon\Carbon::parse($showtime->start_time)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($showtime->end_time)->format('H:i') }}</td>
                                <td>
                                    <span class="badge bg-{{ $showtime->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ $showtime->status == 'active' ? 'Đang chiếu' : 'Đã hủy' }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    {{ $showtimes->links() }}
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Thống kê doanh thu</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Tổng doanh thu</h5>
                            <p class="card-text h4">{{ number_format($totalRevenue) }} ₫</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-info mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Tổng vé bán</h5>
                            <p class="card-text h4">{{ $totalTickets }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Tỉ lệ lấp đầy</h5>
                            <p class="card-text h4">{{ $occupancyRate }}%</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="chart-container" style="position: relative; height:300px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Biểu đồ doanh thu
        const ctx = document.getElementById('revenueChart').getContext('2d');
        const revenueChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($revenueChart['labels']) !!},
                datasets: [{
                    label: 'Doanh thu',
                    data: {!! json_encode($revenueChart['data']) !!},
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    borderColor: 'rgba(54, 162, 235, 1)',
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
                            callback: function(value) {
                                return value.toLocaleString() + ' ₫';
                            }
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y.toLocaleString() + ' ₫';
                            }
                        }
                    }
                }
            }
        });
    </script>
@endsection
@endsection
