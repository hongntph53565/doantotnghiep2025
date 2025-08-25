@extends('layouts.manager')

@section('content')
<div class="card border-0 shadow-sm mt-3">
    <div class="card-body">

        @if(!empty($errorMessage))
            <div class="alert alert-warning text-center">
                {{ $errorMessage }}
            </div>
        @else
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold">Danh sách phòng chiếu</h6>
                <a href="{{ route('manager.rooms.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle me-1"></i> Thêm Phòng chiếu
                </a>
            </div>

            <form action="{{ route('rooms.index') }}" method="GET" class="d-flex mb-3">
                <input type="text" name="keyword" class="form-control me-2" placeholder="Tìm theo tên rạp..."
                    value="{{ request('keyword') }}">
                <a href="{{ route('rooms.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên phòng</th>
                            <th>Rạp chiếu</th>
                            <th>Định dạng</th>
                            <th>Số ghế</th>
                            <th>Ngày tạo</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rooms as $room)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td>{{ $room->room_name }}</td>
                                <td>{{ $room->cinema->name ?? 'Không xác định' }}</td>
                                <td>{{ $room->format ?? 'Không xác định' }}</td>
                                <td>{{ $room->total_seats }}</td>
                                <td>{{ $room->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <a href="{{ route('manager.rooms.edit', ['id' => $room->room_id]) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <a href="{{ route('manager.rooms.show', ['id' => $room->room_id]) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-end mt-3">
                {{ $rooms->withQueryString()->links() }}
            </div>
        @endif

    </div>
</div>
@endsection
