@extends('layouts.admin')

@section('content')
    <div class="card border-0 shadow-sm rounded-3 mt-3">
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
                        <label for="title" class="form-label fw-semibold">Tên phim <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <!-- Thể loại -->
                    <div class="col-md-6">
                        <label for="genre_id" class="form-label fw-semibold">Thể loại <span
                                class="text-danger">*</span></label>
                        <select class="form-select" name="genre_id" id="genre_id" required>
                            <option value="" disabled selected>--- Chọn thể loại ---</option>
                            @foreach ($genres as $genre)
                                <option value="{{ $genre->genre_id }}">{{ $genre->genre_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Đạo diễn -->
                    <div class="col-md-6">
                        <label for="director" class="form-label fw-semibold">Đạo diễn</label>
                        <input type="text" class="form-control" id="director" name="director">
                    </div>

                    <!-- Diễn viên -->
                    <div class="col-md-6">
                        <label for="cast" class="form-label fw-semibold">Diễn viên</label>
                        <input type="text" class="form-control" id="cast" name="cast">
                    </div>

                    <!-- Ngày phát hành -->
                    <div class="col-md-6">
                        <label for="release_date" class="form-label fw-semibold">Ngày phát hành <span
                                class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="release_date" name="release_date" required>
                    </div>

                    <!-- Ngày kết thúc -->
                    <div class="col-md-6">
                        <label for="end_date" class="form-label fw-semibold">Ngày kết thúc</label>
                        <input type="date" class="form-control" id="end_date" name="end_date">
                    </div>

                    <!-- Poster -->
                    <div class="col-md-6">
                        <label for="poster" class="form-label fw-semibold">Poster</label>
                        <input type="file" class="form-control" id="poster" name="poster">
                    </div>

                    <!-- Trailer -->
                    <div class="col-md-6">
                        <label for="trailer" class="form-label fw-semibold">Link trailer</label>
                        <input type="url" class="form-control" id="trailer" name="trailer">
                    </div>

                    <!-- Thời lượng -->
                    <div class="col-md-6">
                        <label for="duration" class="form-label fw-semibold">Thời lượng (phút) <span
                                class="text-danger">*</span></label>
                        <input type="number" min="1" class="form-control" id="duration" name="duration" required>
                    </div>

                    <!-- Độ tuổi -->
                    <div class="col-md-6">
                        <label for="age_rating" class="form-label fw-semibold">Độ tuổi</label>
                        <select class="form-select" name="age_rating" id="age_rating">
                            <option value="P">P - Mọi lứa tuổi</option>
                            <option value="T13">T13 - Trên 13</option>
                            <option value="T18">T18 - Trên 18</option>
                        </select>
                    </div>

                    <!-- Ngôn ngữ -->
                    <div class="col-md-6">
                        <label for="language" class="form-label fw-semibold">Ngôn ngữ</label>
                        <select class="form-select" name="language" id="language">
                            <option value="Phụ đề">Phụ Đề</option>
                            <option value="Lồng tiếng">Lồng tiếng</option>

                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="format" class="form-label fw-semibold">Định dạng</label>

                        <div id="format-wrapper">
                            <select class="form-select" name="format" id="format-select"
                                onchange="handleFormatChange(this)">
                                <option value="2D">2D</option>
                                <option value="3D">3D</option>
                                <option value="IMAX">IMAX</option>
                                <option value="4DX">4DX</option>
                                <option value="Khác">Khác</option>
                            </select>
                        </div>
                    </div>



                    <!-- Mô tả -->
                    <div class="col-md-12">
                        <label for="description" class="form-label fw-semibold">Mô tả</label>
                        <textarea name="description" id="description" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- Trạng thái -->
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" name="status" id="activeStatus" value="1" checked>
                        <label class="form-check-label fw-semibold" for="activeStatus">
                            Kích hoạt phim
                        </label>
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
                <input type="text" class="form-control" name="format" id="format-input" placeholder="Nhập định dạng...">
            `;
        }
    }
</script>