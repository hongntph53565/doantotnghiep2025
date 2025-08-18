@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-light">
            <h5 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Chỉnh sửa bài viết</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Tiêu đề</label>
                    <input type="text" name="title" class="form-control" value="{{ old('title', $post->title) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug', $post->slug) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nội dung</label>
                    <textarea name="content" class="form-control" rows="6" required>{{ old('content', $post->content) }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Trạng thái</label>
                    <select name="status" class="form-select" required>
                        <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                        <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>Đã xuất bản</option>
                        <option value="pending" {{ $post->status == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Danh mục</label>
                    <select name="category_ids[]" class="form-select" multiple>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $post->categories->contains($category->id) ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    <small class="text-muted">Giữ Ctrl để chọn nhiều danh mục</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Ảnh thumbnail</label><br>
                    @if($post->thumbnail)
                        <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Thumbnail" class="mb-2 rounded" width="120"><br>
                    @endif
                    <input type="file" name="thumbnail" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Cập nhật</button>
                <a href="{{ route('posts.index') }}" class="btn btn-secondary">Quay lại</a>
            </form>
        </div>
    </div>
</div>
@endsection
