@extends('layouts.manager')

@section('content')
<div class="card border-0 shadow-sm rounded-3 mt-3">
    <div class="card-header bg-light py-3">
        <h5 class="mb-0 fw-bold text-primary">
            <i class="bi bi-building me-2"></i>Cập nhật phòng chiếu
        </h5>
    </div>

    <div class="card-body p-4">
        <form action="{{ route('manager.rooms.update', $room->room_id) }}" method="POST">
            @csrf
            @method('PUT') {{-- QUAN TRỌNG: route update cần PUT --}}

            {{-- Hiển thị lỗi validate nếu có --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $e)
                        <div>{{ $e }}</div>
                    @endforeach
                </div>
            @endif

            <div class="row g-3">
                {{-- Tên phòng --}}
                <div class="col-md-6">
                    <label for="tenPhong" class="form-label fw-semibold">
                        Tên phòng <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control" id="tenPhong" name="room_name"
                           value="{{ old('room_name', $room->room_name) }}" required>
                </div>

                {{-- Khu vực (dùng để lọc rạp) – KHÔNG required, có name cho đẹp hoặc bỏ name luôn --}}
                <div class="col-md-6">
                    <label for="district" class="form-label fw-semibold">Khu vực</label>
                    <select class="form-select" id="district" name="city">
                        <option value="" selected>--- Chọn khu vực ---</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->city }}"
                                {{ $district->city === $room->cinema->city ? 'selected' : '' }}>
                                {{ $district->city }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Rạp chiếu --}}
                <div class="col-md-6">
                    <label for="rapChieu" class="form-label fw-semibold">
                        Rạp chiếu <span class="text-danger">*</span>
                    </label>
                    <select class="form-select" id="rapChieu" name="cinema_id" required>
                        <option value="" disabled>--- Chọn rạp ---</option>
                        @foreach ($cinemas as $cinema)
                            <option value="{{ $cinema->cinema_id }}"
                                    data-city="{{ $cinema->city }}"
                                    {{ $cinema->cinema_id == $room->cinema_id ? 'selected' : '' }}>
                                {{ $cinema->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Loại phòng --}}
                <div class="col-md-6">
                    <label for="loaiPhong" class="form-label fw-semibold">
                        Loại phòng <span class="text-danger">*</span>
                    </label>
                    <select class="form-select" id="loaiPhong" name="format" required>
                        <option value="" disabled>--- Chọn loại phòng ---</option>
                        <option value="2D"  {{ old('format', $room->format) === '2D'  ? 'selected' : '' }}>2D Tiêu chuẩn</option>
                        <option value="3D"  {{ old('format', $room->format) === '3D'  ? 'selected' : '' }}>3D</option>
                        <option value="IMAX"{{ old('format', $room->format) === 'IMAX'? 'selected' : '' }}>IMAX</option>
                        <option value="VIP" {{ old('format', $room->format) === 'VIP' ? 'selected' : '' }}>VIP</option>
                    </select>
                </div>

                {{-- Sơ đồ ghế --}}
                <div class="col-md-6">
                    <label for="soDoGhe" class="form-label fw-semibold">
                        Sơ đồ ghế <span class="text-danger">*</span>
                    </label>
                    <div class="input-group">
                        <select class="form-select" id="soDoGhe" name="seat_template" required>
                            <option value="" disabled>--- Chọn sơ đồ ---</option>
                            <option value="a"  data-count="120" {{ old('seat_template', $room->seat_template) === 'a'   ? 'selected' : '' }}>Sơ đồ A (120 ghế)</option>
                            <option value="b"  data-count="80"  {{ old('seat_template', $room->seat_template) === 'b'   ? 'selected' : '' }}>Sơ đồ B (80 ghế)</option>
                            <option value="vip"data-count="50"  {{ old('seat_template', $room->seat_template) === 'vip' ? 'selected' : '' }}>Sơ đồ VIP (50 ghế)</option>
                        </select>
                        <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#seatMapModal">
                            <i class="bi bi-diagram-3"></i>
                        </button>
                    </div>
                </div>

                {{-- Số ghế --}}
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Số lượng ghế</label>
                    <input type="text" class="form-control" id="seatCount" name="total_seats"
                           value="{{ old('total_seats', $room->total_seats) }}" readonly>
                </div>

                {{-- Trạng thái --}}
                <div class="col-12">
                    {{-- Hidden để khi bỏ chọn checkbox vẫn gửi active=0 --}}
                    <input type="hidden" name="active" value="0">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="active" id="activeStatus" value="1"
                               {{ old('active', $room->active) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="activeStatus">Kích hoạt phòng chiếu</label>
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                <a href="{{ route('manager.rooms.index') }}" class="btn btn-outline-secondary px-4">
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

{{-- Modal sơ đồ giữ nguyên --}}
{{-- @includeWhen(true, 'partials.seatmap-modal') --}}

@push('scripts')
<script>
    function updateSeatCount() {
        const select = document.getElementById('soDoGhe');
        const opt = select.options[select.selectedIndex];
        const count = opt ? opt.getAttribute('data-count') : '';
        if (count) document.getElementById('seatCount').value = count;
    }

    document.addEventListener('DOMContentLoaded', function () {
        // Cập nhật số ghế theo sơ đồ đang chọn khi load
        updateSeatCount();

        const districtSelect = document.getElementById('district');
        const cinemaSelect   = document.getElementById('rapChieu');

        const currentCity = districtSelect.value || @json($room->cinema->city);

        // Lọc rạp theo city nhưng KHÔNG disable option đang selected
        function filterCinemasByCity(city) {
            Array.from(cinemaSelect.options).forEach((option, index) => {
                if (index === 0) { // placeholder
                    option.hidden = false;
                    option.disabled = true;
                    return;
                }
                const ocity = option.getAttribute('data-city');
                const isSelected = option.selected;

                if (!city || ocity === city || isSelected) {
                    option.hidden = false;
                    option.disabled = false;
                } else {
                    option.hidden = true;
                    option.disabled = true;
                }
            });
        }

        filterCinemasByCity(currentCity);

        districtSelect.addEventListener('change', function () {
            filterCinemasByCity(this.value);
            // reset chọn rạp khi đổi khu vực
            const firstEnabled = Array.from(cinemaSelect.options).find(o => !o.disabled && o.value);
            if (firstEnabled) cinemaSelect.value = firstEnabled.value;
        });

        document.getElementById('soDoGhe').addEventListener('change', updateSeatCount);
    });
</script>
@endpush
@endsection
