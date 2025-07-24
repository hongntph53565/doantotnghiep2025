@if ($showtimes->isEmpty())
    <div class="alert alert-warning text-center">
        Không có lịch chiếu nào ngày {{ \Carbon\Carbon::parse(request('date'))->format('d/m/Y') }}
    </div>
@else
    @foreach ($showtimes as $cinemaId => $cinemaShowtimes)
        @php
            $cinema = $cinemaShowtimes->first()->room->cinema;
        @endphp

        <div class="d-flex align-items-start mb-2">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo rạp" width="60" class="me-3" style="object-fit: contain;">
            <div>
                <h6 class="fw-bold mb-1">{{ $cinema->name }}</h6>
                <p class="text-muted mb-0">{{ $cinema->address_detail }}</p>
            </div>
        </div>

        <div class="d-flex flex-wrap">
            @foreach ($cinemaShowtimes as $showtime)
                <div class="me-3 mb-3 text-center">
                    <button
                        type="button"
                        class="showtime-btn"
                        data-showtime-id="{{ $showtime->showtime_id }}">
                        {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}
                    </button>
                    <div class="tag">{{ $movie->language ?? 'Phụ đề' }}</div>
                    <div class="tag green">{{ $movie->format ?? '' }}</div>
                </div>
            @endforeach
        </div>
    @endforeach
@endif
