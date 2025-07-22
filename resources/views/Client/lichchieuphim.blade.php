@extends('layouts.app')

@section('title', 'Lịch Chiếu Phim')

@section('content')
<div class="container py-4">

    {{-- NOW SHOWING --}}
    <div class="text-center">
        <div class="section-title">NOW SHOWING / SNEAK SHOW</div>
    </div>
    <div class="row g-3">
        @forelse ($nowShowing as $movie)
            <div class="col-6 col-md-3 movie-card text-center">
                <img src="{{ $movie->poster }}" alt="{{ $movie->title }}" 
                     class="img-fluid" style="height: 400px; object-fit: cover;">
                <div class="movie-title mt-2 fw-bold">{{ $movie->title }}</div>
                <div class="movie-meta">Thể loại: {{ $movie->genre->name ?? 'Đang cập nhật' }}</div>
                <div class="movie-tags d-flex justify-content-center mt-1 gap-1">
                    <span class="badge bg-primary">{{ $movie->format }}</span>
                    <span class="badge bg-danger">{{ $movie->age_rating }}</span>
                    <span class="badge bg-success">{{ $movie->duration }}p</span>
                </div>
            </div>
        @empty
            <p class="text-center">Không có phim đang chiếu.</p>
        @endforelse
    </div>

    {{-- PHÂN TRANG NOW SHOWING --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $nowShowing->appends(['soon_page' => request('soon_page')])->links() }}
    </div>

    {{-- COMING SOON --}}
    <div class="text-center mt-5">
        <div class="section-title">COMING SOON</div>
    </div>
    <div class="row g-3">
        @forelse ($comingSoon as $movie)
            <div class="col-6 col-md-3 movie-card text-center">
                <img src="{{ $movie->poster }}" alt="{{ $movie->title }}" 
                     class="img-fluid" style="height: 300px; object-fit: cover;">
                <div class="movie-title mt-2 fw-bold">{{ $movie->title }}</div>
                <div class="movie-meta">Thể loại: {{ $movie->genre->name ?? 'Đang cập nhật' }}</div>
                <div class="movie-tags d-flex justify-content-center mt-1 gap-1">
                    <span class="badge bg-primary">{{ $movie->format }}</span>
                    <span class="badge bg-danger">{{ $movie->age_rating }}</span>
                    <span class="badge bg-success">{{ $movie->duration }}p</span>
                </div>
            </div>
        @empty
            <p class="text-center">Không có phim sắp chiếu.</p>
        @endforelse
    </div>

    {{-- PHÂN TRANG COMING SOON --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $comingSoon->appends(['now_page' => request('now_page')])->links() }}
    </div>

    {{-- REVIEW --}}
    <div class="text-center mt-5">
        <div class="section-title">TIN NỔI BẬT LUMISTAR</div>
    </div>
    <div class="review-section text-center">
        <img src="{{ asset('images/cong-tu-bac-lieu-1-1728987515-8367-1728987588.jpg') }}"
            alt="Review Công Tử Bạc Liêu" class="img-fluid">
    </div>

</div>
@endsection
