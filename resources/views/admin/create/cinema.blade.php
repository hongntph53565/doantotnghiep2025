@extends('layouts.admin')

@section('title2')
    Thêm rạp chiếu
@endsection

@section('title1')
    Hệ thống
@endsection

@section('title')
    Rạp
@endsection
@section('content')
    <form method="POST" action="{{ route('cinemas.store') }}" class="row g-3">
        @csrf
        <div class="row mt-3">
            <div class="col-md-9">
                <div class="card p-4 shadow-sm">
                    <h5 class="card-title mb-4 text-primary">Thông tin rạp chiếu</h5>

                    {{-- Tên rạp --}}
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold">Tên rạp <span class="text-danger">*</span></label>
                        <input type="text" name="name"
                               class="form-control @error('name') is-invalid @enderror"
                               id="name" placeholder="tên rạp phim ..."
                               value="{{ old('name') }}" >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Địa chỉ chi tiết --}}
                    <div class="mb-3">
                        <label for="address_detail" class="form-label fw-bold">Địa chỉ chi tiết <span class="text-danger">*</span></label>
                        <input type="text" name="address_detail"
                               class="form-control @error('address_detail') is-invalid @enderror"
                               id="address_detail" placeholder="VD: 123 Lê Lợi"
                               value="{{ old('address_detail') }}" >
                        @error('address_detail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Phường / Quận / Thành phố --}}
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="ward" class="form-label fw-bold">Phường <span class="text-danger">*</span></label>
                            <input type="text" name="ward"
                                   class="form-control @error('ward') is-invalid @enderror"
                                   id="ward" placeholder="phường ..."
                                   value="{{ old('ward') }}" >
                            @error('ward')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="district" class="form-label fw-bold">Quận <span class="text-danger">*</span></label>
                            <input type="text" name="district"
                                   class="form-control @error('district') is-invalid @enderror"
                                   id="district" placeholder="quận ..."
                                   value="{{ old('district') }}" >
@error('district')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-4">
                            <label for="city" class="form-label fw-bold">Thành phố <span class="text-danger">*</span></label>
                            <input type="text" name="city"
                                   class="form-control @error('city') is-invalid @enderror"
                                   id="city" placeholder="thành phố ..."
                                   value="{{ old('city') }}" >
                            @error('city')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- SĐT / Email --}}
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="phone" class="form-label fw-bold">Số điện thoại</label>
                            <input type="text" name="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   id="phone" placeholder="VD: 0912345678"
                                   value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label fw-bold">Email</label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email" placeholder="email@example.com"
                                   value="{{ old('email') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    {{-- Trạng thái --}}
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" id="activeStatus" value="1"
                                {{ old('status', 1) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="activeStatus">
                                Kích hoạt rạp
                            </label>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Nút submit --}}
            <div class="col-md-3">
                <div class="card p-3 shadow-sm mt-4">
<div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary py-2">
                            <i class="bi bi-save me-2"></i> Lưu rạp chiếu
                        </button>
                        <button type="reset" class="btn btn-outline-secondary py-2">
                            <i class="bi bi-arrow-counterclockwise me-2"></i> Đặt lại
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection