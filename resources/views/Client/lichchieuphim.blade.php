@extends('layouts.app')

@section('title', 'Lịch Chiếu Phim')

@push('styles')
<style>
    .movie-img {
        position: relative;
        overflow: hidden;
        border-radius: 8px;
    }

    .movie-img img {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 8px;
    }

    /* BUY BUTTON */
    .buy-button {
        position: absolute;
        bottom: 15px;
        left: 50%;
        transform: translateX(-50%);
        background-color: #a3dfb4;
        color: white;
        font-weight: bold;
        font-size: 15px;
        text-transform: uppercase;
        padding: 12px 24px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        opacity: 0;
        transition: 0.3s;
        cursor: pointer;
        white-space: nowrap;
        text-decoration: none;
        z-index: 2;
    }

    .buy-button img {
        width: 20px;
        height: 20px;
        margin-bottom: 2px;
    }

    .buy-button:hover {
        background-color: #72BE43;
    }

    /* PLAY BUTTON */
    .play-button {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 50px;
        height: 50px;
        border-radius: 50%;
        border: 3px solid white;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: 0.3s ease;
        z-index: 2;
        cursor: pointer;
    }

    .play-button::before {
        content: '';
        width: 0;
        height: 0;
        border-left: 14px solid white;
        border-top: 8px solid transparent;
        border-bottom: 8px solid transparent;
    }

    /* HOVER HIỆN NÚT */
    .movie-img:hover .play-button,
    .movie-img:hover .buy-button {
        opacity: 1;
    }

    /* Movie info */
    .movie-title {
        font-weight: bold;
        text-align: center;
        margin-top: 6px;
    }

    .movie-meta {
        text-align: center;
        font-size: 14px;
        color: #555;
    }

    .movie-tags span {
        font-size: 12px;
        padding: 2px 6px;
        margin: 0 2px;
        border-radius: 12px;
    }

    .review-section img {
        width: 100%;
        max-width: 1000px;
        display: block;
        margin: 20px auto;
        border-radius: 12px;
    }
</style>
@endpush


@section('content')
    <div class="container py-4">

        <div class="text-center">
            <div class="section-title">NOW SHOWING / SNEAK SHOW</div>
        </div>
        <div class="row g-3">
            @for ($i = 0; $i < 11; $i++)
                <div class="col-6 col-sm-4 col-md-2 movie-card">
                    <div class="movie-img">
                        <img src="{{ asset('images/1.jpg') }}" alt="Lilo & Stitch">
                        <a href="{{ url('/dat-ve') }}" class="buy-button">
                            MUA VÉ NGAY
                            <img src="{{ asset('images/ticket-svgrepo-com.svg') }}" alt="vé" width="16" class="ms-1">
                        </a>
                    </div>
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
                    <div class="movie-img">
                        <img src="{{ asset('images/2.jpg') }}" alt="Lilo & Stitch">
                        <a href="{{ url('/dat-ve') }}" class="buy-button">
                            MUA VÉ NGAY
                            <img src="{{ asset('images/ticket-svgrepo-com.svg') }}" alt="vé" width="16" class="ms-1">
                        </a>
                    </div>
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
            <img src="{{ asset('images/cong-tu-bac-lieu-1-1728987515-8367-1728987588.jpg') }}"
                alt="Review Công Tử Bạc Liêu">
        </div>

    </div>
@endsection
