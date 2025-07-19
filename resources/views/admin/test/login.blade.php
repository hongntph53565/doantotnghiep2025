@extends('layouts.admin')

@section('content')
<div class="container mt-4">
    <div class="row">
        <!-- Form Đăng nhập -->
        <div class="col-md-6">
            <h4>Đăng nhập</h4>
            <form method="POST" action="{{ url('/login') }}">
                @csrf
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Mật khẩu" required>
                </div>
                <button type="submit" class="btn btn-primary">Đăng nhập</button>
            </form>
        </div>

        <!-- Form Đăng ký -->
        <div class="col-md-6">
            <h4>Đăng ký</h4>
<form method="POST" action="{{ url('/register') }}">
    @csrf
    <input type="text" name="username" placeholder="Tên đăng nhập" required>
    <input type="text" name="full_name" placeholder="Họ tên" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Mật khẩu" required>
    <input type="password" name="password_confirmation" placeholder="Nhập lại mật khẩu" required>
    <button type="submit">Đăng ký</button>
</form>

        </div>
    </div>
</div>

@endsection
