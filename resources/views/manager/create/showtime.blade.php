@extends('layouts.manager')

@section('content')
    <div class="container-fluid">
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h5 class="mb-0 fw-bold text-primary">
                            <i class="bi bi-calendar-plus me-2"></i>Thêm suất chiếu mới
                        </h5>
                    </div>

                    <div class="card-body">
    <form action="{{ route('manager.showtimes.store') }}" method="POST">
        @csrf
        <div class="row g-3">
            <!-- Movie -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Tên phim <span class="text-danger">*</span></label>
                <select class="form-select @error('movie_id') is-invalid @enderror" name="movie_id" id="movie_id" required>
                    <option value="" disabled {{ old('movie_id') ? '' : 'selected' }}>--- Chọn phim ---</option>
                    @foreach ($movies as $movie)
                        <option value="{{ $movie->movie_id }}" data-duration="{{ $movie->duration }}"
                            {{ old('movie_id') == $movie->movie_id ? 'selected' : '' }}>
                            {{ $movie->title }}
                        </option>
                    @endforeach
                </select>
                @error('movie_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Phiên bản -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Định dạng</label>
                <input type="text" id="format" class="form-control bg-light" readonly>
            </div>

            <!-- Phòng -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Phòng chiếu <span class="text-danger">*</span></label>
                <select class="form-select @error('room_id') is-invalid @enderror" id="room" name="room_id" required>
                    <option value="" disabled {{ old('room_id') ? '' : 'selected' }}>--- Chọn phòng ---</option>
                    @foreach ($rooms as $room)
                        <option value="{{ $room->room_id }}" cinema-data="{{ $room->cinema_id }}"
    data-format="{{ $room->format }}"
    {{ old('room_id') == $room->room_id ? 'selected' : '' }}
    @if (in_array($room->room_id, $usedRooms)) disabled @endif>
    {{ $room->room_name }} ({{ $room->total_seats }} chỗ) ({{ $room->format }})
    @if (in_array($room->room_id, $usedRooms)) - [Đã có suất chiếu] @endif
</option>
                    @endforeach
                </select>
                @error('room_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Ngày -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Ngày chiếu <span class="text-danger">*</span></label>
                <input type="date" class="form-control @error('date') is-invalid @enderror"
                    name="date" value="{{ old('date') }}" required>
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Status -->
            <div class="col-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="status" name="status"
                        {{ old('status', 'on') ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="status">kích hoạt</label>
                </div>
            </div>

            <!-- Auto checkbox -->
            <div class="col-12">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="autoCreate" name="auto_create"
                        {{ old('auto_create') ? 'checked' : '' }}>
                    <label class="form-check-label fw-semibold" for="autoCreate">Tự động tạo suất chiếu trong ngày</label>
                </div>
            </div>

            <!-- Giờ -->
            <div class="col-md-6">
                <label class="form-label fw-semibold">Giờ bắt đầu</label>
                <input type="time" class="form-control @error('start_time') is-invalid @enderror"
                    name="start_time" id="start_time" value="{{ old('start_time') }}">
                @error('start_time')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Giờ kết thúc</label>
                <input type="time" class="form-control bg-light"
                    name="end_time" id="end_time" value="{{ old('end_time') }}" readonly>
                <small class="form-text text-muted">Tính theo thời lượng phim</small>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('manager.showtimes.index') }}" class="btn btn-outline-secondary">
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
            {{-- <div class="col-lg-4">
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
                            {{ $showtimes->onEachSide(1)->links() }}
                        </div>

                    </div>
                </div>
            </div> --}}

            <div class="col-lg-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h6 class="mb-0 fw-bold">Suất chiếu đang có</h6>
                    </div>
                    <br>
                    <form action="{{ route('manager.showtimes.create') }}" method="GET" class="mb-3 ms-2">
                        <input type="date" name="date" value="{{ $filterDate }}"
                            class="form-control w-auto d-inline-block me-2">

                        <span class="form-control w-auto d-inline-block bg-light">
    {{ $cinemas->first()->name ?? 'N/A' }}
                        </span>
                        <br>
                        <select name="movie_id" class="form-control w-auto d-inline-block me-2 mt-3">
        <option value="">   Tất cả phim </option>
        @foreach ($movies as $movie)
            <option value="{{ $movie->movie_id }}"
                {{ isset($filterMovie) && $filterMovie == $movie->movie_id ? 'selected' : '' }}>
                {{ $movie->title }}
            </option>
        @endforeach
    </select>

                        <button type="submit" class="btn btn-primary">Lọc</button>
                    </form>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="py-2">Thời gian</th>
                                        <th class="py-2">Phòng</th>
                                        <th class="py-2">Rạp</th>
                                        <th class="py-2">Phim</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($showtimes as $value)
                                        <tr>
                                            <td>{{ \Carbon\Carbon::parse($value->start_time)->format('H:i') }}</td>
                                            <td>{{ $value->room->room_name }}</td>
                                            <td>{{ $value->room->cinema->name }}</td>
                                            <td>
                                                <img src="{{ asset('storage/' . $value->movie->poster) }}"
                                                    class="rounded me-3" alt="Poster" width="50" height="75">
                                                <div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3 d-flex justify-content-end">
                            {{ $showtimes->appends([
                                    'date' => $filterDate,
                                    'cinema_id' => $filterCinema ?? '',
                                    'movie_id' => $filterMovie ?? '',
                                ])->onEachSide(1)->links() }}
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
