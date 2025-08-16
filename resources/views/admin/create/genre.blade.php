@extends('layouts.admin')

@section('content')
    <div class="card border-0 shadow-sm rounded-3 mt-3">
        <div class="card-header bg-light py-3">
            <h5 class="mb-0 fw-bold text-primary">
                <i class="bi bi-tags me-2"></i>Thêm Thể loại
            </h5>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('genres.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <!-- Tên thể loại -->
                    <div class="col-md-6">
                        <label for="genreName" class="form-label fw-semibold">Tên thể loại <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="genreName" name="genre_name"
                            placeholder="VD: Hành động, Hài, Kinh dị" required>
                    </div>

                    <!-- Mô tả -->
                    <div class="col-md-6">
                        <label for="description" class="form-label fw-semibold">Mô tả</label>
                        <input type="text" class="form-control" id="description" name="description"
                            placeholder="Thông tin thêm về thể loại (tuỳ chọn)">
                    </div>

                    <!-- Trạng thái -->
                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" id="activeStatus" value="1"
                                checked>
                            <label class="form-check-label fw-semibold" for="activeStatus">
                                Kích hoạt thể loại
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <a href="{{ route('genres.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left me-2"></i>Quay lại
                    </a>
                    <div class="d-flex gap-2">
                        <button type="reset" class="btn btn-outline-danger px-4">
                            <i class="bi bi-x-circle me-2"></i>Đặt lại
                        </button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-circle me-2"></i>Thêm mới
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
