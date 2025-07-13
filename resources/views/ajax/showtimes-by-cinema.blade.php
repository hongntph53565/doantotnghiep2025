@if ($showtimes->isEmpty())
    <div class="alert alert-warning text-center">
        Không có lịch chiếu nào ngày {{ request()->input('date') }}
    </div>
@else
    @foreach ($showtimes as $movieId => $movieShowtimes)
        @php
            $firstShowtime = $movieShowtimes->first();
            $cinema = $firstShowtime->room->cinema ?? null;
        @endphp

        <div class="mb-4">
            @if ($cinema)
                <div class="d-flex align-items-start mb-2">
                    <img src="{{ asset('images/logo.jpg') }}" alt="Logo rạp" width="60" class="me-3"
                        style="object-fit: contain;">
                    <div>
                        <h6 class="text-muted mt-2">{{ $firstShowtime->movie->title }}</h6>
                        <h7 class="text-muted mb-2">{{ $cinema->name }}</h7>
                    </div>
                </div>
            @endif


            <div class="d-flex flex-wrap">
                @foreach ($movieShowtimes as $showtime)
                    <div class="me-3 mb-3 text-center">
                        <form action="{{ route('Client.booking.home', ['movie_id' => $showtime->movie->movie_id]) }}"
                            method="GET" style="display: inline;">
                            <input type="hidden" name="showtime_id" value="{{ $showtime->showtime_id }}">
                            <button type="submit" class="showtime-btn d-block mx-auto mb-1">
                                {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}
                            </button>
                        </form>

                        <div class="tag">{{ $showtime->movie->language ?? 'Phụ đề' }}</div>
                        <div class="tag green">{{ $showtime->movie->format ?? '2D' }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
@endif
