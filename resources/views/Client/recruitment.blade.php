@extends('layouts.app')

@section('title', 'Thông báo quan trọng')

@push('styles')
    <style>
        .banner-summer {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .filter-buttons {
            margin: 20px auto;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
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

        .filter-buttons .btn:hover {
            background-color: #70d137;
            color: white;
        }

        .notice-content {
            max-width: 900px;
            margin: 40px auto;
            padding: 20px;
        }

        .notice-content h4 {
            font-weight: bold;
            margin-bottom: 20px;
        }

        .notice-content ul {
            list-style: disc;
            padding-left: 20px;
            text-align: left;
        }

        .footer-section {
            background-color: #111;
            color: #fff;
            padding: 40px 20px;
        }

        .footer-section h5 {
            color: #70d137;
            margin-bottom: 10px;
        }

        .footer-section ul {
            list-style: none;
            padding-left: 0;
        }

        .footer-section ul li {
            margin-bottom: 6px;
        }

        .footer-social {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .footer-social img {
            width: 32px;
            height: 32px;
        }

       .filter-buttons .btn.active {
            background-color: #70d137;
            color: white;
        }
    </style>
@endpush

@section('content')

    <!-- Bộ lọc -->
    <div class="filter-buttons">
    <a class="btn active" href="{{ route('important.notice') }}" class="btn active">Thông báo quan trọng</a>
    <a href="{{ route('Client.faq') }}" class="btn">FAQ</a>
</div>


    <!-- Nội dung thông báo -->
    <div class="notice-content text-center">
        <h4>Thông báo quan trọng</h4>
        <ul>
            <li>Tất cả các thông tin tuyển dụng của <strong>LumiStar</strong> sẽ được đăng trên các kênh truyền thông
                <strong>websites, fanpage</strong> của công ty và các trang việc làm uy tín tại Việt Nam. Các ứng viên không
                phải trả bất kỳ khoản phí nào để nộp đơn ứng tuyển.</li>
            <li>Tất cả các thông tin ứng tuyển chỉ gửi về một email chính thức và duy nhất của công ty tại: <a
                    href="mailto:Recruitment-HCM@bhdstar.vn">cskh@lumistar.vn</a>. Nếu các bạn phát hiện bất kỳ thông tin sai
                lệch nào khác, xin vui lòng báo về cho LumiStar theo email trên.</li>
        </ul>
    </div>

@endsection
