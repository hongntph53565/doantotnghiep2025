@extends('layouts.app')

@section('title', 'Lịch Chiếu Rạp')
@push('styles')
<link rel="stylesheet" href="{{ asset('css/MovieShowtimesByCinema.css') }}">
@endpush

@section('content')
<div class="lich-chieu-rap-wrapper">
    <div class="container py-4">
        <h3 class="text-center mb-4">Chi tiết rạp {{ $cinema->name }}</h3>

        <div class="cinema-box" style="max-width: 6000px;">
            <img style="width: 150px; height: 180px;" src="{{ asset('images/logo.jpg') }}" alt="{{ $cinema->name }}" />
            <div>
                <h6>{{ $cinema->name }}</h6>
                <p class="mb-1 cinema-info">{{ $cinema->full_address }}</p>
                <p class="mb-1 cinema-info">Điện thoại: {{ $cinema->phone ?? 'Chưa cập nhật' }}</p>
                <p class="mb-1 cinema-info">Email: {{ $cinema->email ?? 'Chưa cập nhật' }}</p>
                 <p class="mb-1 cinema-info">Địa chỉ: {{ $cinema->address_detail ?? 'Chưa cập nhật' }}</p>
                {{-- <p class="mb-1 cinema-info">Trạng thái: {{ $cinema->status === 'active' ? 'Hoạt động' : 'Ngừng hoạt động' }}</p> --}}
                <a href="{{ route('Client.cinemaShowtime') }}" class="btn btn-outline-success btn-sm mt-2">← Quay lại danh sách</a>
            </div>
        </div>

        <div class="schedule-section">
            <div class="schedule-box">
                @if ($showtimes->isEmpty())
                    <div class="alert alert-warning text-center">
                        Không có lịch chiếu nào ngày {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}
                    </div>
                @else
                    @foreach ($showtimes as $movieId => $movieShowtimes)
                        @php $firstShowtime = $movieShowtimes->first(); @endphp
                        <div class="d-flex flex-wrap mb-4">
                           

                               <div class="d-flex align-items-start mb-2">
                            <img src="{{ asset('images/logo.jpg') }}" alt="Logo rạp" width="60" class="me-3"
                                style="object-fit: contain;">
                            <div>
                                 <h6 class="fw-bold w-100">{{ $firstShowtime->movie->title }}</h6>
                            <p class="text-muted mb-3 w-100">{{ $cinema->name }}</p>
                            </div>
                        </div>

                            @foreach ($movieShowtimes as $showtime)
                                <div class="me-3 mb-3 text-center">
                                    <a href="{{ route('Client.booking.home', ['movie_id' => $showtime->movie->movie_id]) }}?showtime_id={{ $showtime->showtime_id }}" class="showtime-btn d-block mx-auto mb-1">
    {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}
</a>

                                    <div class="tag">{{ $showtime->movie->language ?? 'Phụ đề' }}</div>
                                    <div class="tag green">2D</div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                @endif
            </div>

            <div class="datepicker">
                <div class="datepicker-inner">
                    <div class="datepicker-header">
                        <div class="arrow" onclick="changeMonth(-1)">&#x276E;</div>
                        <div class="month-labels">
                            <div class="month-text" id="month-label"></div>
                            <div id="month-picker" class="month-picker hidden"></div>
                            <div id="year-picker" class="year-picker hidden"></div>
                            <div class="year-text" id="year-label"></div>
                        </div>
                        <div class="arrow" onclick="changeMonth(1)">&#x276F;</div>
                    </div>
                    <div class="day-names">
                        <div class="day-name">2</div>
                        <div class="day-name">3</div>
                        <div class="day-name">4</div>
                        <div class="day-name">5</div>
                        <div class="day-name">6</div>
                        <div class="day-name">7</div>
                        <div class="day-name">CN</div>
                    </div>
                    <div class="days" id="datepicker-days"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')

<script>
    window.calendarMode = "cinema";
    window.cinemaIdGlobal = "{{ $cinema->cinema_id }}";
</script>
<script src="{{ asset('js/calendar.js') }}"></script>
@endpush
