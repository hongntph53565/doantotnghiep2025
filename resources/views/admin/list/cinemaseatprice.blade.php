@extends('layouts.admin')

@section('title2')
     Quản lý giá ghế
@endsection

@section('title1')
    Hệ thống rạp
@endsection

@section('title')
     Quản lý giá ghế
@endsection

@section('content')
    <div class="container-fluid">
        <div class="card border-0 shadow-sm mt-3">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            <div class="card shadow-sm">
                <div class="card-header bg-light d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-ticket-perforated me-2"></i>Quản lý giá vé theo loại ghế
                    </h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPriceModal">
                        <i class="bi bi-plus-circle me-2"></i>Thêm mới
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>STT</th>
                                    <th>Rạp</th>
                                    <th>Loại ghế</th>
                                    <th>Giá vé</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($prices as $index => $price)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $price->cinema->name }}</td>
                                        <td>{{ $price->seatType->name }}</td>
                                        <td>{{ number_format($price->price) }}đ</td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary edit-btn" data-bs-toggle="modal"
                                                data-bs-target="#editPriceModal" data-id="{{ $price->id }}"
                                                data-cinema-id="{{ $price->cinema_id }}"
                                                data-seat-type-id="{{ $price->seat_type_id }}"
                                                data-price="{{ $price->price }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>
                                            <form action="{{ route('cinemaseatprices.destroy', $price->id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Bạn chắc chắn muốn xóa?')">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Thêm mới -->
        <div class="modal fade" id="addPriceModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Thêm giá vé mới</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="addForm" action="{{ route('cinemaseatprices.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="chiNhanh" class="form-label fw-semibold">Khu vực <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="district" name="" required>
                                    <option value="" selected disabled>--- Chọn khu vực ---</option>
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->city }}">{{ $district->city }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Cinema -->
                            <div class="mb-3">
                                <label for="rapChieu" class="form-label fw-semibold">Rạp chiếu <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="rapChieu" name="cinema_id" required>
                                    <option value="" selected disabled>--- Chọn rạp ---</option>
                                    @foreach ($cinemas as $cinema)
                                        <option value="{{ $cinema->cinema_id }}" district-data="{{ $cinema->city }}">
                                            {{ $cinema->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Loại ghế <span class="text-danger">*</span></label>
                                <select class="form-select" name="seat_type_id" required>
                                    <option value="">-- Chọn loại ghế --</option>
                                    @foreach ($seatTypes as $seatType)
                                        <option value="{{ $seatType->seat_type_id }}">{{ $seatType->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Giá vé <span class="text-danger">*</span></label>
                                <input type="number" class="form-control" name="price" min="0" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Lưu lại</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Chỉnh sửa -->
        <div class="modal fade" id="editPriceModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Chỉnh sửa giá vé</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="editForm" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Rạp <span class="text-danger">*</span></label>
                                <input type="hidden" name="cinema_id" id="editCinemaId">
                                <input type="text" class="form-control" name="cinema_name" id="editCinemaName"
                                    readonly>
                            </div>

                            <div class="mb-3">
    <label class="form-label">Loại ghế <span class="text-danger">*</span></label>
    <!-- Hiển thị tên ghế -->
    <input type="text" class="form-control" id="editSeatTypeName" readonly>
    <!-- Gửi seat_type_id khi submit -->
    <input type="hidden" name="seat_type_id" id="editSeatTypeId">
</div>

                            <div class="mb-3">
    <label class="form-label">Giá vé <span class="text-danger">*</span></label>
    <input type="text" class="form-control" name="price" id="editPrice" required>
    <div class="invalid-feedback" id="priceError">
        Giá vé không hợp lệ.
    </div>
</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endsection

  @push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const cinemaId = this.getAttribute('data-cinema-id');
            const seatTypeId = this.getAttribute('data-seat-type-id');
            const price = this.getAttribute('data-price');

            const cinemaName = this.closest('tr').querySelector('td:nth-child(2)').innerText;
            const seatTypeName = this.closest('tr').querySelector('td:nth-child(3)').innerText;

            // Action form
            document.getElementById('editForm').action =
                "{{ url('admin/cinemaseatprice/update') }}/" + id;

            // Cinema
            document.getElementById('editCinemaId').value = cinemaId;
            document.getElementById('editCinemaName').value = cinemaName;

            // Seat type (readonly)
            document.getElementById('editSeatTypeId').value = seatTypeId;
            document.getElementById('editSeatTypeName').value = seatTypeName;

            // Price
            document.getElementById('editPrice').value = price;
        });
    });
});

// District & Cinema filter (giữ nguyên)
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

// Validate giá vé
document.addEventListener("DOMContentLoaded", function () {
    const editPriceInput = document.getElementById("editPrice");
    const priceError = document.getElementById("priceError");
    const updateBtn = document.querySelector("#editForm button[type='submit']");

    function validatePrice() {
        const value = editPriceInput.value.trim();

        if (value === "" || isNaN(value)) {
            editPriceInput.classList.add("is-invalid");
            priceError.textContent = "Vui lòng nhập số.";
            updateBtn.disabled = true;
            return false;
        }

        if (Number(value) > 500000) {
            editPriceInput.classList.add("is-invalid");
            priceError.textContent = "Giá vé không được lớn hơn 500.000.";
            updateBtn.disabled = true;
            return false;
        }

        editPriceInput.classList.remove("is-invalid");
        updateBtn.disabled = false;
        return true;
    }

    editPriceInput.addEventListener("input", validatePrice);

    $('#editPriceModal').on('shown.bs.modal', function () {
        validatePrice();
    });

    document.getElementById("editForm").addEventListener("submit", function (e) {
        if (!validatePrice()) {
            e.preventDefault();
        }
    });
});
</script>
@endpush
