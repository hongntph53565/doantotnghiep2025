@extends('layouts.headerLogin')

@section('title', 'Đăng nhập / Đăng kí')

@push('styles')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Be+Vietnam+Pro:wght@400;500;600;700&display=swap');

        .form-section {
            font-family: 'Be Vietnam Pro', sans-serif;
        }

        .form-section h2 {
            font-weight: 700;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .form-section .form-label {
            font-weight: 500;
            font-size: 14px;
        }

        .form-section input.form-control,
        .form-section select.form-select {
            font-size: 14px;
            padding: 10px 12px;
            border-radius: 4px;
        }

        .form-section input::placeholder {
            color: #999;
        }

        .form-section .btn-green {
            background-color: #6cc24a;
            color: white;
            font-weight: 600;
            border: none;
            font-size: 15px;
            padding: 10px;
            border-radius: 6px;
        }

        .form-section .btn-green:hover {
            background-color: #5cb245;
        }

        .form-section .forgot-password {
            font-size: 13px;
            color: #6cc24a;
            text-decoration: none;
        }

        .form-section .forgot-password:hover {
            text-decoration: underline;
        }

        .form-section .form-check-label {
            font-size: 14px;
        }

        .form-section .form-check-input {
            margin-top: 6px;
        }
    </style>
@endpush

@section('content')
    <div class="form-section container mt-4 mb-5">

        <div class="row g-4 justify-content-between">
            <!-- Đăng nhập -->
            <div class="col-12 col-md-5 col-lg-4">
                <h2>ĐĂNG NHẬP TÀI KHOẢN</h2>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->login_error->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="loginEmail" class="form-label">Email *</label>
                        <input type="email" name="email" id="loginEmail" class="form-control"
                            placeholder="Tài khoản hoặc email" required>
                    </div>
                    <div class="mb-3">
                        <label for="loginPassword" class="form-label">Mật khẩu *</label>
                        <input type="password" name="password" id="loginPassword" class="form-control"
                            placeholder="Mật khẩu" required>
                    </div>
                    <a href="#" class="forgot-password">Quên mật khẩu?</a>
                    <button type="submit" class="btn btn-green w-100">ĐĂNG NHẬP</button>
                </form>
            </div>

            <!-- Đăng ký -->
            <div class="col-12 col-md-6 col-lg-7">
                <h2>ĐĂNG KÝ TÀI KHOẢN</h2>
                @if ($errors->register->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->register->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Họ *</label>
                            <input type="text" name="last_name" class="form-control" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tên đệm và tên *</label>
                            <input type="text" name="first_name" class="form-control" required />
                        </div>
                    </div>

                    <div class="row g-3 mb-3 align-items-center">
                        <div class="col-md-6">
                            <label class="form-label d-block">Giới tính *</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value="nam"
                                    id="genderNam" />
                                <label class="form-check-label" for="genderNam">Nam</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value="nu"
                                    id="genderNu" />
                                <label class="form-check-label" for="genderNu">Nữ</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="gender" value="khac"
                                    id="genderKhac" />
                                <label class="form-check-label" for="genderKhac">Khác</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" required />
                        </div>
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Mật khẩu *</label>
                            <input type="password" name="password" class="form-control" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nhập lại mật khẩu *</label>
                            <input type="password" name="password_confirmation" class="form-control" required />
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Số điện thoại *</label>
                        <input type="text" name="phone" class="form-control" required />
                    </div>

                    <div class="row g-3 mb-3">
                        <label class="form-label">Ngày sinh *</label>
                        <div class="col-4">
                            <select class="form-select" name="birth_day" required>
                                <option disabled selected>Chọn ngày</option>
                                @for ($i = 1; $i <= 31; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-4">
                            <select class="form-select" name="birth_month" required>
                                <option disabled selected>Chọn tháng</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="col-4">
                            <select class="form-select" name="birth_year" required>
                                <option disabled selected>Chọn năm</option>
                                @for ($i = now()->year; $i >= 1950; $i--)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tỉnh/Thành phố *</label>
                            <select name="province" id="province" class="form-select" required>
                                <option disabled selected>Chọn Tỉnh/Thành phố</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="agreeTerms" required />
                        <label class="form-check-label" for="agreeTerms">
                            Tôi đã đọc, hiểu và đồng ý với các điều khoản
                        </label>
                    </div>

                    <button type="submit" class="btn btn-green w-100">ĐĂNG KÝ</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/calendar.js') }}"></script>
    <script>
        const provinces = [
            "Hà Nội",
            "TP. Hồ Chí Minh",
            "Hải Phòng",
            "Đà Nẵng",
            "Cần Thơ",
            "Huế",
            "An Giang",
            "Bắc Ninh",
            "Cà Mau",
            "Cao Bằng",
            "Đắk Lắk",
            "Điện Biên",
            "Đồng Nai",
            "Đồng Tháp",
            "Gia Lai",
            "Hà Tĩnh",
            "Hưng Yên",
            "Khánh Hòa",
            "Lai Châu",
            "Lạng Sơn",
            "Lào Cai",
            "Lâm Đồng",
            "Nghệ An",
            "Ninh Bình",
            "Phú Thọ",
            "Quảng Ngãi",
            "Quảng Ninh",
            "Quảng Trị",
            "Sơn La",
            "Tây Ninh",
            "Thái Nguyên",
            "Thanh Hóa",
            "Tuyên Quang",
            "Vĩnh Long",
        ];



        document.addEventListener("DOMContentLoaded", function() {
            const select = document.getElementById("province");
            provinces.forEach(function(province) {
                const option = document.createElement("option");
                option.value = province;
                option.textContent = province;
                select.appendChild(option);
            });
        });
    </script>
@endpush
