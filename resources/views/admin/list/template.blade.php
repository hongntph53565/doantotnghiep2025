@extends('layouts.admin')

@section('title2')
    Template Email
@endsection

@section('title1')
    Email
@endsection

@section('title')
    Template Email
@endsection

@section('content')
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold">Danh sách mẫu email</h6>
                <button class="btn btn-success" onclick="window.location.href='{{ route('template.create') }}'">
                    <i class="bi bi-plus-circle me-1"></i> Thêm template
                </button>

            </div>
            <form action="{{ route('template.index') }}" method="GET" class="d-flex mb-3">
                <input type="text" name="keyword" class="form-control me-2" placeholder="Tìm theo tên, chủ đề..."
                    value="{{ request('keyword') }}">

                <a href="{{ route('template.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </form>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>name</th>
                            <th>subject</th>
                            <th>Người tạo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($templates as $value)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td>{{ $value->template_name }}</td>
                                <td>{{ $value->subject }}</td>
                                <td>{{ $value->created_by }}</td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm"
                                        onclick="window.location.href='{{ route('template.edit', ['id' => $value->template_id]) }}'">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm"
                                        onclick="window.location.href='{{ route('template.show', ['id' => $value->template_id]) }}'">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <form action="{{ route('template.delete', ['id' => $value->template_id]) }}"
                                        method="POST" style="display: inline"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xoá mẫu email này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                {{ $templates->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection