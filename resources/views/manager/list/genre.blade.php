@extends('layouts.manager')

@section('content')
    <div class="card shadow-sm rounded">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="mb-0">Quản lý Phân quyền</h4>
                <button class="btn btn-success" onclick="window.location.href='{{ route('manager.genres.create') }}'">+ Thêm thể
                    loại</button>
            </div>

            <form action="{{ route('genres.index') }}" method="GET" class="d-flex mb-3">
                <input type="text" name="keyword" class="form-control me-2" placeholder="Tìm theo thể loại..."
                    value="{{ request('keyword') }}">

                <a href="{{ route('genres.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>STT</th>
                            <th>Tên Thể Loại</th>
                            <th>Mô Tả</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($genres as $value)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td>{{ $value->genre_name }}</td>
                                <td>{{ $value->description }}</td>
                                <td>
                                    @if ($value->status === 'active')
                                        <span class="badge bg-success">Đang hoạt động</span>
                                    @else
                                        <span class="badge bg-secondary">Tạm ẩn</span>
                                    @endif
                                </td>
                                <td>{{ $value->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm"
                                        onclick="window.location.href='{{ route('genres.edit', ['id' => $value->genre_id]) }}'">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <form action="" method="POST" style="display: inline"
                                        onsubmit="return confirm('Bạn có chắc chắn muốn xoá rạp này?')">
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
                {{ $genres->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
