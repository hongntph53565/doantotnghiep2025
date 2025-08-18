@extends('layouts.headerLogin')
@section('title', 'Đổi mật khẩu')


@push('styles')
    <style>
           hr {
            border: none;
            border-top: 2px solid rgba(0, 0, 0, 0.2);
            margin: 20px 0;
        }
    </style>
@endpush
@section('content')
<hr>
<h2 class="text-center mb-3">Đổi mật khẩu</h2>

{{-- Thông báo thành công --}}
@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

{{-- Thông báo lỗi --}}
@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('reset.password.post') }}" method="post" class="mx-auto" style="max-width: 400px;">
    @csrf
    <input type="hidden" name="email" value="{{ $email }}">

    <div class="mb-3">
        <input type="password" name="password" class="form-control" placeholder="Mật khẩu mới" required>
        @error('password')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <div class="mb-3">
        <input type="password" name="password_confirmation" class="form-control" placeholder="Nhập lại mật khẩu mới" required>
        @error('password_confirmation')
            <small class="text-danger">{{ $message }}</small>
        @enderror
    </div>

    <button type="submit" class="btn btn-success w-100 fw-bold">ĐỔI MẬT KHẨU</button>
</form>
@endsection
<br>
