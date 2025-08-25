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
                <p class="mb-1 cinema-info"><strong>Thể loại:</strong><span>
                        {{ $movie->genre->genre_name ?? 'Không rõ' }}</span></p>
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
                @if (session('error'))
                    <div class="alert alert-danger" id="seat-error-alert">
                        {{ session('error') }}
                    </div>

                    <script>
                        setTimeout(() => {
                            const alertBox = document.getElementById('seat-error-alert');
                            if (alertBox) {
                                alertBox.style.display = 'none';
                            }
                        }, 5000);
                    </script>
                @endif

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
    <script>
    const showtimeId = "{{ $selectedShowtimeId }}";


function updateSeatImages(statuses) {
    const removedSeats = []; 

    document.querySelectorAll('img[data-seat-id]').forEach(img => {
        const seatId = parseInt(img.getAttribute('data-seat-id'));
        const status = statuses[seatId] || 'available';
        const type = img.dataset.type;

        if (status === 'booked' || status === 'pending') {
            let wasSelected = false;

            if (type === 'couple') {
                const coupleKey = `couple-${img.dataset.coupleId}`;
                if (selectedSeats.has(coupleKey)) {
                    const coupleSeat = selectedSeats.get(coupleKey);
                    selectedSeats.delete(coupleKey);
                    wasSelected = true;

                   
                    if (coupleSeat?.codes?.length) {
                        removedSeats.push(coupleSeat.codes.join('-'));
                    }
                }
            } else {
                if (selectedSeats.has(img.dataset.seatCode)) {
                    selectedSeats.delete(img.dataset.seatCode);
                    wasSelected = true;
                    removedSeats.push(img.dataset.seatCode);
                }
            }
        }

        
        const isSelected = Array.from(selectedSeats.values()).some(seat => {
            if (seat.type === 'couple') {
                return seat.seat_ids?.includes(seatId);
            }
            return seat.seat_id === seatId;
        });

        let imgPath;
        if (status === 'booked' || status === 'pending') {
            imgPath = 'seat-booked.svg';
        } else if (isSelected) {
            imgPath = 'seat-selected.svg';
        } else {
            imgPath = {
                'standard': 'seat-standard-available.svg',
                'vip': 'seat-vip-available.svg',
                'couple': 'seat-couple-available.svg'
            }[type] || 'seat-standard-available.svg';
        }

        const newSrc = `/images/${imgPath}`;
        if (!img.src.includes(imgPath)) {
            img.src = newSrc;
        }

        img.dataset.status = status;
    });

    updateSummary();

    if (removedSeats.length > 0) {
        showSeatError(
            `Có người đã nhanh hơn bạn . Ghế ${removedSeats.join(', ')} đã được đặt, vui lòng chọn ghế khác giúp sốp nha ^^.`
        );
    }
}

function showSeatError(message) {
    let alertBox = document.getElementById('seat-error-alert');

    if (!alertBox) {
        alertBox = document.createElement('div');
        alertBox.id = 'seat-error-alert';
        alertBox.className = 'alert alert-danger';
        document.querySelector('#step-1').insertAdjacentElement('afterbegin', alertBox);
    }

    alertBox.textContent = message;
    alertBox.style.display = 'block';

    setTimeout(() => {
        if (alertBox) {
            alertBox.style.display = 'none';
        }
    }, 5000);
}




    function fetchSeatStatuses() {
        fetch(`/ajax/showtime/${showtimeId}/seats-status`)
            .then(res => res.json())
            .then(updateSeatImages)
            .catch(console.error);
    }

    setInterval(fetchSeatStatuses, 5000); 
</script>

@endpush
