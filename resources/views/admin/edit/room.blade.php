@extends('layouts.admin')

@section('content')
<div class="card border-0 shadow-sm rounded-3 mt-3">
    <div class="card-header bg-light py-3">
        <h5 class="mb-0 fw-bold text-primary">
            <i class="bi bi-building me-2"></i>Cập nhật phòng chiếu
        </h5>
    </div>

    <div class="card-body p-4">
        <form action="{{ route('rooms.update', $room->room_id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <!-- Tên phòng -->
                <div class="col-md-6">
                    <label for="tenChiNhanh" class="form-label fw-semibold">Tên phòng <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="tenChiNhanh" name="room_name"
                           value="{{ $room->room_name }}" required>
                </div>

                <!-- Khu vực -->
                <div class="col-md-6">
                    <label for="district" class="form-label fw-semibold">Khu vực <span class="text-danger">*</span></label>
                    <select class="form-select" id="district" name="" required>
                        <option value="" selected disabled>--- Chọn khu vực ---</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->city }}"
                                {{ $district->city === $room->cinema->city ? 'selected' : '' }}>
                                {{ $district->city }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Rạp chiếu -->
                <div class="col-md-6">
                    <label for="rapChieu" class="form-label fw-semibold">Rạp chiếu <span class="text-danger">*</span></label>
                    <select class="form-select" id="rapChieu" name="cinema_id" required>
                        <option value="" disabled>--- Chọn rạp ---</option>
                        @foreach ($cinemas as $cinema)
                            <option value="{{ $cinema->cinema_id }}"
                                    district-data="{{ $cinema->city }}"
                                    {{ $cinema->cinema_id == $room->cinema_id ? 'selected' : '' }}>
                                {{ $cinema->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Loại phòng -->
                <div class="col-md-6">
                    <label for="loaiPhong" class="form-label fw-semibold">Loại phòng <span class="text-danger">*</span></label>
                    <select class="form-select" id="loaiPhong" name="format" required>
                        <option value="" disabled>--- Chọn loại phòng ---</option>
                        <option value="2D" {{ $room->format === '2D' ? 'selected' : '' }}>2D Tiêu chuẩn</option>
                        <option value="3D" {{ $room->format === '3D' ? 'selected' : '' }}>3D</option>
                        <option value="IMAX" {{ $room->format === 'IMAX' ? 'selected' : '' }}>IMAX</option>
                        <option value="VIP" {{ $room->format === 'VIP' ? 'selected' : '' }}>VIP</option>
                    </select>
                </div>

                <!-- Sơ đồ ghế -->
                <div class="col-md-6">
                    <label for="soDoGhe" class="form-label fw-semibold">Sơ đồ ghế <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <select class="form-select" id="soDoGhe" name="seat_template" required onchange="updateSeatCount()">
                            <option value="" disabled>--- Chọn sơ đồ ---</option>
                            <option value="a" data-count="120" {{ $room->seat_template === 'a' ? 'selected' : '' }}>Sơ đồ A (120 ghế)</option>
                            <option value="b" data-count="80" {{ $room->seat_template === 'b' ? 'selected' : '' }}>Sơ đồ B (80 ghế)</option>
                            <option value="vip" data-count="50" {{ $room->seat_template === 'vip' ? 'selected' : '' }}>Sơ đồ VIP (50 ghế)</option>
                        </select>
                        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#seatMapModal">
                            <i class="bi bi-diagram-3"></i>
                        </button>
                    </div>
                </div>

                <!-- Số ghế -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Số lượng ghế</label>
                    <input type="text" class="form-control" id="seatCount" name="total_seats" value="{{ $room->total_seats }}" readonly>
                </div>

                <!-- Trạng thái -->
                <div class="col-12">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="active" id="activeStatus" {{ $room->active ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="activeStatus">Kích hoạt phòng chiếu</label>
                    </div>
                </div>
            </div>

            <!-- Hành động -->
            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary px-4">
                    <i class="bi bi-arrow-left me-2"></i>Quay lại
                </a>
                <div class="d-flex gap-2">
                    <button type="reset" class="btn btn-outline-danger px-4">
                        <i class="bi bi-x-circle me-2"></i>Đặt lại
                    </button>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-check-circle me-2"></i>Cập nhật
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal sơ đồ -->
<div class="modal fade" id="seatMapModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xem trước sơ đồ ghế</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body">
                <div class="text-center py-4">
                    <img src="https://via.placeholder.com/600x300?text=Sơ+đồ+ghế" alt="Sơ đồ ghế" class="img-fluid rounded">
                    <p class="mt-3 text-muted">Sơ đồ sẽ được hiển thị dựa trên lựa chọn</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function updateSeatCount() {
        const select = document.getElementById('soDoGhe');
        const selected = select.options[select.selectedIndex];
        const count = selected.getAttribute('data-count');
        document.getElementById('seatCount').value = count;
    }

    const districtSelect = document.getElementById('district');
    const cinemaSelect = document.getElementById('rapChieu');

    // Ẩn hết rạp ban đầu
    Array.from(cinemaSelect.options).forEach((option, index) => {
        if (index !== 0) {
            option.hidden = true;
            option.disabled = true;
        }
    });

    districtSelect.addEventListener('change', function () {
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
@endsection