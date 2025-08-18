@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light py-3">
                    <h5 class="mb-0 fw-bold text-primary">
                        <i class="bi bi-pencil-square me-2"></i>Chỉnh sửa suất chiếu
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('showtimes.update', $showtime->showtime_id) }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <!-- Movie -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tên phim <span class="text-danger">*</span></label>
                                <select class="form-select" name="movie_id" id="movie_id" required>
                                    <option value="" disabled>--- Chọn phim ---</option>
                                    @foreach ($movies as $movie)
                                        <option value="{{ $movie->movie_id }}" data-duration="{{ $movie->duration }}"
                                            {{ $showtime->movie_id == $movie->movie_id ? 'selected' : '' }}>
                                            {{ $movie->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Phiên bản -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Định dạng</label>
                                <input type="text" id="format" class="form-control bg-light"
                                    value="{{ $showtime->room?->format ?? '' }}" readonly>
                            </div>

                            <!-- Khu vực -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Khu vực <span class="text-danger">*</span></label>
                                <select class="form-select" id="district" required>
                                    <option value="" disabled>--- Chọn khu vực ---</option>
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->city }}"
                                            {{ $showtime->room?->cinema?->city == $district->city ? 'selected' : '' }}>
                                            {{ $district->city }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Cinema -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Rạp chiếu <span class="text-danger">*</span></label>
                                <select class="form-select" id="rapChieu" required>
                                    <option value="" disabled>--- Chọn rạp ---</option>
                                    @foreach ($cinemas as $cinema)
                                        <option value="{{ $cinema->cinema_id }}" district-data="{{ $cinema->city }}"
                                            {{ $showtime->room?->cinema_id == $cinema->cinema_id ? 'selected' : '' }}>
                                            {{ $cinema->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Phòng -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Phòng chiếu <span class="text-danger">*</span></label>
                                <select class="form-select" id="room" name="room_id" required>
                                    <option value="" disabled>--- Chọn phòng ---</option>
                                    @foreach ($rooms as $room)
                                        <option value="{{ $room->room_id }}" cinema-data="{{ $room->cinema_id }}"
                                            data-format="{{ $room->format }}"
                                            {{ $showtime->room_id == $room->room_id ? 'selected' : '' }}>
                                            {{ $room->room_name }} ({{ $room->total_seats }} chỗ)
                                            ({{ $room->format }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Ngày -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Ngày chiếu <span class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="date"
                                    value="{{ \Carbon\Carbon::parse($showtime->start_time ?? now())->format('Y-m-d') }}"
                                    required>
                            </div>

                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="status" name="status"
                                        {{ $showtime->status == 'active' ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold" for="status">Kích hoạt</label>
                                </div>
                            </div>

                            <!-- Giờ -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Giờ bắt đầu</label>
                                <input type="time" class="form-control" name="start_time" id="start_time"
                                    value="{{ $showtime->start_time ? \Carbon\Carbon::parse($showtime->start_time)->format('H:i') : '' }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Giờ kết thúc</label>
                                <input type="time" class="form-control bg-light" name="end_time" id="end_time"
                                    value="{{ $showtime->end_time ? \Carbon\Carbon::parse($showtime->end_time)->format('H:i') : '' }}" readonly>
                                <small class="form-text text-muted">Tính theo thời lượng phim</small>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('showtimes.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Quay lại
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-check-circle me-2"></i>Cập nhật
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
                    <h6 class="mb-0 fw-bold">Thông tin suất chiếu</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="fw-bold">Phim:</h6>
                        <p>{{ $showtime->movie?->title ?? 'Chưa có phim' }}</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="fw-bold">Rạp:</h6>
                        <p>{{ $showtime->room?->cinema?->name ?? 'Chưa có rạp' }}</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="fw-bold">Phòng:</h6>
                        <p>{{ $showtime->room?->room_name ?? 'Chưa có phòng' }}</p>
                    </div>
                    <div class="mb-3">
                        <h6 class="fw-bold">Thời gian:</h6>
                        <p>
                            {{ $showtime->start_time ? \Carbon\Carbon::parse($showtime->start_time)->format('H:i') : '--:--' }}
                            -
                            {{ $showtime->end_time ? \Carbon\Carbon::parse($showtime->end_time)->format('H:i') : '--:--' }}
                        </p>
                    </div>
                    <div class="mb-3">
                        <h6 class="fw-bold">Trạng thái:</h6>
                        <span class="badge {{ $showtime->status ? 'bg-success' : 'bg-secondary' }}">
                            {{ $showtime->status == "active" ? 'Kích hoạt' : 'Tắt' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
