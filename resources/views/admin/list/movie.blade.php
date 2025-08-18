@extends('layouts.admin')

@section('content')
    <div class="card border-0 shadow-sm mt-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="fw-bold">Danh sách phim</h6>
                <a href="{{ route('movies.create') }}" class="btn btn-success">
                    <i class="bi bi-plus-circle me-1"></i> Thêm phim
                </a>
            </div>

            <form action="{{ route('movies.index') }}" method="GET" class="d-flex mb-3">
                <input type="text" name="keyword" class="form-control me-2" placeholder="Tìm theo tên phim..."
                       value="{{ request('keyword') }}">
                <a href="{{ route('movies.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-clockwise"></i>
                </a>
            </form>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tiêu đề</th>
                            <th>Thể loại</th>
                            <th>Đạo diễn</th>
                            <th>Ngày phát hành</th>
                            <th>Ngày kết thúc</th>
                            <th>Trạng thái</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($movies as $movie)
                            <tr>
                                <td>{{ $index++ }}</td>
                                <td>{{ $movie->title }}</td>
                                <td>{{ $movie->genre->genre_name ?? 'Chưa rõ' }}</td>
                                <td>{{ $movie->director }}</td>
                                <td>{{ \Carbon\Carbon::parse($movie->release_date)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($movie->end_date)->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $movie->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ $movie->status == 'active' ? 'Hiển thị' : 'Ẩn' }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('movies.edit', $movie->movie_id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-pencil-fill"></i>
                                    </a>
                                    <a href="{{ route('movies.show', $movie->movie_id) }}" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-eye-fill"></i>
                                    </a>
                                    <form action="{{ route('movies.destroy', $movie->movie_id) }}" method="POST" style="display:inline"
                                          onsubmit="return confirm('Bạn có chắc muốn xoá phim này?')">
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
                {{ $movies->withQueryString()->links() }}
            </div>
        </div>
    </div>
@endsection
