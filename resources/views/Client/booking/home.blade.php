@extends('layouts.headerBooking')
@section('title', 'LumiStar - Đặt vé')

@push('scripts')
    <script src="{{ asset('js/calendar.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/MovieDetails.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ChooseSeat.css') }}">
    <link rel="stylesheet" href="{{ asset('css/ChooseFood.css') }}">
    <link rel="stylesheet" href="{{ asset('css/Payment.css') }}">
@endpush


@section('content')

    <div class="container mt-4">
        <h1 id="step-title" class="entry-title text-center text-dark mb-4">
            Bước 1: Chọn thời gian và địa điểm
        </h1>
        <div class="cinema-box">
            <img src="{{ asset('storage/' . $movie->poster) }}" alt="{{ $movie->title }}" width="200" />
            <div>
                <h6 class="movie-title">{{ $movie->title }}</h6>
                <p class="mb-1 cinema-info">{{ $movie->description }}</p>


                <p class="mb-1 cinema-info"><strong>Đạo diễn:</strong><span> {{ $movie->director ?? '' }}</span></p>
                <p class="mb-1 cinema-info"><strong>Diễn viên:</strong><span> {{ $movie->cast ?? '' }}</span></p>
                <p class="mb-1 cinema-info"><strong>Thể loại:</strong><span>  {{ $movie->genre->genre_name ?? 'Không rõ' }}</span></p>
                <p class="mb-1 cinema-info"><strong>Khởi chiếu:</strong>
                    {{ \Carbon\Carbon::parse($movie->release_date)->format('d/m/Y') }} |
                    <strong>Thời lượng:</strong> {{ $movie->duration }} phút
                </p>
                {{-- <p class="mb-1 cinema-info"><strong>Ngôn ngữ:</strong> {{ $movie->language ?? 'Không rõ' }}</p> --}}

                <button class="btn btn-outline-success btn-sm mt-1" onclick="clearSessionAndGoHome()">
                    → CHỌN PHIM KHÁC
                </button>

            </div>
        </div>

    </div>

    <div class="container mt-4">
        <div id="booking-steps">
            <div class="booking-step" id="step-0" style="display: {{ $step === 0 ? 'block' : 'none' }}">
                @include('Client.booking.steps.select_showtime')
            </div>

            <div class="booking-step" id="step-1" style="display: {{ $step === 1 ? 'block' : 'none' }}">
                @include('Client.booking.steps.select-seat')
            </div>

            <div class="booking-step" id="step-2" style="display: none;">
                @include('Client.booking.steps.select-combo')
            </div>
            <div class="booking-step" id="step-3" style="display: none;">
                @include('Client.booking.steps.payment')
            </div>
        </div>


    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/calendar.js') }}"></script>

    <script>
        function clearSessionAndGoHome() {
            sessionStorage.clear();
            window.history.back();
            // window.location.href = '{{ route('home') }}';
        }
    </script>
@endpush
