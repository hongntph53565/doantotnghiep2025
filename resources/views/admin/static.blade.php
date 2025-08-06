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

@section('title ')
    Thống Kê
@endsection
@section('content')
    <!-- Bộ lọc thời gian -->
    <form class="row g-3 align-items-end mb-4">
        <div class="col-md-3">
            <label class="form-label">Ngày bắt đầu</label>
            <input type="date" name="Sdate" class="form-control" value="{{ $startDate }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Ngày kết thúc</label>
            <input type="date" name="Edate" class="form-control" value="{{ $endDate }}">
        </div>
        <div class="col-md-3">
            <label class="form-label">Khu vực</label>
            <select class="form-select" id="district">
                <option selected>--- Tất cả ---</option>
                @foreach ($districts as $value)
                    <option value="{{ $value }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">Rạp chiếu</label>
            <select class="form-select" name="cinema" id="cinemas">
                <option selected>--- Tất cả ---</option>
                @foreach ($cinemas as $value)
                    <option value="{{ $value->name }}">{{ $value->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="">
            <button type="submit" class="btn btn-primary w-100">Lọc</button>
        </div>
    </form>

    <!-- Tổng quan -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    <h6>Tổng doanh thu tháng</h6>
                    <h4 class="text-primary">{{ number_format($totalRevenue / 1_000_000, 2, '.', ',') }}tr
                        <small>(₫)</small>
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
                        <small>{{ number_format($highestCinemaRevenue->total_revenue / 1000000, 2, ',', '.') }}tr</small>
                    @else
                        <h6>Rạp có doanh thu cao nhất</h6>
                        <h5>ko có doanh thu</h5>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm text-center">
                <div class="card-body">
                    @if ($topMovie)
                        <h6>Phim doanh thu cao nhất</h6>
                        <h5>{{ $topMovie->title }}</h5>
                        <small>{{ number_format($topMovie->total_revenue / 1000000, 2, ',', '.') }}tr</small>
                    @else
                        <h6>Phim doanh thu cao nhất</h6>
                        <h5>không có doanh thu</h5>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-3">
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

    <!-- Biểu đồ -->
    <div class="row g-4">
        <!-- Biểu đồ doanh thu theo rạp -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header fw-bold">Doanh thu theo rạp</div>
                <div class="card-body d-flex justify-content-center">
                    <div style="max-width: 250px;">
                        <canvas id="theoRapChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Doanh thu theo phim</h6>
                    <canvas id="theoPhimChart"></canvas>
                </div>
            </div>
        </div>
        <!-- Biểu đồ phương thức thanh toán -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header fw-bold">Phương thức thanh toán</div>
                <div class="card-body d-flex justify-content-center">
                    <div style="max-width: 250px;">
                        <canvas id="ptttChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="card-title">Xu hướng doanh thu theo tháng</h6>
                    <canvas id="xuHuongChart"></canvas>
                </div>
            </div>
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
                    borderColor: "#0d6efd",
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

        const hasData = ptttData.length > 0 && ptttData.some(val => val > 0);

        const chartLabels = hasData ? ptttLabels : ['Không có dữ liệu'];
        const chartData = hasData ? ptttData : [1]; // 1 phần tử giả để có hình bánh
        const chartColors = hasData ? ["#0d6efd", "#20c997", "#ffc107", "#dc3545"] : ['#e0e0e0'];

        new Chart(document.getElementById("ptttChart"), {
            type: "pie",
            data: {
                labels: chartLabels,
                datasets: [{
                    data: chartData,
                    backgroundColor: chartColors,
                }],
            },
            options: {
                plugins: {
                    legend: {
                        position: "right",
                    },
                    tooltip: {
                        enabled: hasData,
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
                    label: "Doanh thu (₫)",
                    data: movieData,
                    backgroundColor: "#0d6efd",
                }, ],
            },
            options: {
                responsive: true,
                indexAxis: "y",
                scales: {
                    x: {
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

    <script>
        const cinemaRevenue = @json($cinemaRevenue);

        let hasDataCinema = cinemaRevenue.length > 0 && cinemaRevenue.some(item => item.total_revenue > 0);
        const labelsCinema = hasDataCinema ? cinemaRevenue.map(item => item.cinema_name) : ['Không có dữ liệu'];
        const dataCinema = hasDataCinema ? cinemaRevenue.map(item => item.total_revenue) : [1];
        const colorsCinema = hasDataCinema ?
            ["#0d6efd", "#198754", "#ffc107", "#dc3545", "#6f42c1"] :
            ['#e0e0e0'];

        new Chart(document.getElementById("theoRapChart"), {
            type: "pie",
            data: {
                labels: labelsCinema,
                datasets: [{
                    data: dataCinema,
                    backgroundColor: colorsCinema,
                }],
            },
            options: {
                plugins: {
                    legend: {
                        position: "right"
                    },
                    tooltip: {
                        enabled: hasDataCinema
                    },
                },
            },
        });
    </script>


    <script>
        const districtSelect = document.getElementById('district');
        const cinemaSelect = document.getElementById('cinemas');

        Array.from(cinemaSelect.options).forEach((option, index) => {
            if (index !== 0) {
                option.hidden = true;
                option.disabled = true;
            }
        });
        districtSelect.addEventListener('change', function() {
            const selectedDistrict = this.value;

            Array.from(cinemaSelect.options).forEach(option => {
                const city = option.getAttribute('district-data');

                if (!city) {
                    option.hidden = false;
                    option.disabled = false;
                    return;
                }

                if (city === selectedDistrict) {
                    option.hidden = false;
                    option.disabled = false;
                } else {
                    option.hidden = true;
                    option.disabled = true;
                }
            });
            cinemaSelect.selectedIndex = 0;
        });
    </script>
@endpush