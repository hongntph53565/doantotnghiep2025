@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header bg-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="bi bi-tags me-2"></i>Quản lý phụ thu
            </h5>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExtraPriceModal">
                <i class="bi bi-plus-circle me-2"></i>Thêm mới
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Loại ngày</th>
                            <th>Ngày áp dụng</th>
                            <th>Phần trăm</th>
                            <th>Mô tả</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($extraPrices as $index => $extraPrice)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <span class="badge 
                                    {{ $extraPrice->day_type == 'weekday' ? 'bg-info' : 
                                      ($extraPrice->day_type == 'weekend' ? 'bg-warning' : 'bg-danger') }}">
                                    {{ $extraPrice->day_type_label }}
                                </span>
                            </td>
                            <td>{{ $extraPrice->date ? Carbon\Carbon::parse($extraPrice->date)->format('d/m/Y') : '--' }}</td>
                            <td>{{ $extraPrice->percentage }}%</td>
                            <td>{{ $extraPrice->description ?? '--' }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary edit-btn" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#editExtraPriceModal"
                                        data-id="{{ $extraPrice->extra_price_id }}"
                                        data-day-type="{{ $extraPrice->day_type }}"
                                        data-date="{{ $extraPrice->date }}"
                                        data-percentage="{{ $extraPrice->percentage }}"
                                        data-description="{{ $extraPrice->description }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('extraprices.destroy', $extraPrice->extra_price_id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Bạn chắc chắn muốn xóa?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Phân trang -->
            <div class="mt-3">
                {{ $extraPrices->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Thêm mới -->
<div class="modal fade" id="addExtraPriceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Thêm phụ thu mới</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="addForm" action="{{ route('extraprices.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Loại ngày <span class="text-danger">*</span></label>
                        <select class="form-select" name="day_type" required>
                            <option value="">-- Chọn loại ngày --</option>
                            <option value="weekday">Ngày thường</option>
                            <option value="weekend">Cuối tuần</option>
                            <option value="holiday">Ngày lễ</option>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="dateField">
                        <label class="form-label">Ngày áp dụng</label>
                        <input type="date" class="form-control" name="date">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Phần trăm phụ thu (%) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="percentage" min="0" max="100" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea class="form-control" name="description" rows="3"></textarea>
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
<div class="modal fade" id="editExtraPriceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-pencil-square me-2"></i>Chỉnh sửa phụ thu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Loại ngày <span class="text-danger">*</span></label>
                        <select class="form-select" name="day_type" id="editDayType" required>
                            <option value="weekday">Ngày thường</option>
                            <option value="weekend">Cuối tuần</option>
                            <option value="holiday">Ngày lễ</option>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="editDateField">
                        <label class="form-label">Ngày áp dụng</label>
                        <input type="date" class="form-control" name="date" id="editDate">
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Phần trăm phụ thu (%) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="percentage" id="editPercentage" min="0" max="100" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea class="form-control" name="description" id="editDescription" rows="3"></textarea>
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
        const dayTypeSelect = document.querySelector('select[name="day_type"]');
        const dateField = document.getElementById('dateField');
        
        function toggleDateField() {
            if (dayTypeSelect.value === 'holiday') {
                dateField.style.display = 'block';
                dateField.querySelector('input').required = true;
            } else {
                dateField.style.display = 'block';
                dateField.querySelector('input').required = false;
            }
        }
        
        dayTypeSelect.addEventListener('change', toggleDateField);
        toggleDateField();
    });

    // Xử lý popup chỉnh sửa
    document.querySelectorAll('.edit-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            const dayType = this.getAttribute('data-day-type');
            const date = this.getAttribute('data-date');
            const percentage = this.getAttribute('data-percentage');
            const description = this.getAttribute('data-description');
            
            document.getElementById('editForm').action = `/extraprice/update/${id}`;
            document.getElementById('editDayType').value = dayType;
            document.getElementById('editDate').value = date;
            document.getElementById('editPercentage').value = percentage;
            document.getElementById('editDescription').value = description;
            
            // Xử lý hiển thị trường ngày
            document.getElementById('editDateField').style.display = dayType === 'holiday' ? 'block' : 'block';
        });
    });
</script>
@endpush