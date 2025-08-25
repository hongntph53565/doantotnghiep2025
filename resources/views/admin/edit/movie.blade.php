@extends('layouts.admin')

@section('content')
    <div class="card border-0 shadow-sm rounded-3 mt-3">
        @if ($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <div class="card-header bg-light py-3">
            <h5 class="mb-0 fw-bold text-primary">
                <i class="bi bi-film me-2"></i>Cập nhật phim
            </h5>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('movies.update', $movie->movie_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Tên phim <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{ $movie->title }}" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Thể loại <span class="text-danger">*</span></label>
                        <select name="genre_id" class="form-select" required>
                            @foreach ($genres as $genre)
                                <option value="{{ $genre->genre_id }}"
                                    {{ $movie->genre_id == $genre->genre_id ? 'selected' : '' }}>
                                    {{ $genre->genre_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Đạo diễn</label>
                        <input type="text" name="director" class="form-control" value="{{ $movie->director }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Diễn viên</label>
                        <input type="text" name="cast" class="form-control" value="{{ $movie->cast }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Ngày phát hành</label>
                        <input type="date" name="release_date" class="form-control" value="{{ $movie->release_date }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Ngày kết thúc</label>
                        <input type="date" name="end_date" class="form-control" value="{{ $movie->end_date }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Poster (nếu thay)</label>
                        <input type="file" name="poster" class="form-control">
                        @if ($movie->poster)
                            <img src="{{ asset('storage/' . $movie->poster) }}" class="mt-2" style="height: 100px;">
                        @endif
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Trailer</label>
                        <input type="url" name="trailer" class="form-control" value="{{ $movie->trailer }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Thời lượng (phút)</label>
                        <input type="number" name="duration" class="form-control" value="{{ $movie->duration }}">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Độ tuổi</label>
                        <select name="age_rating" class="form-select">
                            <option value="P" {{ $movie->age_rating == 'P' ? 'selected' : '' }}>P - Mọi lứa tuổi
                            </option>
                            <option value="T13" {{ $movie->age_rating == 'T13' ? 'selected' : '' }}>T13 - Trên 13
                            </option>
                            <option value="T18" {{ $movie->age_rating == 'T18' ? 'selected' : '' }}>T18 - Trên 18
                            </option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Ngôn ngữ</label>
                        <select name="language" class="form-select">
                            <option value="Phụ đề" {{ $movie->language == 'Phụ đề' ? 'selected' : '' }}>Phụ đề</option>
                            <option value="Lồng tiếng" {{ $movie->language == 'Lồng tiếng' ? 'selected' : '' }}>Lồng tiếng
                            </option>

                        </select>
                    </div>

                    <div class="col-12">
                        <label class="form-label fw-semibold">Mô tả</label>
                        <textarea name="description" class="form-control" rows="3">{{ $movie->description }}</textarea>
                    </div>

                    <div class="col-12">
                        <div class="form-check form-switch">
                            <input type="checkbox" name="status" class="form-check-input" id="activeStatus" value="1"
                                {{ $movie->status == 'active' ? 'checked' : '' }}>
                            <label for="activeStatus" class="form-check-label fw-semibold">Kích hoạt phim</label>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4 pt-3 border-top">
                    <a href="{{ route('movies.index') }}" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left me-2"></i>Quay lại
                    </a>
                    <div class="d-flex gap-2">
                        <button type="reset" class="btn btn-outline-danger px-4">
                            <i class="bi bi-x-circle me-2"></i>Đặt lại
                        </button>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check-circle me-2"></i>Cập nhật
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
