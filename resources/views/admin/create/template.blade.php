@extends('layouts.admin')

@section('content')
    <form class="row g-3" method="POST" action="{{ route('template.store') }}">
         @csrf
        <div class="row mt-3">
            <div class="col-md-9">
                <div class="card p-4 shadow-sm">
                    <h5 class="card-title mb-4 text-primary">Thông tin mẫu mail</h5>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="theaterName" class="form-label fw-bold">tên mẫu <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="template_name" id="" placeholder="Nhập tên rạp" required>
                        </div>
                        <div class="col-md-6">
                            <label for="branch" class="form-label fw-bold">chủ đề <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="subject" id="" placeholder="Nhập tên rạp" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Nội Dung <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control" name="content" id="description" rows="3" placeholder="Nhập mô tả về rạp chiếu..." required></textarea>
                        <div class="form-text"><span class="text-danger">*</span> là trường cần nhập liệu</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3 mb-3 shadow-sm">
                    <label for="createdBy" class="form-label fw-bold">Người đang tạo</label>
                    <input type="text" class="form-control" value="{{ session('my_name') ?? 'Guest' }}" id="createdBy" name="created_by"
                        placeholder="Nhập tên người tạo" readonly>
                </div>

                <div class="card p-3 shadow-sm">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary py-2">
                            <i class="bi bi-save me-2"></i> Lưu 
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
