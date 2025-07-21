@extends('layouts.app')

@section('title', 'Lịch Chiếu Phim')
@section('content')
    <div class="container py-4">

        <div class="text-center">
            <div class="section-title">NOW SHOWING / SNEAK SHOW</div>
        </div>
        <div class="row g-3">
            @for ($i = 0; $i < 11; $i++)
                <div class="col-6 col-sm-4 col-md-2 movie-card">
                    <img src="{{ asset('images\1.jpg') }}" alt="Lilo & Stitch" width="200">
                    <div class="movie-title">LILO & STITCH</div>
                    <div class="movie-meta">Thể loại: phiêu lưu</div>
                    <div class="movie-tags d-flex justify-content-center mt-1">
                        <span class="bg-primary text-white">2D</span>
                        <span class="bg-danger text-white">P</span>
                        <span class="bg-success text-white">90p</span>
                    </div>
                </div>
            @endfor
        </div>

        {{-- COMING SOON --}}
        <div class="text-center">
            <div class="section-title mt-5">COMING SOON</div>
        </div>
        <div class="row g-3">
            @for ($i = 0; $i < 11; $i++)
                <div class="col-6 col-sm-4 col-md-2 movie-card">
                    <img src="{{ asset('images\2.jpg') }}" alt="Lilo & Stitch" width="200">
                    <div class="movie-title">LILO & STITCH</div>
                    <div class="movie-meta">Thể loại: phiêu lưu</div>
                    <div class="movie-tags d-flex justify-content-center mt-1">
                        <span class="bg-primary text-white">2D</span>
                        <span class="bg-danger text-white">P</span>
                        <span class="bg-success text-white">90p</span>
                    </div>
                </div>
            @endfor
        </div>

        <div class="text-center">
            <div class="section-title mt-5">TIN NỔI BẬT LUMISTAR</div>
        </div>
        <div class="review-section">
            <img src="{{ asset('images\cong-tu-bac-lieu-1-1728987515-8367-1728987588.jpg') }}"
                alt="Review Công Tử Bạc Liêu">
        </div>

    </div>
@endsection
