@extends('layouts.manager')

@section('content')
    <div class="card border-0 shadow-sm rounded-3 mt-3">
        <div class="card-header bg-light py-3">
            <h5 class="mb-0 fw-bold text-primary">
                <i class="bi bi-building me-2"></i>Thêm phòng chiếu
            </h5>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('rooms.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <input type="hidden" name="cinema_id" value="{{ $cinema_id }}">
                    <div class="col-md-6">
                        <label for="tenChiNhanh" class="form-label fw-semibold">Tên phòng <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="tenChiNhanh" name="room_name"
                            placeholder="VD: phòng A1" required>
                    </div>

                    <!-- Room type -->
                    <div class="col-md-6">
                        <label for="loaiPhong" class="form-label fw-semibold">Loại phòng <span
                                class="text-danger">*</span></label>
                        <select class="form-select" id="loaiPhong" name="format" required>
                            <option value="" selected disabled>--- Chọn loại phòng ---</option>
                            <option value="2D">2D Tiêu chuẩn</option>
                            <option value="3D">3D</option>
                            <option value="IMAX">IMAX</option>
                            <option value="VIP">VIP</option>
                        </select>
                    </div>

                    <!-- Seat Template -->
                    <div class="col-md-6">
                        <label for="soDoGhe" class="form-label fw-semibold">Sơ đồ ghế <span
                                class="text-danger"></span></label>
                        <div class="input-group">
                            <select class="form-select" id="soDoGhe" name="seat_template"
                                onchange="updateSeatCount()">
                                <option value="" selected disabled>--- Chọn sơ đồ ---</option>
                                <option value="a" data-count="120">Sơ đồ A (120 ghế)</option>
                                <option value="b" data-count="80">Sơ đồ B (80 ghế)</option>
                                <option value="vip" data-count="50">Sơ đồ VIP (50 ghế)</option>
                            </select>
                            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal"
                                data-bs-target="#seatMapModal">
                                <i class="bi bi-diagram-3"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Total Seats -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Số lượng ghế</label>
                        <input type="text" class="form-control" id="seatCount" name="total_seats">
                    </div>

                    <!-- Status -->
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="active" id="activeStatus">
                            <label class="form-check-label fw-semibold" for="activeStatus">
                                Kích hoạt phòng chiếu
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
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

    <!-- Modal -->
    <div class="modal fade" id="seatMapModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Xem trước sơ đồ ghế</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="text-center py-4">
                        <img src="https://via.placeholder.com/600x300?text=Sơ+đồ+ghế" alt="Sơ đồ ghế"
                            class="img-fluid rounded">
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
        </script>
        <script>
                      const districtSelect = document.getElementById('district');
            const cinemaSelect = document.getElementById('rapChieu');

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
@endsection
