@extends('layouts.admin')

@section('content')
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-body p-0">
            <form action="#">
                <div class="container-fluid bg-light p-4 rounded-top">
                    <div class="row align-items-end g-3">
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <label for="category" class="form-label fw-semibold">Danh mục</label>
                            <select class="form-select" id="category" name="category_id">
                                <option value="" selected>Tất cả danh mục</option>
                                <option value="1">Tin tức</option>
                                <option value="2">Khuyến mãi</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <label class="form-label fw-semibold">Từ ngày</label>
                            <input type="date" name="from_date" class="form-control" value="">
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <label class="form-label fw-semibold">Đến ngày</label>
                            <input type="date" name="to_date" class="form-control" value="">
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <label class="form-label fw-semibold">Trạng thái</label>
                            <select name="status" class="form-select">
                                <option value="">Tất cả</option>
                                <option value="draft">Bản nháp</option>
                                <option value="published" selected>Đã xuất bản</option>
                                <option value="pending">Chờ duyệt</option>
                            </select>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <label class="form-label fw-semibold">Tìm kiếm</label>
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Tiêu đề bài viết..."
                                    value="">
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-4 col-md-6 d-flex gap-2 align-items-end">
                            <button class="btn btn-primary flex-grow-1">
                                <i class="bi bi-funnel me-1"></i> Lọc
                            </button>
                            <a href="#" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-counterclockwise"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            <div class="d-flex justify-content-between align-items-center p-3 bg-white border-top border-bottom">
                <div class="text-muted small">
                    Hiển thị <strong>{{ $posts->firstItem() }}</strong> -
                    <strong>{{ $posts->lastItem() }}</strong> trong
                    <strong>{{ $posts->total() }}</strong> kết quả
                </div>
                <div>
                    <a href="{{ route('posts.create') }}" class="btn btn-sm btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Thêm bài viết
                    </a>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="40%">Tiêu đề</th>
                            <th width="15%">Tác giả</th>
                            <th width="15%">Danh mục</th>
                            <th width="15%">Ngày đăng</th>
                            <th width="10%">Trạng thái</th>
                            <th width="5%" class="text-center">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if ($post->thumbnail)
                                            <img src="{{ asset('storage/' . $post->thumbnail) }}" class="rounded me-3"
                                                alt="Thumbnail" width="60" height="40" style="object-fit: cover;">
                                        @endif
                                        <div>
                                            <div class="fw-semibold">{{ $post->title }}</div>
                                            <small
                                                class="text-muted">{{ Str::limit(strip_tags($post->content), 100) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $post->author->name ?? 'Không rõ' }}</td>
                                <td>
                                    @foreach ($post->categories as $category)
                                        <span class="badge bg-light text-dark">{{ $category->name }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $post->published_at ? $post->published_at->format('d/m/Y H:i') : 'Chưa xuất bản' }}
                                </td>
                                <td>
                                    @php
                                        $badgeClass = match ($post->status) {
                                            'draft' => 'bg-secondary',
                                            'published' => 'bg-success',
                                            'pending' => 'bg-warning',
                                            default => 'bg-light',
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">{{ $post->status }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('posts.edit', $post->id) }}"
                                            class="btn btn-icon btn-sm btn-outline-primary">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <button class="btn btn-icon btn-sm btn-outline-danger" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" data-id="{{ $post->id }}">
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
                    Hiển thị <strong>{{ $posts->firstItem() }}</strong> -
                    <strong>{{ $posts->lastItem() }}</strong> trong
                    <strong>{{ $posts->total() }}</strong> kết quả
                </div>
                {{ $posts->appends(request()->query())->links() }}
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
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-body py-4">
                        Bạn có chắc chắn muốn xóa bài viết này? Thao tác này không thể hoàn tác.
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Hủy bỏ</button>
                        <button type="submit" class="btn btn-danger">Xác nhận xóa</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.getElementById('deleteModal').addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const postId = button.getAttribute('data-id');
            const form = document.getElementById('deleteForm');
            form.action = `/admin/posts/${postId}`;
        });

        const thumbnailInput = document.getElementById('thumbnail');
        if (thumbnailInput) {
            thumbnailInput.addEventListener('change', function(e) {
                const preview = document.getElementById('thumbnailPreview');
                const file = e.target.files[0];
                if (file) {
                    preview.src = URL.createObjectURL(file);
                    preview.classList.remove('d-none');
                }
            });
        }
    </script>
@endpush
