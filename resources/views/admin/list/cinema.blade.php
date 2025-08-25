@extends('layouts.admin')

@section('title2')
     Quản lý rạp chiếu
@endsection

@section('title1')
    Hệ thống rạp
@endsection

@section('title')
     Quản lý rạp chiếu
@endsection

@section('content')
    <div class="card border-0 shadow-sm mt-3">
        <div class="card border-0 shadow-sm mt-3">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold">Danh sách rạp chiếu</h6>
                <button class="btn btn-success" onclick="window.location.href='{{ route('cinemas.create') }}'">
                    <i class="bi bi-plus-circle me-1"></i> Thêm Rạp chiếu
                </button>

            </div>
            <form action="{{ route('cinemas.index') }}" method="GET" class="d-flex mb-3">
                <input type="text" name="keyword" class="form-control me-2" placeholder="Tìm theo tên, chủ đề..."
                    value="{{ request('keyword') }}">

                <a href="{{ route('cinemas.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên rạp</th>
                            <th>địa chỉ chi tiết</th>
                            <th>phường</th>
                            <th>huyện</th>
                            <th>thành phố</th>
                            <th>Hotline</th>
                            <th>email</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cinemas as $value)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td>{{ $value->name }}</td>
                                <td>{{ $value->address_detail }}</td>
                                <td>{{ $value->ward }}</td>
                                <td>{{ $value->district }}</td>
                                <td>{{ $value->city }}</td>
                                <td>{{ $value->phone }}</td>
                                <td>{{ $value->email }}</td>
                                <td>
                                    <button class="btn btn-outline-primary btn-sm"
                                        onclick="window.location.href='{{ route('cinemas.edit', ['id' => $value->cinema_id]) }}'">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <form action="{{ route('cinemas.delete', ['id' => $value->cinema_id]) }}"
                                        method="POST" style="display: inline"
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
                {{ $cinemas->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
