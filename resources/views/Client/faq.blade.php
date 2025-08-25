@extends('layouts.app')

@section('title', 'FAQ')

@push('styles')
<style>
    .filter-buttons {
        margin: 20px auto;
        display: flex;
        justify-content: center;
        gap: 10px;
    }

    .filter-buttons .btn {
        border: 1px solid #70d137;
        background-color: white;
        color: #70d137;
        padding: 8px 16px;
        border-radius: 5px;
        transition: all 0.3s;
    }

    .filter-buttons .btn.active,
    .faq-buttons .btn.active {
        background-color: #70d137;
        color: white;
    }

    .filter-buttons .btn:hover,
    .faq-buttons .btn:hover {
        background-color: #70d137;
        color: white;
    }

    .faq-title {
        text-align: center;
        font-size: 28px;
        font-weight: bold;
        margin-bottom: 30px;
        transition: all 0.3s;
    }

    .faq-section {
        max-width: 1100px;
        margin: 0 auto 60px auto;
        padding: 20px;
        display: flex;
        gap: 30px;
        align-items: flex-start;
    }

    .faq-buttons {
        display: flex;
        flex-direction: column;
        gap: 10px;
        width: 350px;
        min-width: 250px;
    }

    .faq-buttons .btn {
        border: 1px solid #70d137;
        background-color: white;
        color: #70d137;
        border-radius: 8px;
        padding: 12px;
        font-weight: bold;
        cursor: pointer;
        transition: 0.3s;
    }

    .faq-answer {
        flex: 1;
        border: 1px solid #ddd;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        font-size: 16px;
    }
</style>
@endpush

@section('content')
    <!-- Điều hướng -->
    <div class="filter-buttons">
        <a href="{{ route('important.notice') }}" class="btn">Thông báo quan trọng</a>
        <a href="{{ route('Client.faq') }}" class="btn active">FAQ</a>
    </div>

    <!-- Tiêu đề động -->
    <div class="faq-title" id="faq-title-text">CÓ PHỎNG VẤN TIẾNG ANH KHÔNG?</div>

    <!-- Khu vực chính -->
    <div class="faq-section">
        <!-- Các câu hỏi -->
        <div class="faq-buttons">
            <button class="btn active" onclick="showAnswer(0)">CÓ PHỎNG VẤN TIẾNG ANH KHÔNG?</button>
            <button class="btn" onclick="showAnswer(1)">KHUNG THỜI GIAN LÀM VIỆC?</button>
            <button class="btn" onclick="showAnswer(2)">DƯỚI 18 TUỔI CÓ XIN VIỆC ĐƯỢC KHÔNG?</button>
        </div>

        <!-- Câu trả lời -->
        <div id="faq-answer" class="faq-answer">
            Khả năng giao tiếp ngoại ngữ là cần thiết tại môi trường làm việc của LumiStar. Do đó nếu bạn có biết ngoại ngữ sẽ là một lợi thế lớn của bạn. Đừng ngại thể hiện nhé!
        </div>
    </div>

    <script>
        const questions = [
            "CÓ PHỎNG VẤN TIẾNG ANH KHÔNG?",
            "KHUNG THỜI GIAN LÀM VIỆC?",
            "DƯỚI 18 TUỔI CÓ XIN VIỆC ĐƯỢC KHÔNG?"
        ];

        const answers = [
            `Khả năng giao tiếp ngoại ngữ là cần thiết tại môi trường làm việc của LumiStar. Do đó nếu bạn có biết ngoại ngữ sẽ là một lợi thế lớn của bạn. Đừng ngại thể hiện nhé!`,
            `Tùy vào vị trí và cụm rạp, khung giờ làm việc có thể linh hoạt (theo ca hoặc theo ngày).`,
            `Theo quy định Luật Lao Động hiện hành của Việt Nam, LumiStar chỉ tuyển dụng với các bạn đủ và trên 18 tuổi, cần có các giấy tờ tùy thân.`
        ];

        function showAnswer(index) {
            document.getElementById("faq-answer").innerText = answers[index];
            document.getElementById("faq-title-text").innerText = questions[index];

            // Reset trạng thái active
            document.querySelectorAll('.faq-buttons .btn').forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.faq-buttons .btn')[index].classList.add('active');
        }
    </script>
@endsection
