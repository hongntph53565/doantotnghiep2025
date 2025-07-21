<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Đăng nhập & Đăng ký</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <div class="container">
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
                    <input type="text" name="last_name" class="form-control" value="{{ old('last_name') }}" required />
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tên đệm và tên *</label>
                    <input type="text" name="first_name" class="form-control" value="{{ old('first_name') }}" required />
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
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required />
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
                        <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required />
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

    <!-- JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/login.js') }}"></script>
</body>

</html>
