@extends('layouts.manager')

@section('content')
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
            <ul class="nav nav-tabs" id="categoryTabs" role="tablist">
                @foreach ($foods as $type => $items)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                id="{{ $type }}-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#{{ $type }}"
                                type="button"
                                role="tab">
                            {{ ucfirst($type) }}
                        </button>
                    </li>
                @endforeach
            </ul>

            <!-- Tab content -->
            <div class="tab-content pt-3" id="categoryTabContent">
                @foreach ($foods as $type => $items)
                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}"
                         id="{{ $type }}" role="tabpanel"
                         aria-labelledby="{{ $type }}-tab">
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
                                    @forelse ($items as $value)
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
                                                                                    <a href="{{ route('foods.edit', ['id' => $value->food_id]) }}"
                                        class="btn btn-outline-primary btn-sm me-1">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <form action="" method="POST" class="d-inline"
                                        onsubmit="return confirm('Xóa log này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr><td colspan="6" class="text-center">Không có món nào</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
                        <div class="mb-3">
                            <label class="form-label">Rạp phim</label>
                            <input type="hidden" name="cinema_id" id="" value="{{ $cinema_id }}">
                            <input type="text" class="form-control" name="cinema_id" id="" value="{{ $cinemaName }}" disabled>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Loại món</label>
                            <select class="form-select" name="type">
                                <option value="combo">Combo</option>
                                <option value="food">Đồ ăn</option>
                                <option value="drink">Thức uống</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tên món</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Mô tả</label>
                            <textarea class="form-control" rows="3" name="description"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Giá</label>
                            <input type="number" class="form-control" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ảnh</label>
                            <input type="file" class="form-control" name="image">
                        </div>
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="status" id="activeStatus" value="1" checked>
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

@section('styles')
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
    </style>
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
