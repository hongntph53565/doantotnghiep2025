@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/css/crete/promotion.css') }}">
@endpush

@section('content')
    <form class="row g-4">
    <!-- Left column: Main Form -->
    <div class="col-lg-9">
        <div class="card shadow-sm rounded-3">
            <div class="card-header bg-light py-3">
                <h5 class="mb-0 fw-bold">Thông tin voucher</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <!-- Row 1 -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Mã giảm giá <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="35SROXKI" required>
                            <button class="btn btn-outline-secondary" type="button" title="Tạo ngẫu nhiên">
                                <i class="bi bi-arrow-repeat"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Số lượng <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" min="1" value="5" required>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Giới hạn sử dụng <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" min="1" value="6" required>
                    </div>

                    <!-- Row 2 -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Kiểu voucher <span class="text-danger">*</span></label>
                        <select class="form-select" required>
                            <option value="percent" selected>Phần trăm (%)</option>
                            <option value="cash">Tiền mặt (VND)</option>
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Giá trị giảm <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <input type="number" class="form-control" min="1" value="49" required>
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Thời gian bắt đầu <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" value="2025-03-26T12:00" required>
                    </div>

                    <!-- Row 3 -->
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">Thời gian kết thúc <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control" value="2025-03-31T12:00" required>
                    </div>
                    
                    <div class="col-md-8">
                        <label class="form-label fw-semibold">Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" placeholder="Nhập tiêu đề hấp dẫn" value="hi" required>
                    </div>

                    <!-- Row 4 -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Mô tả ngắn</label>
                        <textarea class="form-control" rows="3" placeholder="Mô tả ưu đãi...">🎉🎉🎉</textarea>
                        <div class="form-text">Tối đa 200 ký tự</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right column: Advanced Settings -->
    <div class="col-lg-3">
        <div class="card shadow-sm rounded-3 mb-4">
            <div class="card-header bg-light py-3">
                <h5 class="mb-0 fw-bold">Điều kiện áp dụng</h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Đơn hàng tối thiểu (VND)</label>
                    <div class="input-group">
                        <input type="number" class="form-control" min="0" value="2000000">
                        <span class="input-group-text">đ</span>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label fw-semibold">Giảm tối đa (VND)</label>
                    <div class="input-group">
                        <input type="number" class="form-control" min="0" value="49">
                        <span class="input-group-text">đ</span>
                    </div>
                </div>
                
                
            </div>
        </div>

        <div class="card shadow-sm rounded-3">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <label class="form-label fw-semibold mb-0">Trạng thái</label>
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" checked role="switch">
                    </div>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary py-2">
                        <i class="bi bi-save me-2"></i> Lưu voucher
                    </button>
                    <button type="reset" class="btn btn-outline-secondary py-2">
                        <i class="bi bi-x-circle me-2"></i> Hủy bỏ
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
