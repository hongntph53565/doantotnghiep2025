@extends('layouts.admin')

@section('title2')
    Mã giảm giá
@endsection

@section('title1')
    Dịch vụ & ưu đãi
@endsection

@section('title')
    Mã giảm giá
@endsection

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <button class="btn btn-primary btn-sm me-2" id="toggleDrawer">☰</button>
            <h4 class="mb-0">Quản lý Khuyến mãi</h4>
        </div>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#promoModal" id="btnAddPromo">
            <i class="bi bi-plus-circle"></i> Thêm khuyến mãi
        </button>
    </div>
    <div class="card mb-4">
        <div class="card-body">
            <ul class="nav nav-tabs" id="categoryTabs" role="tablist">
                @foreach ($promos as $type => $items)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="{{ $type }}-tab"
                            data-bs-toggle="tab" data-bs-target="#{{ $type }}" type="button" role="tab">
                            {{ $type == 'percent' ? 'Giảm phần trăm' : ($type == 'amount' ? 'Giảm cố định' : ucfirst($type)) }}
                        </button>
                    </li>
                @endforeach
            </ul>

            <div class="tab-content pt-3" id="categoryTabContent">
                @foreach ($promos as $type => $items)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $type }}"
                        role="tabpanel" aria-labelledby="{{ $type }}-tab">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Mã KM</th>
                                        <th>Giá trị</th>
                                        <th>Trạng thái</th>
                                        <th>Ngày bắt đầu</th>
                                        <th>Ngày kết thúc</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $value)
                                        <tr>
                                            <td><span class="badge bg-info">{{ $value->discount_code }}</span></td>
                                            <td>
                                                {{ $value->discount_value }}{{ $value->type_discount == 'percent' ? '%' : 'đ' }}
                                            </td>
                                            <td>
                                                @if ($value->status == 'active')
                                                    <span class="badge bg-success">Đang áp dụng</span>
                                                @else
                                                    <span class="badge bg-secondary">Không khả dụng</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($value->start_date)->format('d/m/Y') }}</td>
                                            <td>{{ \Carbon\Carbon::parse($value->end_date)->format('d/m/Y') }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning edit-btn"
                                                    data-id="{{ $value->promo_id }}"
                                                    data-code="{{ $value->discount_code }}"
                                                    data-type="{{ $value->type_discount }}"
                                                    data-percent="{{ $value->type_discount == 'percent' ? $value->discount_value : '' }}"
                                                    data-amount="{{ $value->type_discount == 'amount' ? $value->discount_value : '' }}"
                                                    data-max-uses="{{ $value->max_uses }}"
                                                    data-max-discount="{{ $value->max_discount }}"
                                                    data-min-order="{{ $value->min_order_value }}"
                                                    data-start="{{ $value->start_date }}"
                                                    data-end="{{ $value->end_date }}" data-status="{{ $value->status }}"
                                                    data-bs-toggle="modal" data-bs-target="#promoModal">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <form action="{{ route('promotions.destroy', ['id' => $value->promo_id]) }}"
      method="POST"
      class="d-inline"
      onsubmit="return confirm('Bạn có chắc chắn muốn xoá mã này?')">
    @csrf
    @method('DELETE')
    <button class="btn btn-sm btn-danger">
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
                @endforeach
            </div>
        </div>
    </div>
    </div>
 
    <div class="modal fade" id="promoModal" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                           @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                <form id="promoForm" method="POST" action="{{ route('promotions.store') }}">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">

              

                    
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="promoModalTitle">Thêm khuyến mãi mới</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Mã giảm giá <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="discountCode" name="discount_code">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Loại giảm giá <span class="text-danger">*</span></label>
                                <select class="form-select" id="discountType" name="type_discount" >
                                    <option value="">-- Chọn loại --</option>
                                    <option value="percent">Phần trăm</option>
                                    <option value="amount">Số tiền cố định</option>
                                </select>
                            </div>

                            <div class="col-md-6" id="percentField" style="display: none;">
                                <label class="form-label">Phần trăm giảm</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="discountPercent" name="discount_percent"
                                        min="1" >
                                    <span class="input-group-text">%</span>
                                </div>
                            </div>

                            <div class="col-md-6" id="amountField" style="display: none;">
                                <label class="form-label">Số tiền giảm</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="discountAmount"
                                        name="discount_amount" min="1000">
                                    <span class="input-group-text">₫</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Số lần sử dụng</label>
                                <input type="number" class="form-control" id="maxUses" name="max_uses"
                                    min="1">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Giảm tối đa</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="maxDiscount" name="max_discount"
                                        min="0">
                                    <span class="input-group-text">₫</span>
                                </div>
                            </div>

                            <div class="col-md-6">
    <label class="form-label fw-semibold">Loại thẻ áp dụng <span class="text-danger">*</span></label>
    <select class="form-select" name="card_type" id="cardType" >
        <option value="normal">Normal</option>
        <option value="silver">Silver</option>
        <option value="gold">Gold</option>
        <option value="platinum">Platinum</option>
    </select>
</div>

                            <div class="col-md-6">
                                <label class="form-label">Đơn hàng tối thiểu</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="minOrder" name="min_order_value"
                                        min="0">
                                    <span class="input-group-text">₫</span>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Ngày bắt đầu</label>
                                <input type="date" class="form-control" id="startDate" name="start_date" >
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Ngày kết thúc</label>
                                <input type="date" class="form-control" id="endDate" name="end_date" >
                            </div>

                            <div class="col-12">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="status" id="activeStatus"
                                        value="1" checked>
                                    <label class="form-check-label fw-semibold" for="activeStatus">
                                        <small>Kích hoạt</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="submit" class="btn btn-primary" id="submitPromoBtn">Lưu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    {{-- @push('scripts')
        <script>
            document.getElementById('discountType').addEventListener('change', function() {
                const type = this.value;
                document.getElementById('percentField').style.display = type === 'percent' ? 'block' : 'none';
                document.getElementById('amountField').style.display = type === 'amount' ? 'block' : 'none';
            });

            document.getElementById('editDiscountType1').addEventListener('change', function() {
                const type = this.value;
                document.getElementById('editpercentField1').style.display = type === 'percent' ? 'block' :
                    'none';
                document.getElementById('editAmountField1').style.display = type === 'amount' ? 'block' : 'none';
            });
        </script>
    @endpush --}}

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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const promoModalEl = document.getElementById('promoModal');
    const promoModal = new bootstrap.Modal(promoModalEl);
    const promoForm = document.getElementById('promoForm');
    const title = document.getElementById('promoModalTitle');
    const typeSelect = document.getElementById('discountType');
    const percentField = document.getElementById('percentField');
    const amountField = document.getElementById('amountField');
    const maxDiscountField = document.getElementById('maxDiscount').closest('.col-md-6');

    function toggleFields(type) {
        if (type === 'percent') {
            percentField.style.display = 'block';
            amountField.style.display = 'none';
            maxDiscountField.style.display = 'block';
        } else if (type === 'amount') {
            percentField.style.display = 'none';
            amountField.style.display = 'block';
            maxDiscountField.style.display = 'none';
        } else {
            percentField.style.display = 'none';
            amountField.style.display = 'none';
            maxDiscountField.style.display = 'none';
        }
    }

    function fillForm(data, isEdit = false) {
        promoForm.reset();

        if (isEdit) {
            promoForm.action = `{{ route('promotions.update', ':id') }}`.replace(':id', data.id);

            // thêm hoặc cập nhật _method = PUT
            let methodInput = promoForm.querySelector('input[name="_method"]');
            if (!methodInput) {
                methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                promoForm.appendChild(methodInput);
            }
            methodInput.value = 'PUT';

            title.textContent = "Chỉnh sửa khuyến mãi";
        } else {
            promoForm.action = `{{ route('promotions.store') }}`;

            // xoá _method nếu có
            const methodInput = promoForm.querySelector('input[name="_method"]');
            if (methodInput) methodInput.remove();

            title.textContent = "Thêm khuyến mãi mới";
        }

        document.getElementById('discountCode').value = data.code || '';
        document.getElementById('discountType').value = data.type || 'percent';
        document.getElementById('discountPercent').value = data.percent || '';
        document.getElementById('discountAmount').value = data.amount || '';
        document.getElementById('maxUses').value = data.maxUses || '';
        document.getElementById('maxDiscount').value = data.maxDiscount || '';
        document.getElementById('minOrder').value = data.minOrder || '';
        document.getElementById('startDate').value = data.start || '';
        document.getElementById('endDate').value = data.end || '';
        document.getElementById('activeStatus').checked = data.status == 1 || data.status === 'active';

        toggleFields(data.type || 'percent');
    }

    // Khi chọn loại giảm giá
    typeSelect.addEventListener('change', function() {
        toggleFields(this.value);
    });

    // Thêm mới
    document.getElementById('btnAddPromo').addEventListener('click', function() {
        fillForm({}, false);
    });

    // Chỉnh sửa
    document.querySelectorAll('.edit-btn').forEach(button => {
        button.addEventListener('click', function() {
            const data = this.dataset;
            fillForm({
                id: data.id,
                code: data.code,
                type: data.type,
                percent: data.percent,
                amount: data.amount,
                maxUses: data.maxUses,
                maxDiscount: data.maxDiscount,
                minOrder: data.minOrder,
                start: data.start,
                end: data.end,
                status: data.status,
            }, true);

            promoModal.show();
        });
    });

    // Nếu có lỗi validate thì mở modal lại
    @if ($errors->any())
        promoModal.show();
        @if (session('edit_mode'))
            fillForm({
                id: "{{ session('edit_id') }}",
                code: "{{ old('discount_code') }}",
                type: "{{ old('type_discount') }}",
                percent: "{{ old('discount_percent') }}",
                amount: "{{ old('discount_amount') }}",
                maxUses: "{{ old('max_uses') }}",
                maxDiscount: "{{ old('max_discount') }}",
                minOrder: "{{ old('min_order_value') }}",
                start: "{{ old('start_date') }}",
                end: "{{ old('end_date') }}",
                status: "{{ old('status') }}",
            }, true);
        @else
            fillForm({
                code: "{{ old('discount_code') }}",
                type: "{{ old('type_discount') }}",
                percent: "{{ old('discount_percent') }}",
                amount: "{{ old('discount_amount') }}",
                maxUses: "{{ old('max_uses') }}",
                maxDiscount: "{{ old('max_discount') }}",
                minOrder: "{{ old('min_order_value') }}",
                start: "{{ old('start_date') }}",
                end: "{{ old('end_date') }}",
                status: "{{ old('status') }}",
            }, false);
        @endif
    @endif
});
</script>
@endpush
