@extends('layouts.staff')

@section('title', 'Staff')


@section('content')

    <div class="container">
        <form method="GET" action="{{ route('staff.list') }}" class="mb-4">
            <br>
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Tìm kiếm tên phim..."
                    value="{{ request('search') }}">
                <button class="btn btn-danger" type="submit">Tìm</button>
            </div>
        </form>
        <button class="btn1">PHIM ĐANG CHIẾU</button>
        <div class="slider-container d-flex flex-wrap justify-content-center gap-3">
            @forelse ($nowShowing as $movie)
                <div class="movie-box">
                    <div class="movie-img">
                        <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}">

                        {{-- @if (!empty($movie->trailer))
                            <a href="javascript:void(0);" class="play-button" onclick="openTrailer(this)"
                                data-trailer="{{ $movie->trailer }}"></a>
                        @endif --}}

                        <a href="{{ route('staff.booking1', $movie->movie_id) }}" class="buy-button">
                            ĐẶT VÉ
                            <img src="{{ asset('images/ticket-svgrepo-com.svg') }}" alt="vé">
                        </a>
                    </div>

                    <div class="info">
                        <div class="labels">
                            <span class="label age">{{ $movie->age_rating }}</span>
                            <span class="label subtitle">{{ $movie->language ?? 'PHỤ ĐỀ' }}</span>
                            <span class="label type">{{ $movie->format ?? '2D' }}</span>
                        </div>
                        <h4 title="{{ $movie->title }}">{{ $movie->title }}</h4>
                        <p>Thể loại: <span class="tag horror">{{ $movie->genre->genre_name ?? 'Không rõ' }}</span></p>
                    </div>
                </div>
            @empty
                <p class="alert alert-warning text-center mt-4 form-control p-3">
                    Không có phim {{ $search }} trong phim đang chiếu.
                </p>
            @endforelse

          
        </div>


        <button class="btn1">PHIM SẮP CHIẾU</button>
        <div class="slider-container d-flex flex-wrap justify-content-center gap-3">
            @forelse ($comingSoon as $movie)
                <div class="movie-box">
                    <div class="movie-img">
                        <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}">

                         @if (!empty($movie->trailer))
                            <a href="javascript:void(0);" class="play-button" onclick="openTrailer(this)"
                                data-trailer="{{ $movie->trailer }}"></a>
                        @endif 

                        <a href="{{ route('staff.booking1', $movie->movie_id) }}" class="buy-button">
                            ĐẶT VÉ
                            <img src="{{ asset('images/ticket-svgrepo-com.svg') }}" alt="vé">
                        </a>
                    </div>

                    <div class="info">
                        <div class="labels">
                            <span class="label age">{{ $movie->age_rating }}</span>
                            <span class="label subtitle">{{ $movie->language ?? 'PHỤ ĐỀ' }}</span>
                            <span class="label type">{{ $movie->format ?? '2D' }}</span>
                        </div>
                        <h4 title="{{ $movie->title }}">{{ $movie->title }}</h4>
                        <p>Thể loại: <span class="tag horror">{{ $movie->genre->genre_name ?? 'Không rõ' }}</span></p>
                    </div>
                </div>
            @empty
                <p class="alert alert-warning text-center mt-4 form-control p-3">
                    Không có phim {{ $search }} trong phim đang chiếu.
                </p>
            @endforelse

            {{ $comingSoon->appends(['search' => $search, 'soon_page' => $comingSoon->currentPage()])->links('pagination::bootstrap-4') }}
        </div>
        
    </div>
@endsection
@push('styles')
    <style>
        .btn1 {
            background-color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            margin: 50px auto;
            margin-bottom: 50px;
            display: block;
            color: #63be2c;
            border: 1px solid #63be2c;
            font-size: 18px;
        }

        .slider-container {
            max-width: 1400px;
            margin: auto;
            gap: 25px !important;
            justify-content: flex-start !important;
        }

        .movie-box {
            width: calc(20% - 20px);
            display: flex;
            flex-direction: column;
        }

        .movie-img {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            transition: box-shadow 0.3s ease;
        }

        .movie-img:hover {
            box-shadow: 0 6px 12px #99ce78;
        }

        .movie-img img {
            width: 100%;
            height: 340px;
            object-fit: cover;
            border-radius: 10px;
        }

        .play-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50px;
            height: 50px;
            border: 3px solid #fff;
            border-radius: 50%;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .play-button::before {
            content: '';
            width: 0;
            height: 0;
            border-left: 14px solid #fff;
            border-top: 8px solid transparent;
            border-bottom: 8px solid transparent;
        }

        .buy-button {
            position: absolute;
            bottom: 12px;
            left: 50%;
            transform: translateX(-50%);
            background: #a3dfb4;
            color: white;
            font-weight: bold;
            padding: 10px 16px;
            font-size: 14px;
            border-radius: 8px;
            display: none;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }

        .buy-button img {
            width: 18px;
            height: 18px;
        }

        .buy-button:hover {
            background-color: #72BE43;
        }


        .movie-img:hover .play-button,
        .movie-img:hover .buy-button {
            display: flex;
        }

        .info {
            margin-top: 10px;
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
            background: #a00;
        }

        .label.subtitle {
            background: #000;
        }

        .label.type {
            background: #0a0;
        }

        .tag {
            font-weight: bold;
        }

        .tag.horror {
            color: red;
        }

        .tag.family {
            color: green;
        }

        h4 {
            font-size: 15px;
            margin: 5px 0;
            font-weight: bold;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        p {
            font-size: 14px;
            margin: 0;
        }
    </style>
@endpush
@push('scripts')
@endpush