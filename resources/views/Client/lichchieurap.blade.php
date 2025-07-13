@extends('layouts.app')

@section('title', 'Lịch Chiếu Phim')

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600&display=swap');

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

        .buy-button {
            /* giữ nguyên như cũ */
        }

        .play-button {
            /* giữ nguyên như cũ */
        }

        .movie-img:hover .play-button,
        .movie-img:hover .buy-button {
            opacity: 1;
        }

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


        .text-center .section-title {
            margin-bottom: 20px;
        }

        /* Bỏ gạch chân tên rạp, đổi màu khi hover */
        .cinema-name {
            color: #000;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .cinema-name p {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            letter-spacing: 0.5px;
            font-size: 16px;
            margin-top: 6px;
        }

        .cinema-name:hover {
            color: #72BE43;
        }

        hr {
            border: none;
            border-top: 2px solid rgba(0, 0, 0, 0.2);
            margin: 20px 0;
        }
    </style>
@endpush


@section('content')
    <div class="container py-4">
        <hr>

        <div class="container py-4">
            <h3 class="text-center mb-4">Danh sách rạp chiếu</h3>
            <div class="row justify-content-center">
                @foreach ($cinemas as $cinema)
                    <div class="col-md-4 text-center mb-3">
                        <a href="{{ route('Client.lichchieuphimtheorap', $cinema->cinema_id) }}" class="cinema-name d-block">
                            <img style="max-width: 220px; width: 100%; height: auto;" src="{{ asset('images/logo.jpg') }}"
                                class="img-fluid rounded" alt="{{ $cinema->name }}">
                            <p class="mt-2">{{ $cinema->name }}</p>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>

        <hr>
        <div class="text-center">
            <div class="section-title mt-5">TIN NỔI BẬT LUMISTAR</div>
        </div>
        <div class="review-section">
            <img src="{{ asset('images/cong-tu-bac-lieu-1-1728987515-8367-1728987588.jpg') }}"
                alt="Review Công Tử Bạc Liêu">
        </div>

    </div>
@endsection
