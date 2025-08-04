@if ($movie->showtimes->isNotEmpty())
    <!-- Thông tin rạp -->
    <div class="d-flex align-items-center mb-3">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo"
            style="width: 50px; height: 50px; margin-right: 10px;" class="rounded-circle">
        <div>
            <p class="fw-bold mb-1">{{ $cinema->name ?? 'Rạp chưa xác định' }}</p>
            <p class="text-muted small mb-0">
                {{ $cinema->address_detail ?? '' }},
                {{ $cinema->ward ?? '' }},
                {{ $cinema->district ?? '' }},
                {{ $cinema->city ?? '' }}
            </p>
        </div>
    </div>

    <!-- Các suất chiếu -->
    <div class="d-flex gap-3 flex-wrap">
        @foreach ($movie->showtimes->sortBy('start_time') as $showtime)
            <div class="text-center mb-2">
                <a
                    href="{{ route('staff.booking.seats', ['movie' => $movie->movie_id, 'showtime' => $showtime->showtime_id, 'room_id' => $showtime->room_id ]) }}">
                    <div class="text-white px-4 py-2 rounded-2"
                        style="background-color: #3f4765; min-width: 120px;">
                        <div class="fw-semibold fs-6">
                            {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}
                        </div>
                    </div>
                </a>
                <div class="mt-2 d-flex justify-content-center gap-2">
                    <span class="badge text-white border border-warning bg-black px-2 py-1" style="font-size: 0.6rem;">PHỤ ĐỀ</span>
                    <span class="badge bg-success px-2 py-1" style="font-size: 0.6rem;">2D</span>
                </div>
            </div>
        @endforeach
    </div>
@else
    <p>Không có suất chiếu nào ngày {{ \Carbon\Carbon::parse(request()->input('date'))->format('d/m/Y') }}</p>

@endif
