@extends('layouts.admin')

@section('content')
    <form class="row g-3" method="POST" action="{{ route('template.update', ['id' => $template->template_id]) }}">
         @csrf
        <div class="row mt-3">
            <div class="col-md-9">
                <div class="card p-4 shadow-sm">
                    <h5 class="card-title mb-4 text-primary">Thông tin mẫu mail</h5>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="theaterName" class="form-label fw-bold">tên mẫu <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="template_name" id="" value="{{ $template->template_name }}">
                        </div>
                        <div class="col-md-6">
                            <label for="branch" class="form-label fw-bold">chủ đề <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="subject" id="" value="{{ $template->subject }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label fw-bold">Nội Dung <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control" name="content" id="description" rows="3" style="height: 250px;">{{ $template->content }}</textarea>
                        <div class="form-text"><span class="text-danger">*</span> là trường cần nhập liệu</div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card p-3 mb-3 shadow-sm">
                    <label for="createdBy" class="form-label fw-bold">Người tạo</label>
                    <input type="text" class="form-control" id="createdBy" name="created_by"
                        placeholder="Nhập tên người tạo" value="{{ $template->created_by }}" readonly>
                </div>
            </div>
        </div>
    </form>
@endsection
