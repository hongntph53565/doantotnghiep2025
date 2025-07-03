@extends('layouts.admin')

@section('content')
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold">Danh sách phòng chiếu</h6>
                <button class="btn btn-success" onclick="window.location.href='create_room.html'">
                    <i class="bi bi-plus-circle me-1"></i> Tạo phòng chiếu
                </button>
            </div>

            <!-- Bộ lọc trạng thái -->
            <div class="mb-3 d-flex flex-wrap gap-2">

                <form action="{{ route('emaillog.index') }}" method="GET">
                    <input type="hidden" value="sent" name="keyword" id="">
                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                        Đã gửi <span class="badge bg-success ms-1">{{ $countSent }}</span>
                    </button>
                </form>

                <form action="{{ route('emaillog.index') }}" method="GET">
                    <input type="hidden" value="failed" name="keyword" id="">
                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                        Gửi thất bại <span class="badge bg-danger ms-1">{{ $countFailed }}</span>
                    </button>
                </form>
            </div>


            <input type="text" class="form-control mb-3"
                placeholder="Search for order ID, customer, order status or something...">

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tiêu đề</th>
                            <th>Trạng thái</th>
                            <th>Thời gian gửi</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $key => $log)
                            <tr>
                                <td>{{ $index + $key }}</td>
                                <td>{{ $log->subject }}</td>
                                <td>
                                    @if ($log->status === 'sent')
                                        <span class="badge bg-success">ĐÃ XUẤT BẢN</span>
                                    @elseif($log->status === 'failed')
                                        <span class="badge bg-danger">THẤT BẠI</span>
                                    @else
                                        <span class="badge bg-secondary">{{ strtoupper($log->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ \Carbon\Carbon::parse($log->created_at)->format('d/m/Y H:i') }}</td>
                                <td>
                                    <a href="{{ route('emaillog.show', $log->id) }}"
                                        class="btn btn-outline-primary btn-sm me-1">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <form action="{{ route('emaillog.destroy', $log->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Xóa log này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-outline-danger btn-sm">
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
                {{ $logs->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
