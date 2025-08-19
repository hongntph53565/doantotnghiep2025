@extends('layouts.admin')

@section('content')
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-body p-0">
            <form action="{{ route('showtimes.index') }}">
                <div class="container-fluid bg-light p-4 rounded-top">
                    <div class="row align-items-end g-3">
                        <div class="col-xl-2 col-lg-3 col-md-6">
                            <label for="chiNhanh" class="form-label fw-semibold">Khu vực</label>
                            <select class="form-select" id="district" name="">
                                <option value="" selected disabled>--- Chọn khu vực ---</option>
                                @foreach ($districts as $district)
                                    <option value="{{ $district->city }}">{{ $district->city }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6">
                            <label for="rapChieu" class="form-label fw-semibold">Rạp chiếu <span
                                    class="text-danger">*</span></label>
                            <select class="form-select" id="rapChieu" name="cinema_id">
                                <option value="" selected disabled>--- Chọn rạp ---</option>
                                @foreach ($cinemas as $cinema)
                                    <option value="{{ $cinema->cinema_id }}" district-data="{{ $cinema->city }}">
                                        {{ $cinema->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6">
                            <label class="form-label fw-semibold small">Từ ngày</label>
                            <input type="date" name="from_date" class="form-control" value="{{ request('from_date') }}">
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6">
                            <label class="form-label fw-semibold small">Đến ngày</label>
                            <input type="date" name="to_date" class="form-control" value="{{ request('to_date') }}">
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6">
                            <label class="form-label fw-semibold small">Trạng thái</label>
                            <select name="status" class="form-select form-select-sm">
                                <option value="">Tất cả</option>
                                <option value="Đang chiếu" {{ request('status') == 'Đang chiếu' ? 'selected' : '' }}>Đang
                                    chiếu</option>
                                <option value="Sắp chiếu" {{ request('status') == 'Sắp chiếu' ? 'selected' : '' }}>Sắp chiếu
                                </option>
                                <option value="Đã hủy" {{ request('status') == 'Đã hủy' ? 'selected' : '' }}>Đã chiếu
                                </option>
                            </select>
                        </div>
                        <div class="col-xl-2 col-lg-3 col-md-6 d-flex gap-2">
                            <button class="btn btn-sm btn-primary flex-grow-1">
                                <i class="bi bi-funnel me-1"></i> Lọc
                            </button>
                            <button class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="d-flex justify-content-between align-items-center p-3 bg-white border-top border-bottom">
                <div class="text-muted small">
                    Hiển thị <strong>1-10</strong> trong <strong>25</strong> kết quả
                </div>
                <div>
                    <button class="btn btn-sm btn-success"
                        onclick="window.location.href='{{ route('showtimes.create') }}'">
                        <i class="bi bi-plus-circle me-1"></i> Thêm suất chiếu
                    </button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="25%">Phim</th>
                            <th width="15%">Ngày chiếu</th>
                            <th width="15%">Suất chiếu</th>
                            <th width="15%">Phòng</th>
                            <th width="15%">Trạng thái</th>
                            <th width="15%" class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($showtimes as $showtime)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $showtime->movie->poster) }}" class="rounded me-3"
                                            alt="Poster" width="50" height="75">
                                        <div>
                                            <div class="fw-semibold">{{ $showtime->movie->title }}</div>
                                            <small class="text-muted">
                                                {{ $showtime->movie->duration }} phút - {{ $showtime->room->format }}
                                                {{ $showtime->movie->language }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($showtime->date)->format('d/m/Y') }}</td>
                                <td>
                                    {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }} -
                                    {{ \Carbon\Carbon::parse($showtime->end_time)->format('H:i') }}
                                </td>
                                <td>{{ $showtime->room->room_name }}</td>
                                <td>
                                    @php
                                        $start = Carbon\Carbon::createFromFormat(
                                            'Y-m-d H:i:s',
                                            $showtime->date . ' ' . $showtime->start_time,
                                        );
                                        $end = Carbon\Carbon::createFromFormat(
                                            'Y-m-d H:i:s',
                                            $showtime->date . ' ' . $showtime->end_time,
                                        );
                                        $now = now();

                                        $status = $now->lt($start)
                                            ? 'Sắp chiếu'
                                            : ($now->between($start, $end)
                                                ? 'Đang chiếu'
                                                : 'Đã chiếu');

                                        $badgeClass = match ($status) {
                                            'Sắp chiếu' => 'bg-warning bg-opacity-10 text-warning',
                                            'Đang chiếu' => 'bg-success bg-opacity-10 text-success',
                                            'Đã chiếu' => 'bg-secondary bg-opacity-10 text-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $status }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('showtimes.edit', $showtime->showtime_id) }}"
                                            class="btn btn-icon btn-sm btn-outline-primary">    
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <button class="btn btn-icon btn-sm btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" data-id="{{ $showtime->showtime_id }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
            <div class="d-flex justify-content-between align-items-center p-3 bg-white border-top">
                <div class="text-muted small">
                    Hiển thị <strong>{{ $showtimes->firstItem() }}</strong> -
                    <strong>{{ $showtimes->lastItem() }}</strong> trong
                    <strong>{{ $showtimes->total() }}</strong> kết quả
                </div>
                {{ $showtimes->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title text-danger"><i class="bi bi-exclamation-triangle-fill me-2"></i>Xác nhận</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    Bạn có chắc chắn muốn xóa suất chiếu này? Thao tác này không thể hoàn tác.
                </div>
                <div class="modal-footer border-0">
    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
    <form id="deleteForm" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Xác nhận xóa</button>
    </form>
</div>

            </div>
        </div>
    </div>
@endsection

@push('scripts')


<script>
    const deleteModal = document.getElementById('deleteModal');
    deleteModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const showtimeId = button.getAttribute('data-id');
        const form = document.getElementById('deleteForm');
        form.action = `/admin/showtime/delete/${showtimeId}`;
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
    </script>
@endpush
