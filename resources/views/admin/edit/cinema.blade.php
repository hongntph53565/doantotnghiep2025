@extends('layouts.admin')

@section('content')
    <form method="POST" action="{{ route('cinemas.update', $cinema->cinema_id) }}" class="row g-3">
        @csrf
        <div class="row mt-3">
            <div class="col-md-9">
                <div class="card p-4 shadow-sm">
                    <h5 class="card-title mb-4 text-primary">Chỉnh sửa rạp chiếu</h5>

                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Tên rạp <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" id="name"
                               value="{{ old('name', $cinema->name) }}" placeholder="tên rạp phim ..." required>
                    </div>

                    <div class="mb-3">
                        <label for="address_detail" class="form-label fw-bold">Địa chỉ chi tiết <span class="text-danger">*</span></label>
                        <input type="text" name="address_detail" class="form-control" id="address_detail"
                               value="{{ old('address_detail', $cinema->address_detail) }}" required
                               placeholder="VD: 123 Lê Lợi">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="ward" class="form-label fw-bold">Phường <span class="text-danger">*</span></label>
                            <input type="text" name="ward" class="form-control" id="ward"
                                   value="{{ old('ward', $cinema->ward) }}" placeholder="phường ..." required>
                        </div>
                        <div class="col-md-4">
                            <label for="district" class="form-label fw-bold">Quận <span class="text-danger">*</span></label>
                            <input type="text" name="district" class="form-control" id="district"
                                   value="{{ old('district', $cinema->district) }}" placeholder="quận ..." required>
                        </div>
                        <div class="col-md-4">
                            <label for="city" class="form-label fw-bold">Thành phố <span class="text-danger">*</span></label>
                            <input type="text" name="city" class="form-control" id="city"
                                   value="{{ old('city', $cinema->city) }}" placeholder="thành phố ..." required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-bold">Số điện thoại</label>
                            <input type="text" name="phone" class="form-control" id="phone"
                                   value="{{ old('phone', $cinema->phone) }}" placeholder="số điện thoại ...">
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" id="email"
                                   value="{{ old('email', $cinema->email) }}" placeholder="email ...">
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" id="activeStatus" value="1"
                                {{ old('status', $cinema->status) === 'active' ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="activeStatus">
                                Kích hoạt rạp
                            </label>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3 shadow-sm mt-4">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary py-2">
                            <i class="bi bi-save me-2"></i> Cập nhật
                        </button>
                        <a href="{{ route('cinemas.index') }}" class="btn btn-outline-secondary py-2">
                            <i class="bi bi-arrow-left me-2"></i> Quay lại
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
