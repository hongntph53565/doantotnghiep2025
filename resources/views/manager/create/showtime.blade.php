@extends('layouts.manager')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0 fw-bold text-primary">
                            <i class="bi bi-calendar-plus me-2"></i>Thêm suất chiếu mới
                        </h5>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('showtimes.store') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <!-- Movie -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Tên phim <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" name="movie_id" id="movie_id" required>
                                        <option value="" disabled selected>--- Chọn phim ---</option>
                                        @foreach ($movies as $movie)
                                            <option value="{{ $movie->movie_id }}" data-duration="{{ $movie->duration }}">
                                                {{ $movie->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Phiên bản -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Định dạng</label>
                                    <input type="text" id="format" class="form-control bg-light" readonly>
                                </div>

                                <!-- Phòng -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Phòng chiếu <span
                                            class="text-danger">*</span></label>
                                    <select class="form-select" id="room" name="room_id" required>
                                        <option value="" disabled selected>--- Chọn phòng ---</option>
                                        @foreach ($rooms as $room)
                                            <option value="{{ $room->room_id }}" cinema-data="{{ $cinema_id }}"
                                                data-format="{{ $room->format }}">
                                                {{ $room->room_name }} ({{ $room->total_seats }} chỗ) ({{ $room->format }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Ngày -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Ngày chiếu <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="date" required>
                                </div>

                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="status" name="status"
                                            checked>
                                        <label class="form-check-label fw-semibold" for="status">kích hoạt</label>
                                    </div>
                                </div>

                                <!-- Auto checkbox -->
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="autoCreate" name="auto_create">
                                        <label class="form-check-label fw-semibold" for="autoCreate">Tự động tạo suất chiếu
                                            trong ngày</label>
                                    </div>
                                </div>

                                <!-- Giờ -->
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Giờ bắt đầu</label>
                                    <input type="time" class="form-control" name="start_time" id="start_time">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Giờ kết thúc</label>
                                    <input type="time" class="form-control bg-light" name="end_time" id="end_time"
                                        readonly>
                                    <small class="form-text text-muted">Tính theo thời lượng phim</small>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('showtimes.index') }}" class="btn btn-outline-secondary">
                                    <i class="bi bi-arrow-left me-2"></i>Quay lại
                                </a>
                                <button type="submit" class="btn btn-primary px-4">
                                    <i class="bi bi-check-circle me-2"></i>Lưu suất chiếu
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right sidebar -->
            <div class="col-lg-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h6 class="mb-0 fw-bold">Suất chiếu đang có</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="py-2">Thời gian</th>
                                        <th class="py-2">Phòng</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($showtimes as $value)
                                        <tr>
                                            <td>{{ $value->start_time }}</td>
                                            <td>{{ $value->room->room_name }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-3 d-flex justify-content-end">
                            {{ $showtimes->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Giữ nguyên phần JavaScript như trước
        const districtSelect = document.getElementById('district');
        const cinemaSelect = document.getElementById('rapChieu');
        const roomSelect = document.getElementById('room');
        const formatInput = document.getElementById('format');
        const movieSelect = document.getElementById('movie_id');
        const startTimeInput = document.getElementById('start_time');
        const endTimeInput = document.getElementById('end_time');

        // Ẩn tất cả các rạp và phòng ban đầu (trừ option đầu tiên)
        Array.from(cinemaSelect.options).forEach((option, index) => {
            if (index !== 0) {
                option.hidden = true;
                option.disabled = true;
            }
        });

        Array.from(roomSelect.options).forEach((option, index) => {
            if (index !== 0) {
                option.hidden = true;
                option.disabled = true;
            }
        });

        // Lọc rạp theo khu vực
        districtSelect.addEventListener('change', function() {
            const selectedDistrict = this.value;

            Array.from(cinemaSelect.options).forEach(option => {
                const city = option.getAttribute('district-data');

                if (!city) {
                    option.hidden = false;
                    option.disabled = false;
                    return;
                }

                option.hidden = city !== selectedDistrict;
                option.disabled = city !== selectedDistrict;
            });

            cinemaSelect.selectedIndex = 0;
            roomSelect.selectedIndex = 0;
            Array.from(roomSelect.options).forEach((option, index) => {
                if (index !== 0) option.hidden = option.disabled = true;
            });
            formatInput.value = '';
        });

        // Lọc phòng theo rạp
        cinemaSelect.addEventListener('change', function() {
            const selectedCinemaId = this.value;

            Array.from(roomSelect.options).forEach(option => {
                const cinemaId = option.getAttribute('cinema-data');

                if (!cinemaId) {
                    option.hidden = false;
                    option.disabled = false;
                    return;
                }

                option.hidden = cinemaId !== selectedCinemaId;
                option.disabled = cinemaId !== selectedCinemaId;
            });

            roomSelect.selectedIndex = 0;
            formatInput.value = '';
        });

        // Cập nhật format khi chọn phòng
        roomSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const format = selectedOption.getAttribute('data-format');

            formatInput.value = format || '';
        });

        // Tính giờ kết thúc tự động
        function calculateEndTime() {
            const selectedMovie = movieSelect.options[movieSelect.selectedIndex];
            if (!selectedMovie || selectedMovie.value === "") {
                endTimeInput.value = '';
                return;
            }

            const durationMinutes = parseInt(selectedMovie.getAttribute('data-duration')) || 0;
            const startTime = startTimeInput.value;

            if (!durationMinutes || !startTime) {
                endTimeInput.value = '';
                return;
            }

            try {
                const durHours = Math.floor(durationMinutes / 60);
                const durMins = durationMinutes % 60;

                const [startHours, startMins] = startTime.split(':').map(Number);

                let endHours = startHours + durHours;
                let endMins = startMins + durMins;

                if (endMins >= 60) {
                    endHours += Math.floor(endMins / 60);
                    endMins = endMins % 60;
                }

                endHours = endHours % 24;

                endTimeInput.value = `${String(endHours).padStart(2, '0')}:${String(endMins).padStart(2, '0')}`;
            } catch (e) {
                console.error("Error calculating end time:", e);
                endTimeInput.value = '';
            }
        }

        movieSelect.addEventListener('change', calculateEndTime);
        startTimeInput.addEventListener('input', calculateEndTime);
    </script>
@endpush
