@extends('layouts.admin')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <button class="btn btn-primary btn-sm me-2" id="toggleDrawer">☰</button>
            <h4 class="mb-0">Quản lý Khuyến mãi</h4>
        </div>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addPromoModal">
            <i class="bi bi-plus-circle"></i> Thêm khuyến mãi
        </button>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Mã KM</th>
                            <th>Loại giảm giá</th>
                            <th>Giá trị</th>
                            <th>Trạng thái</th>
                            <th>Ngày bắt đầu</th>
                            <th>Ngày kết thúc</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Dữ liệu giả - Fake data -->
                        <tr>
                            <td><span class="badge bg-info">SUMMER20</span></td>
                            <td>Giảm 20%</td>
                            <td>20%</td>
                            <td><span class="badge bg-success">Đang áp dụng</span></td>
                            <td>01/06/2023</td>
                            <td>31/08/2023</td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPromoModal1">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-info">MOVIE50K</span></td>
                            <td>Giảm 50,000₫</td>
                            <td>50,000₫</td>
                            <td><span class="badge bg-success">Đang áp dụng</span></td>
                            <td>15/07/2023</td>
                            <td>15/08/2023</td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPromoModal2">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><span class="badge bg-info">STUDENT10</span></td>
                            <td>Giảm 10%</td>
                            <td>10%</td>
                            <td><span class="badge bg-secondary">Đã hủy</span></td>
                            <td>01/05/2023</td>
                            <td>30/05/2023</td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editPromoModal3">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Add Promo Modal -->
<div class="modal fade" id="addPromoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title">Thêm khuyến mãi mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mã giảm giá</label>
                        <input type="text" class="form-control" placeholder="VD: SUMMER20" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Loại giảm giá</label>
                        <select class="form-select" id="discountType">
                            <option value="percentage">Phần trăm</option>
                            <option value="amount">Số tiền cố định</option>
                        </select>
                    </div>
                    <div class="mb-3" id="percentageField">
                        <label class="form-label">Phần trăm giảm</label>
                        <input type="number" class="form-control" placeholder="10" min="1" max="100">
                    </div>
                    <div class="mb-3" id="amountField" style="display:none;">
                        <label class="form-label">Số tiền giảm (₫)</label>
                        <input type="number" class="form-control" placeholder="50000" min="1000">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ngày bắt đầu</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ngày kết thúc</label>
                        <input type="date" class="form-control" required>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="status" checked>
                        <label class="form-check-label" for="status">Kích hoạt</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Thêm khuyến mãi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modals (one for each promo) -->
<div class="modal fade" id="editPromoModal1" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form>
                <div class="modal-header">
                    <h5 class="modal-title">Chỉnh sửa khuyến mãi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Mã giảm giá</label>
                        <input type="text" class="form-control" value="SUMMER20" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Loại giảm giá</label>
                        <select class="form-select" id="editDiscountType1">
                            <option value="percentage" selected>Phần trăm</option>
                            <option value="amount">Số tiền cố định</option>
                        </select>
                    </div>
                    <div class="mb-3" id="editPercentageField1">
                        <label class="form-label">Phần trăm giảm</label>
                        <input type="number" class="form-control" value="20" min="1" max="100">
                    </div>
                    <div class="mb-3" id="editAmountField1" style="display:none;">
                        <label class="form-label">Số tiền giảm (₫)</label>
                        <input type="number" class="form-control" min="1000">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ngày bắt đầu</label>
                        <input type="date" class="form-control" value="2023-06-01" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ngày kết thúc</label>
                        <input type="date" class="form-control" value="2023-08-31" required>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="editStatus1" checked>
                        <label class="form-check-label" for="editStatus1">Kích hoạt</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>

@push('scripts')
<script>
    // Toggle between percentage and amount fields for add modal
    document.getElementById('discountType').addEventListener('change', function() {
        const type = this.value;
        document.getElementById('percentageField').style.display = type === 'percentage' ? 'block' : 'none';
        document.getElementById('amountField').style.display = type === 'amount' ? 'block' : 'none';
    });

    // Toggle for edit modals (you would need one for each modal in real implementation)
    document.getElementById('editDiscountType1').addEventListener('change', function() {
        const type = this.value;
        document.getElementById('editPercentageField1').style.display = type === 'percentage' ? 'block' : 'none';
        document.getElementById('editAmountField1').style.display = type === 'amount' ? 'block' : 'none';
    });
</script>
@endpush

@push('styles')
<style>
    .badge {
        font-size: 0.85em;
        padding: 0.5em 0.75em;
    }
    
    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }
    
    .modal-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
    }
    
    .form-switch .form-check-input {
        width: 2.5em;
        height: 1.5em;
    }
    
    .btn-sm {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
</style>
@endpush
@endsection