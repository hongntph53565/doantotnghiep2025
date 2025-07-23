@extends('layouts.staff')

@section('title', 'Phim đang chiếu tại rạp')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/staff_now_showing.css') }}">
@endpush

@section('content')
    <div class="container py-4">
        <h2 class="text-center mb-4">🎬 Danh sách phim sắp chiếu</h2>

   <form method="GET" action="{{ route('staff.comingSoon') }}" class="search-form d-flex justify-content-center my-4">
    <div class="input-group w-50 shadow">
        <input
            type="text"
            name="keyword"
            class="form-control search-input"
            placeholder="🔍 Tìm kiếm phim sắp chiếu..."
            value="{{ request('keyword') }}"
        >
        <button class="btn btn-search px-4" type="submit">
            🔍 Tìm
        </button>
    </div>
</form>



        <div class="row g-4">
            @forelse ($comingSoon as $movie)
                <div class="col-6 col-md-3 movie-card text-center">
                    <div class="poster-wrapper position-relative">
                        <img src="{{ $movie->poster }}" alt="{{ $movie->title }}" class="img-fluid w-100 poster-img">
                    </div>

                    <div class="movie-title mt-2 fw-bold">{{ $movie->title }}</div>
                    <div class="movie-meta text-muted small">
                        Thể loại: {{ $movie->genre->name ?? 'Đang cập nhật' }}
                    </div>
                    <div class="movie-tags d-flex justify-content-center mt-1 gap-2 flex-wrap">
                        <span class="badge bg-primary">{{ $movie->format }}</span>
                        <span class="badge bg-danger">{{ $movie->age_rating }}</span>
                        <span class="badge bg-success">{{ $movie->duration }}p</span>
                    </div>
                </div>
            @empty
                <p class="text-center">Không có phim sắp chiếu.</p>
            @endforelse
        </div>

        {{-- PHÂN TRANG --}}
        <div class="mt-4 d-flex justify-content-center">
            {{ $comingSoon->appends(['keyword' => request('keyword')])->links() }}

        </div>
    </div>
@endsection
