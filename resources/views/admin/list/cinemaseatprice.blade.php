@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
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
                                        <form action="{{ route('cinemaseatprices.destroy', $price->id) }}" method="POST"
                                            class="d-inline">
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
                            <label class="form-label fw-semibold">Khu vực <span class="text-danger">*</span></label>
                            <select class="form-select @error('district') is-invalid @enderror" id="district" name="district" >
                                <option value="" disabled {{ old('district') ? '' : 'selected' }}>--- Chọn khu vực ---</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->city }}" {{ old('district') == $district->city ? 'selected' : '' }}>
                                        {{ $district->city }}
                                    </option>
                                @endforeach
                            </select>
                            @error('district')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Cinema -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Rạp chiếu <span class="text-danger">*</span></label>
                            <select class="form-select @error('cinema_id') is-invalid @enderror" id="rapChieu" name="cinema_id" >
                                <option value="" disabled {{ old('cinema_id') ? '' : 'selected' }}>--- Chọn rạp ---</option>
                                @foreach ($cinemas as $cinema)
                                    <option value="{{ $cinema->cinema_id }}" district-data="{{ $cinema->city }}"
                                        {{ old('cinema_id') == $cinema->cinema_id ? 'selected' : '' }}>
                                        {{ $cinema->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cinema_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Loại ghế <span class="text-danger">*</span></label>
                            <select class="form-select @error('seat_type_id') is-invalid @enderror" name="seat_type_id" >
                                <option value="">-- Chọn loại ghế --</option>
                                @foreach ($seatTypes as $seatType)
                                    <option value="{{ $seatType->seat_type_id }}" {{ old('seat_type_id') == $seatType->seat_type_id ? 'selected' : '' }}>
                                        {{ $seatType->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('seat_type_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Giá vé <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror"
                                   name="price" min="0"  value="{{ old('price') }}">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
                    @method('POST')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Rạp <span class="text-danger">*</span></label>
                            <input type="hidden" name="cinema_id" id="editCinemaId">
                            <input type="text" class="form-control" name="cinema_name" id="editCinemaName" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Loại ghế <span class="text-danger">*</span></label>
                            <select class="form-select" name="seat_type_id" id="editSeatTypeId" >
                                @foreach ($seatTypes as $seatType)
                                    <option value="{{ $seatType->seat_type_id }}">{{ $seatType->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Giá vé <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="price" id="editPrice" min="0" >
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
       document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function () {
                    const id = this.getAttribute('data-id');
                    const cinemaId = this.getAttribute('data-cinema-id');
                    const seatTypeId = this.getAttribute('data-seat-type-id');
                    const price = this.getAttribute('data-price');
                    const cinemaName = this.closest('tr').querySelector('td:nth-child(2)').innerText;

                    document.getElementById('editForm').action = `/cinemaseatprice/update/${id}`;
                    document.getElementById('editCinemaId').value = cinemaId;
                    document.getElementById('editCinemaName').value = cinemaName;
                    document.getElementById('editSeatTypeId').value = seatTypeId;
                    document.getElementById('editPrice').value = price;
                });
            });

            // Ẩn các rạp khi chưa chọn khu vực
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

            // Nếu có lỗi -> mở lại modal thêm mới
            @if ($errors->any())
                var addModal = new bootstrap.Modal(document.getElementById('addPriceModal'));
                addModal.show();
            @endif
        });
    </script>
@endpush
