@extends('layouts.headerLogin')
@section('title', 'Quên mật khẩu')

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
<h2 class="text-center mb-3">Quên mật khẩu</h2>

<form action="{{ route('forgot.password.post') }}" method="POST" class="mx-auto" style="max-width: 400px;">
    @csrf
    <div class="mb-3">
        <input type="email" name="email" class="form-control" placeholder="Nhập email của bạn" required>
        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
    </div>
    <button type="submit" class="btn btn-success w-100 fw-bold">Tiếp tục</button> 
</form>
@endsection
<br>
