@extends('layouts.app')

@section('title', 'Lịch Chiếu Phim')

@push('styles')
    <style>
        .movie-card {
            padding: 0 8px;
            margin-bottom: 20px;
        }

        .movie-img {
            position: relative;
            overflow: hidden;
            border-radius: 8px;
        }

        .movie-img img {
            width: 100%;
            height: auto;
            border-radius: 8px;
            display: block;
        }

        .buy-button {
            position: absolute;
            opacity: 0;
            transition: 0.3s ease;
            z-index: 2;
            text-decoration: none;
        }

        /* PLAY BUTTON */
        .play-button {
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
        }

        .play-button::before {
            content: '';
            width: 0;
            height: 0;
            border-left: 14px solid white;
            border-top: 8px solid transparent;
            border-bottom: 8px solid transparent;
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
            /* ✅ ép nằm cùng 1 dòng */
            text-decoration: none;
        }


        .buy-button img {
            width: 20px;
            height: 20px;
            margin-bottom: 2px;
        }

        .buy-button:hover {
            background-color: #72BE43;
        }

        .movie-img:hover .buy-button {
            opacity: 1;
        }

        .movie-title {
            color: #72BE43;
            font-weight: bold;
            font-size: 14px;
            margin: 6px 0 4px 0;
            text-align: left;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            cursor: pointer;
        }

        /* .movie-meta {
            font-size: 16px;
            color: #000;
            text-align: left;
        }

        .genre-name {
            color: #72BE43;
        } */

        /* .movie-tags {
                    display: flex;
                    justify-content: flex-start;
                    gap: 6px;
                    margin-top: 6px;
                    flex-wrap: wrap;
                }

                .movie-tags span {
                    font-size: 10px;
                    font-weight: bold;
                    text-transform: uppercase;
                    border-radius: 4px;
                    padding: 4px 6px;
                    display: inline-block;
                }

                .movie-tags .tag-red {
                    background-color: #e53935;
                    color: white;
                }

                .movie-tags .tag-black {
                    background-color: #000;
                    color: yellow;
                }

                .movie-tags .tag-green {
                    background-color: #4CAF50;
                    color: white;
                } */


        .review-section img {
            width: 100%;
            max-width: 1000px;
            display: block;
            margin: 20px auto;
            border-radius: 12px;
        }

        hr {
            border: none;
            border-top: 2px solid rgba(0, 0, 0, 0.2);
            margin: 0px 0;
        }

        .col-md-20p {
            flex: 0 0 auto;
            width: 20%;
        }



        .info {
            margin-top: 10px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            text-align: left;
        }

        .labels {
            margin-bottom: 5px;
        }

        .label {
            display: inline-block;
            font-size: 12px;
            padding: 3px 6px;
            margin-right: 4px;
            border-radius: 4px;
            color: #fff;
            font-weight: bold;
        }

        .label.age {
            background: linear-gradient(to bottom, #ff4d4d, #a00);
        }

        .label.subtitle {
            background: #000;
            border: 1px solid rgba(247, 232, 147, 0.795);
            font-weight: normal;
        }

        .label.type {
            background: linear-gradient(to bottom, #5fd26f, #2ca551);
        }

        .tag {
            font-weight: bold;
        }

        .tag.horror {
            color: #72BE43;
        }

        .tag.family {
            color: green;
        }

   .movie-img:hover {
    box-shadow:
        0 0 0 2px rgba(0, 0, 0, 0.6),        /* Viền đen sát hình */
        0 0 14px 5px rgba(114, 190, 67, 0.8);
}
    </style>
@endpush

@section('content')
    <div class="container">
        <hr>


        <div class="text-center">
            <div class="section-title">Phim Đang Chiếu</div>
        </div>
        <div class="row g-3">
            @foreach ($nowShowing as $movie)
                <div class="col-6 col-sm-4 col-md-2 movie-card">
                    <div class="movie-img">
                        <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}">
                        <a href="{{ route('Client.booking.home', ['movie_id' => $movie->movie_id, 'date' => now()->toDateString()]) }}"
                            class="buy-button">
                            MUA VÉ NGAY
                            <img src="{{ asset('images/ticket-svgrepo-com.svg') }}" alt="vé" width="16" class="ms-1">
                        </a>
                    </div>
                    {{-- <div class="movie-tags">
                        <span class="tag-red">{{ $movie->age_rating ?? 'P' }}</span>
                        <span class="tag-black">{{ $movie->language ?? 'Phụ đề' }}</span>
                        <span class="tag-green">{{ $movie->format ?? '2D' }}</span>
                    </div>
                    <div class="movie-title" title="{{ $movie->title }}">{{ $movie->title }}</div>

                    <div class="movie-meta">
                        Thể loại: <span class="genre-name">{{ $movie->genre->genre_name ?? 'Không rõ' }}</span>
                    </div> --}}

                    <div class="info">
                        <div class="labels">
                            <span class="label age">{{ $movie->age_rating }}</span>
                            <span class="label subtitle">{{ $movie->language }}</span>
                            <span class="label type">{{ $movie->format }}</span>
                        </div>
                        <h4 class="movie-title" title="{{ $movie->title }}">{{ $movie->title }}</h4>
                        <p>Thể loại phim: <span class="tag horror">{{ $movie->genre->genre_name ?? 'Không rõ' }}</span></p>
                    </div>
                </div>
            @endforeach
        </div>


        <div class="text-center">
            <div class="section-title mt-5">Phim Sắp Chiếu</div>
        </div>
        <div class="row g-3">
            @foreach ($comingSoon as $movie)
                <div class="col-6 col-sm-4 col-md-20p movie-card">
                    <div class="movie-img">
                        <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}">
                        <a href="#" class="buy-button">
                            MUA VÉ NGAY
                            <img src="{{ asset('images/ticket-svgrepo-com.svg') }}" alt="vé" width="16" class="ms-1">
                        </a>
                    </div>

                    <div class="info">
                        <div class="labels">
                            <span class="label age">{{ $movie->age_rating }}</span>
                            <span class="label subtitle">{{ $movie->language }}</span>
                            <span class="label type">{{ $movie->format }}</span>
                        </div>
                        <h4 class="movie-title" title="{{ $movie->title }}">{{ $movie->title }}</h4>
                        <p>Thể loại phim: <span class="tag horror">{{ $movie->genre->genre_name ?? 'Không rõ' }}</span></p>
                    </div>

                </div>
            @endforeach

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