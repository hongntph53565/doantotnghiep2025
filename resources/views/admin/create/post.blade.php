@extends('layouts.admin')

@section('content')
    <div class="container mt-4">
        <div class="card border-0 shadow">
            <div class="card-header bg-primary text-white">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold">
                        <i class="bi bi-plus-circle me-2"></i>Thêm bài viết mới
                    </h5>
                    <a href="{{ route('posts.index') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-arrow-left me-1"></i> Quay lại
                    </a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Tiêu đề -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Tiêu đề <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-control-lg"
                            value="{{ old('title') }}" placeholder="Nhập tiêu đề bài viết..." required>
                        @error('title')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Slug <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">{{ url('/') }}/</span>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug') }}"
                                placeholder="duong-dan-bai-viet" required>
                        </div>
                        @error('slug')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Đường dẫn tối ưu cho SEO</small>
                    </div>

                    <!-- Nội dung -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Nội dung <span class="text-danger">*</span></label>
                        <textarea name="content" id="tinymce-editor" class="form-control" rows="10" placeholder="Nhập nội dung bài viết..."
                            required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Trạng thái -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Trạng thái <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Bản nháp</option>
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Đã xuất bản
                            </option>
                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Chờ duyệt</option>
                        </select>
                        @error('status')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Danh mục -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Danh mục <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <select id="category-single-select" class="form-select">
                                <option value="">-- Chọn danh mục --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-outline-secondary" type="button" id="add-category-btn">
                                <i class="bi bi-plus"></i> Thêm
                            </button>
                        </div>

                        <!-- Hiển thị danh mục đã chọn -->
                        <div id="selected-categories-display" class="mt-2 p-3 bg-light rounded">
                            <div class="d-flex flex-wrap gap-2"></div>
                            <p class="text-muted mb-0 mt-2 small" id="no-categories-text">Chưa có danh mục nào được chọn</p>
                        </div>

                        <!-- Input ẩn để gửi mảng ID đã chọn -->
                        <input type="hidden" name="category_ids" id="category-ids-hidden"
                            value="{{ old('category_ids') }}">
                        @error('category_ids')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Ảnh thumbnail -->
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Ảnh thumbnail</label>
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <img id="thumbnail-preview"
                                    src="{{ old('thumbnail') ? asset('storage/' . old('thumbnail')) : asset('images/placeholder.jpg') }}"
                                    class="img-thumbnail" width="150" style="display: block;">
                            </div>
                            <div class="flex-grow-1">
                                <input type="file" name="thumbnail" id="thumbnail-input" class="form-control"
                                    accept="image/*" onchange="previewThumbnail(this)">
                                <small class="text-muted">Kích thước đề nghị: 1200x630px</small>
                                @error('thumbnail')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Nút submit -->
                    <div class="d-flex justify-content-between mt-4">
                        <button type="reset" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-counterclockwise me-1"></i> Nhập lại
                        </button>
                        <button type="submit" class="btn btn-success px-4">
                            <i class="bi bi-save me-1"></i> Lưu bài viết
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdn.tiny.cloud/1/ktaxkznnk6ds4pr79ltq9pk43690x69lkzxqhlnor9cav7h0/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>


        tinymce.init({
            selector: 'textarea#tinymce-editor',
            plugins: 'preview importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media codesample table charmap pagebreak nonbreaking anchor insertdatetime advlist lists wordcount help charmap quickbars emoticons accordion',
            editimage_cors_hosts: ['picsum.photos'],
            menubar: 'file edit view insert format tools table help',
            toolbar: "undo redo | accordion accordionremove | blocks fontfamily fontsize | bold italic underline strikethrough | align numlist bullist | link image | table media | lineheight outdent indent| forecolor backcolor removeformat | charmap emoticons | code fullscreen preview | save print | pagebreak anchor codesample | ltr rtl",
            autosave_ask_before_unload: true,
            autosave_interval: '30s',
            autosave_prefix: '{path}{query}-{id}-',
            autosave_restore_when_empty: false,
            autosave_retention: '2m',
            image_advtab: true,
            link_list: [{
                    title: 'My page 1',
                    value: 'https://www.tiny.cloud'
                },
                {
                    title: 'My page 2',
                    value: 'http://www.moxiecode.com'
                }
            ],
            image_list: [{
                    title: 'My page 1',
                    value: 'https://www.tiny.cloud'
                },
                {
                    title: 'My page 2',
                    value: 'http://www.moxiecode.com'
                }
            ],
            image_class_list: [{
                    title: 'None',
                    value: ''
                },
                {
                    title: 'Some class',
                    value: 'class-name'
                }
            ],
            importcss_append: true,
file_picker_callback: function (callback, value, meta) {
    if (meta.filetype === 'image') {
        const input = document.createElement('input');
        input.setAttribute('type', 'file');
        input.setAttribute('accept', 'image/*');

        input.onchange = function () {
            const file = this.files[0];
            const reader = new FileReader();

            reader.onload = function () {
                const base64 = reader.result;
                callback(base64, { alt: file.name });
            };

            reader.readAsDataURL(file);
        };

        input.click();
    }
},

            height: 600,
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_class: 'mceNonEditable',
            toolbar_mode: 'sliding',
            contextmenu: 'link image table',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });
    </script>
@endpush

@push('styles')
    <style>
        #selected-categories-display {
            min-height: 60px;
        }

        .remove-btn {
            opacity: 0.7;
        }

        .remove-btn:hover {
            opacity: 1;
        }

        #no-categories-text {
            display: block;
        }

        .tox-tinymce {
            border-radius: 6px !important;
            border: 1px solid #ced4da !important;
        }

        .form-control-lg {
            font-size: 1.1rem;
        }

        .card-header {
            padding: 1rem 1.5rem;
        }

        .btn-light {
            background-color: #f8f9fa;
            border-color: #dee2e6;
        }
    </style>
@endpush
