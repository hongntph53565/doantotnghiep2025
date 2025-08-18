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
                        <label for="template_name" class="form-label fw-bold">Tên mẫu <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('template_name') is-invalid @enderror" 
                               name="template_name" 
                               id="template_name" 
                               placeholder="Nhập tên mẫu" 
                               value="{{ old('template_name') }}" 
                               >
                        @error('template_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="subject" class="form-label fw-bold">Chủ đề <span class="text-danger">*</span></label>
                        <input type="text" 
                               class="form-control @error('subject') is-invalid @enderror" 
                               name="subject" 
                               id="subject" 
                               placeholder="Nhập chủ đề" 
                               value="{{ old('subject') }}" 
                               >
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label fw-bold">Nội dung <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('content') is-invalid @enderror" 
                              name="content" 
                              id="content" 
                              rows="3" 
                              placeholder="Nhập nội dung..." 
                              >{{ old('content') }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text"><span class="text-danger">*</span> là trường cần nhập liệu</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card p-3 mb-3 shadow-sm">
                <label for="createdBy" class="form-label fw-bold">Người đang tạo</label>
                <input type="text" class="form-control" id="createdBy" name="created_by" placeholder="Nhập tên người tạo">
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
