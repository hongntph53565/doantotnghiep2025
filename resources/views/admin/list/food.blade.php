@extends('layouts.admin')

@section('title2')
    Thể loại 
@endsection

@section('title1')
    Đồ ăn & thức uống
@endsection

@section('title')
    Thể loại 
@endsection

@push('styles')
<style>
    .nav-tabs .nav-link {
        color: #495057;
        font-weight: 500;
    }

    .nav-tabs .nav-link.active {
        color: #0d6efd;
        border-bottom: 2px solid #0d6efd;
    }

    .img-thumbnail {
        height: 60px;
        object-fit: cover;
    }

    .table th {
        background-color: #f8f9fa;
        font-weight: 600;
    }

    .badge {
        font-size: 0.85em;
        padding: 0.35em 0.65em;
    }

    /* Container nav */
    #cinemaTabs {
        border-bottom: none;
        gap: 6px;
        flex-wrap: wrap;
    }

    /* Tab item */
    #cinemaTabs .nav-link {
        border: 1px solid #dee2e6;
        border-radius: 20px;
        padding: 8px 18px;
        margin-bottom: 8px;
        font-weight: 500;
        color: #495057;
        background-color: #f8f9fa;
        transition: all 0.2s ease-in-out;
    }

    /* Hover */
    #cinemaTabs .nav-link:hover {
        background-color: #e9ecef;
        color: #0d6efd;
        transform: translateY(-2px);
    }

    /* Active */
    #cinemaTabs .nav-link.active {
        background-color: #0d6efd;
        color: #fff;
        border-color: #0d6efd;
        box-shadow: 0 3px 6px rgba(13,110,253,.3);
    }
</style>
@endpush


@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="mb-0">Quản lý Đồ ăn & Thức uống</h4>
        </div>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addItemModal">
            <i class="bi bi-plus-circle"></i> Thêm mới
        </button>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <!-- Tabs -->
            <ul class="nav nav-tabs" id="cinemaTabs" role="tablist">
    @foreach ($foods as $cinemaId => $items)
        <li class="nav-item" role="presentation">
            <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                    id="cinema-{{ $cinemaId }}-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#cinema-{{ $cinemaId }}"
                    type="button"
                    role="tab">
                {{ $items->first()->cinema->name ?? 'Không rõ rạp' }}
            </button>
        </li>
    @endforeach
</ul>


            <!-- Tab content -->
           <div class="tab-content pt-3" id="cinemaTabContent">
    @foreach ($foods as $cinemaId => $items)
        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
             id="cinema-{{ $cinemaId }}" role="tabpanel"
             aria-labelledby="cinema-{{ $cinemaId }}-tab">

            {{-- Bên trong 1 rạp -> tiếp tục chia theo loại món --}}
            @php
                $groupedByType = $items->groupBy('type');
            @endphp

            @foreach ($groupedByType as $type => $list)
                <h5 class="mt-3">{{ ucfirst($type) }}</h5>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th width="80">Ảnh</th>
                                <th>Tên món</th>
                                <th>Mô tả</th>
                                <th>Giá</th>
                                <th>Trạng thái</th>
                                <th width="120">Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $value)
                                <tr>
                                    <td><img src="{{ asset('storage/' . $value->image) }}" class="img-thumbnail" width="60"></td>
                                    <td>{{ $value->name }}</td>
                                    <td>{{ $value->description }}</td>
                                    <td>{{ number_format($value->price, 0, ',', '.') }} ₫</td>
                                    <td>
                                        <span class="badge {{ $value->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                            {{ $value->status === 'active' ? 'Đang bán' : 'Ngừng bán' }}
                                        </span>
                                    </td>
                                    <td>
    @if ($value->trashed())
        {{-- Nếu đã bị xóa mềm --}}
        <form action="{{ route('foods.restore', ['id' => $value->food_id]) }}" method="POST" class="d-inline">
            @csrf
            @method('PATCH')
            <button class="btn btn-outline-success btn-sm me-1">
                <i class="bi bi-arrow-counterclockwise"></i>
            </button>
        </form>

        <form action="{{ route('foods.forceDestroy', ['id' => $value->food_id]) }}" method="POST" class="d-inline"
              onsubmit="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn món này?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-danger btn-sm">
                <i class="bi bi-x-circle-fill"></i>
            </button>
        </form>
    @else
        {{-- Nếu chưa xóa thì hiện nút sửa + xóa mềm --}}
        <a href="{{ route('foods.edit', ['id' => $value->food_id]) }}" class="btn btn-outline-primary btn-sm me-1">
            <i class="bi bi-pencil-fill"></i>
        </a>
        <form action="{{ route('foods.destroy', ['id' => $value->food_id]) }}" method="POST" class="d-inline"
              onsubmit="return confirm('Bạn có chắc chắn muốn xóa món này?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-outline-danger btn-sm">
                <i class="bi bi-trash-fill"></i>
            </button>
        </form>
    @endif
</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
        </div>
    </div>

   <!-- Modal thêm món -->
<div class="modal fade" id="addItemModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('foods.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Thêm món mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    {{-- Hiển thị lỗi --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label class="form-label">Khu vực</label>
                        <select class="form-select" id="district" name="district">
                            <option value="" disabled {{ old('district') ? '' : 'selected' }}>--- Chọn khu vực ---</option>
                            @foreach ($districts as $district)
                                <option value="{{ $district->city }}" {{ old('district') == $district->city ? 'selected' : '' }}>
                                    {{ $district->city }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rạp phim</label>
                        <select class="form-select" id="rapChieu" name="cinema_id">
                            <option value="" disabled {{ old('cinema_id') ? '' : 'selected' }}>--- Chọn rạp ---</option>
                            @foreach ($cinemas as $cinema)
                                <option value="{{ $cinema->cinema_id }}"
                                    district-data="{{ $cinema->city }}"
                                    {{ old('cinema_id') == $cinema->cinema_id ? 'selected' : '' }}>
                                    {{ $cinema->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Loại món</label>
                        <select class="form-select" name="type">
                            <option value="combo" {{ old('type') == 'combo' ? 'selected' : '' }}>Combo</option>
                            <option value="food" {{ old('type') == 'food' ? 'selected' : '' }}>Đồ ăn</option>
                            <option value="drink" {{ old('type') == 'drink' ? 'selected' : '' }}>Thức uống</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Tên món</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Mô tả</label>
                        <textarea class="form-control" rows="3" name="description">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Giá</label>
                        <input type="number" class="form-control" name="price" value="{{ old('price') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Ảnh</label>
                        <input type="file" class="form-control" name="image">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="status" id="activeStatus" value="1"
                               {{ old('status', '1') ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="activeStatus">Trạng thái</label>
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
@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const districtSelect = document.getElementById('district');
        const cinemaSelect = document.getElementById('rapChieu');

        // Ẩn tất cả rạp lúc đầu trừ placeholder
        Array.from(cinemaSelect.options).forEach((option, index) => {
            if (index !== 0) {
                option.hidden = true;
                option.disabled = true;
            }
        });

        // Khi chọn khu vực
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

        // 👇 Nếu có lỗi thì tự động mở modal
        @if ($errors->any())
            let modal = new bootstrap.Modal(document.getElementById('addItemModal'));
            modal.show();
        @endif
    });
</script>
@endpush




{{-- @push('scripts')
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

        // 👇 Nếu có lỗi thì mở modal lại
        @if ($errors->any())
            var myModal = new bootstrap.Modal(document.getElementById('addItemModal'));
            myModal.show();
        @endif
    </script>
@endpush --}}
