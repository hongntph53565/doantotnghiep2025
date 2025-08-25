@extends('layouts.admin')

@push('styles')
<style>
    /* Thêm vào file CSS của bạn hoặc trong section styles */
.modal-header {
    background-color: #f8f9fa;
    border-bottom: 1px solid #dee2e6;
    padding: 1rem;
    border-top-left-radius: 0.3rem;
    border-top-right-radius: 0.3rem;
}

.modal-title {
    font-weight: 600;
    color: #212529;
    margin: 0;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    background-color: #f8f9fa;
    border-top: 1px solid #dee2e6;
    padding: 1rem;
    border-bottom-left-radius: 0.3rem;
    border-bottom-right-radius: 0.3rem;
}

.form-label {
    font-weight: 500;
    color: #495057;
    margin-bottom: 0.5rem;
}

.form-control, .form-select {
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
    padding: 0.375rem 0.75rem;
}

.form-control:focus, .form-select:focus {
    border-color: #86b7fe;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.img-thumbnail {
    border: 1px solid #dee2e6;
    border-radius: 0.25rem;
    padding: 0.25rem;
    background-color: #fff;
    max-width: 100%;
    height: auto;
}

.form-check-input:checked {
    background-color: #0d6efd;
    border-color: #0d6efd;
}

.btn {
    border-radius: 0.375rem;
    padding: 0.375rem 0.75rem;
    font-weight: 500;
}

.btn-close {
    background: transparent url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23000'%3e%3cpath d='M.293.293a1 1 0 011.414 0L8 6.586 14.293.293a1 1 0 111.414 1.414L9.414 8l6.293 6.293a1 1 0 01-1.414 1.414L8 9.414l-6.293 6.293a1 1 0 01-1.414-1.414L6.586 8 .293 1.707a1 1 0 010-1.414z'/%3e%3c/svg%3e") center/1em auto no-repeat;
    opacity: 0.5;
    width: 1em;
    height: 1em;
}

.btn-close:hover {
    opacity: 0.75;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .modal-body {
        padding: 1rem;
    }

    .form-label {
        font-size: 0.875rem;
    }

    .btn {
        padding: 0.25rem 0.5rem;
        font-size: 0.875rem;
    }
}

/* Custom styles for disabled selects */
select:disabled {
    background-color: #e9ecef;
    opacity: 1;
    cursor: not-allowed;
}

/* Style for the form container */
form {
    background-color: #fff;
    border-radius: 0.3rem;
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    max-width: 800px;
    margin: 0 auto;
}

/* Style for the image preview container */
.mt-2 {
    margin-top: 0.5rem;
}

/* Style for the status switch */
.form-switch .form-check-input {
    width: 2.5em;
    height: 1.5em;
    margin-left: 0;
}

.form-switch .form-check-label {
    margin-left: 0.5em;
}
</style>
@endpush

@section('content')
    <form action="{{ route('manager.foods.update', $food->food_id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="modal-header">
            <h5 class="modal-title">Chỉnh sửa món ăn</h5>
            <a href="{{ route('manager.foods.index') }}" class="btn-close"></a>
        </div>

        <div class="modal-body">
            <div class="mb-3">
                <label class="form-label">Khu vực</label>
                <select class="form-select" id="district" disabled>
                    <option value="" selected >--- Chọn khu vực ---</option>
                        @foreach ($districts as $district)
                            <option value="{{ $district->city }}"
                                {{ $district->city === $food->cinema->city ? 'selected' : '' }}>
                                {{ $district->city }}
                            </option>
                        @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Rạp phim</label>
                <select class="form-select" name="cinema_id" disabled>
                    <option value="{{ $food->cinema->cinema_id }}" selected>{{ $food->cinema->name ?? 'Không rõ' }}</option>
                    <input type="hidden" name="cinema_id" value="{{ $food->cinema->cinema_id }}" id="">
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Loại món</label>
                <select class="form-select" name="type" required>
                    <option value="combo" {{ $food->type == 'combo' ? 'selected' : '' }}>Combo</option>
                    <option value="food" {{ $food->type == 'food' ? 'selected' : '' }}>Đồ ăn</option>
                    <option value="drink" {{ $food->type == 'drink' ? 'selected' : '' }}>Thức uống</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Tên món</label>
                <input type="text" class="form-control" name="name" value="{{ $food->name }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Mô tả</label>
                <textarea class="form-control" rows="3" name="description">{{ $food->description }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Giá</label>
                <input type="number" class="form-control" name="price" value="{{ $food->price }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Ảnh mới (nếu muốn thay)</label>
                <input type="file" class="form-control" name="image">
                @if ($food->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $food->image) }}" class="img-thumbnail" width="100">
                    </div>
                @endif
            </div>

            <div class="form-check form-switch mb-3">
                <input class="form-check-input" type="checkbox" name="status" value="1" id="activeStatus"
                    {{ $food->status === 'active' ? 'checked' : '' }}>
                <label class="form-check-label fw-semibold" for="activeStatus">Trạng thái</label>
            </div>
        </div>

        <div class="modal-footer">
            <a href="{{ route('foods.index') }}" class="btn btn-secondary">Quay lại</a>
            <button type="submit" class="btn btn-primary">Cập nhật</button>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        const districtSelect = document.getElementById('district');
        const cinemaSelect = document.getElementById('rapChieu');

        Array.from(cinemaSelect.options).forEach((option, index) => {
            if (index !== 0) {
                option.hidden = true;
                option.disabled = true;
            }
        });

        districtSelect.addEventListener('change', function () {
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
