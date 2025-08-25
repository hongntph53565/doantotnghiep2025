@extends('layouts.admin')

@section('title2')
    Thêm phim
@endsection

@section('title1')
    Phim & suất chiếu
@endsection

@section('title')
    Quản lý phim
@endsection

@section('content')
    <div class="card border-0 shadow-sm rounded-3 mt-3">

     @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
        <div class="card-header bg-light py-3">
            <h5 class="mb-0 fw-bold text-primary">
                <i class="bi bi-film me-2"></i>Thêm phim mới
            </h5>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('movies.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row g-3">
                    <!-- Tên phim -->
                    <div class="col-md-6">
                        <label for="title" class="form-label fw-semibold">Tên phim <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" >
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Thể loại -->
                    <div class="col-md-6">
                        <label for="genre_id" class="form-label fw-semibold">Thể loại <span class="text-danger">*</span></label>
                        <select class="form-select @error('genre_id') is-invalid @enderror" name="genre_id" id="genre_id" >
                            <option value="" disabled {{ old('genre_id') ? '' : 'selected' }}>--- Chọn thể loại ---</option>
                            @foreach ($genres as $genre)
                                <option value="{{ $genre->genre_id }}" {{ old('genre_id') == $genre->genre_id ? 'selected' : '' }}>
                                    {{ $genre->genre_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('genre_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Đạo diễn -->
                    <div class="col-md-6">
                        <label for="director" class="form-label fw-semibold">Đạo diễn</label>
                        <input type="text" class="form-control @error('director') is-invalid @enderror" id="director" name="director" value="{{ old('director') }}">
                        @error('director')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Diễn viên -->
                    <div class="col-md-6">
                        <label for="cast" class="form-label fw-semibold">Diễn viên</label>
                        <input type="text" class="form-control @error('cast') is-invalid @enderror" id="cast" name="cast" value="{{ old('cast') }}">
                        @error('cast')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ngày phát hành -->
                    <div class="col-md-6">
                        <label for="release_date" class="form-label fw-semibold">Ngày phát hành <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('release_date') is-invalid @enderror" id="release_date" name="release_date" value="{{ old('release_date') }}" >
                        @error('release_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ngày kết thúc -->
                    <div class="col-md-6">
                        <label for="end_date" class="form-label fw-semibold">Ngày kết thúc</label>
                        <input type="date" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date') }}">
                        @error('end_date')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Poster -->
                    <div class="col-md-6">
                        <label for="poster" class="form-label fw-semibold">Poster</label>
                        <input type="file" class="form-control @error('poster') is-invalid @enderror" id="poster" name="poster">
                        @error('poster')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Trailer -->
                    <div class="col-md-6">
                        <label for="trailer" class="form-label fw-semibold">Link trailer</label>
                        <input type="url" class="form-control @error('trailer') is-invalid @enderror" id="trailer" name="trailer" value="{{ old('trailer') }}">
                        @error('trailer')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Thời lượng -->
                    <div class="col-md-6">
                        <label for="duration" class="form-label fw-semibold">Thời lượng (phút) <span class="text-danger">*</span></label>
                        <input type="number" min="1" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration') }}" >
                        @error('duration')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Độ tuổi -->
                    <div class="col-md-6">
                        <label for="age_rating" class="form-label fw-semibold">Độ tuổi</label>
                        <select class="form-select @error('age_rating') is-invalid @enderror" name="age_rating" id="age_rating">
                            <option value="P" {{ old('age_rating') == 'P' ? 'selected' : '' }}>P - Mọi lứa tuổi</option>
                            <option value="T13" {{ old('age_rating') == 'T13' ? 'selected' : '' }}>T13 - Trên 13</option>
                            <option value="T18" {{ old('age_rating') == 'T18' ? 'selected' : '' }}>T18 - Trên 18</option>
                        </select>
                        @error('age_rating')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ngôn ngữ -->
                    <div class="col-md-6">
                        <label for="language" class="form-label fw-semibold">Ngôn ngữ</label>
                        <select class="form-select @error('language') is-invalid @enderror" name="language" id="language">
                            <option value="Phụ đề" {{ old('language') == 'Phụ đề' ? 'selected' : '' }}>Phụ Đề</option>
                            <option value="Lồng tiếng" {{ old('language') == 'Lồng tiếng' ? 'selected' : '' }}>Lồng tiếng</option>
                        </select>
                        @error('language')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Định dạng -->
                    <div class="col-md-6">
                        <label for="format" class="form-label fw-semibold">Định dạng</label>
                        <div id="format-wrapper">
                            <select class="form-select @error('format') is-invalid @enderror" name="format" id="format-select" onchange="handleFormatChange(this)">
                                <option value="2D" {{ old('format') == '2D' ? 'selected' : '' }}>2D</option>
                                <option value="3D" {{ old('format') == '3D' ? 'selected' : '' }}>3D</option>
                                <option value="IMAX" {{ old('format') == 'IMAX' ? 'selected' : '' }}>IMAX</option>
                                <option value="4DX" {{ old('format') == '4DX' ? 'selected' : '' }}>4DX</option>
                                <option value="Khác" {{ old('format') == 'Khác' ? 'selected' : '' }}>Khác</option>
                            </select>
                            @error('format')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Mô tả -->
                    <div class="col-md-12">
                        <label for="description" class="form-label fw-semibold">Mô tả</label>
                        <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="3">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Trạng thái -->
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="status" id="activeStatus" value="1" {{ old('status', 1) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="activeStatus">Kích hoạt phim</label>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <a href="{{ route('movies.index') }}" class="btn btn-outline-secondary px-4">
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

<script>
    function handleFormatChange(select) {
        if (select.value === "Khác") {
            const wrapper = document.getElementById('format-wrapper');
            wrapper.innerHTML = `
                <input type="text" class="form-control @error('format') is-invalid @enderror" name="format" id="format-input" placeholder="Nhập định dạng..." value="{{ old('format') }}">
            `;
        }
    }
</script>
