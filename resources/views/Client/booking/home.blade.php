@extends('layouts.headerBooking')
@section('title', 'Đặt vé')

@push('scripts')
    <script src="{{ asset('js/calendar.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/movie_details.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chonghe.css') }}">
    <link rel="stylesheet" href="{{ asset('css/chondoan.css') }}">
    <link rel="stylesheet" href="{{ asset('css/thanhtoan.css') }}">
@endpush


@section('content')

    <div class="container mt-4">
        <h1 id="step-title" class="entry-title text-center text-dark mb-4">
            Bước 1: Chọn thời gian và địa điểm
        </h1>
        <div class="cinema-box">
            <img src="{{ asset('images/1.jpg') }}" alt="DORAEMON: NOBITA'S ART WORLD TALES" />
            <div>
                <h6>DORAEMON: NOBITA'S ART WORLD TALES</h6>
                <p class="mb-1 cinema-info">
                    Thế giới trong lễ các châu Âu thú trung cổ được mở ra từ trong các bức tranh. Doraemon và những người
                    bạn của mình nhảy vào "thế giới của bức tranh" cùng với Claire và những người bạn của cô là Milo và Chài
                    khi họ bắt đầu một cuộc phiêu lưu tuyệt vời.
                </p>
                <p class="mb-1 cinema-info"><strong>Phân loại:</strong> <span class="tag">P</span> Phim phổ biến với mọi
                    độ
                    tuổi</p>
                <p class="mb-1 cinema-info"><strong>Định dạng:</strong> <span class="tag">2D</span></p>
                <p class="mb-1 cinema-info"><strong>Đạo diễn:</strong> Yukiyo Teramoto</p>
                <p class="mb-1 cinema-info"><strong>Diễn viên:</strong> Megumi Ohara, Wasabi Mizuta</p>
                <p class="mb-1 cinema-info"><strong>Thể loại:</strong> Family</p>
                <p class="mb-1 cinema-info"><strong>Khởi chiếu:</strong> 23/05/2025 | Thời lượng: 105 phút</p>
                <p class="mb-1 cinema-info"><strong>Ngôn ngữ:</strong> Phụ đề/Lồng tiếng</p>
            </div>
        </div>
    </div>

    <div class="container mt-4">
        <div id="booking-steps">
            <div class="booking-step" id="step-0">@include('Client.booking.steps.select_showtime')</div>
            <div class="booking-step" id="step-1" style="display: none;">@include('Client.booking.steps.select-seat')</div>
            <div class="booking-step" id="step-2" style="display: none;">@include('Client.booking.steps.select-combo')</div>
            <div class="booking-step" id="step-3" style="display: none;">@include('Client.booking.steps.payment')</div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        function goToStep(step) {
            document.querySelectorAll('.booking-step').forEach(el => el.style.display = 'none');
            document.querySelectorAll('.steps .step').forEach((el, index) => {
                el.classList.toggle('active', index === step);
            });
            const currentStep = document.getElementById(`step-${step}`);
            if (currentStep) currentStep.style.display = 'block';

            const titles = [
                "Bước 1: Chọn thời gian và địa điểm",
                "Bước 2: Chọn ghế",
                "Bước 3: Chọn combo",
                "Bước 4: Thanh toán"
            ];
            const titleEl = document.getElementById('step-title');
            if (titleEl) titleEl.textContent = titles[step] || "";

            localStorage.setItem('currentStep', step);
        }
         function goBackStep() {
        const current = parseInt(localStorage.getItem('currentStep')) || 0;
        if (current > 0) {
            goToStep(current - 1);
        }
    }

        // document.addEventListener('DOMContentLoaded', () => {
        //     const savedStep = parseInt(localStorage.getItem('currentStep')) || 0;
        //     goToStep(savedStep);
        // });
    </script>
@endpush
