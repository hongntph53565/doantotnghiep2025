<div class="container mb-5">
    <div class="row">
        <div class="col-md-9">
            <div class="schedule-box">
                @if ($showtimes->isEmpty())
                    <div class="alert alert-warning text-center">
                        Không có lịch chiếu nào ngày
                        {{ request('date') ? \Carbon\Carbon::parse(request('date'))->format('d/m/Y') : 'này' }}
                    </div>
                @else
                    @foreach ($showtimes as $cinemaId => $cinemaShowtimes)
                        @php
                            $firstShowtime = $cinemaShowtimes->first();
                            $cinema = $firstShowtime && $firstShowtime->room ? $firstShowtime->room->cinema : null;
                        @endphp

                        @if ($cinema && $selectedCity && strpos(strtolower($cinema->city), strtolower($selectedCity)) === false)
                            @continue
                        @endif


                        <img src="{{ asset('images/logo.jpg') }}" alt="Logo rạp" width="60" class="me-3"
                            style="object-fit: contain;">
                        <div>
                            <h6 class="fw-bold mb-1">{{ $cinema->name }}</h6>
                            <p class="text-muted mb-0">{{ $cinema->address_detail }}</p>
                        </div>

                        <div class="d-flex flex-wrap">
                            @foreach ($cinemaShowtimes as $showtime)
                                <div class="showtime-card text-center p-2 border rounded shadow-sm me-2 mb-3">
                                    <button type="button" class="showtime-btn d-block mx-auto mb-1"
                                        data-showtime-id="{{ $showtime->showtime_id }}">
                                        {{ \Carbon\Carbon::parse($showtime->start_time)->format('H:i') }}
                                    </button>

                                    <div class="tag small">{{ $movie->language ?? 'Phụ đề' }}</div>
                                    <div class="tag green small mt-1">{{ $movie->format ?? '2D' }}</div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                @endif
            </div>
        </div>

        <div class="col-md-3 mt-3 mt-md-0">
            <div class="datepicker-wrapper">
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

    
    <script>
        const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};
        const loginUrl = "{{ route('register.form') }}"; 

        document.addEventListener('DOMContentLoaded', function() {
            const showtimeButtons = document.querySelectorAll('.showtime-btn');

            showtimeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (!isLoggedIn) {
                        alert("Vui lòng đăng nhập để tiếp tục đặt vé.");
                        window.location.href = loginUrl;
                        return;
                    }

                    const showtimeId = this.dataset.showtimeId;
                    sessionStorage.setItem('selectedShowtimeId', showtimeId);

                    goToStep(1);
                });
            });

            
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('showtime_id')) {
                goToStep(1);
            }
        });

        const movieIdGlobal = {{ $movie->movie_id }};
    </script>
</div>
