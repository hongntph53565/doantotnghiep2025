@extends('layouts.admin')

@section('title2')
    Quản lý người dùng
@endsection

@section('title1')
    Tài khoản
@endsection

@section('title')
    Tài khoản
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Chỉnh sửa người dùng</h3>
                    </div>
                    <form action="{{ route('users.update', $user->user_id) }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Họ và tên</label>
                                        <input type="text" name="full_name" class="form-control"
                                            value="{{ $user->full_name }}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Account name</label>
                                        <input type="text" name="username" class="form-control"
                                            value="{{ $user->username }}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Số điện thoại</label>
                                        <input type="text" name="phone" class="form-control"
                                            value="{{ $user->phone }}" readonly>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ $user->email }}" readonly>
                                    </div>
                                </div>

                            </div>

                            {{-- <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Mật khẩu mới</label>
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Để trống nếu không đổi">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Xác nhận mật khẩu</label>
                                        <input type="password" name="password_confirmation" class="form-control"
                                            placeholder="Xác nhận mật khẩu mới">
                                    </div>
                                </div>
                            </div> --}}

                            <div class="form-group">
                                <label>Vai trò</label>
                                <select class="form-control @error('role_id') is-invalid @enderror" name="role_id"
                                    id="roleSelect">
                                    <option value="">-- Chọn vai trò --</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->role_id }}" data-role="{{ $role->role_id }}"
                                            {{ old('role_id', $user->role_id) == $role->role_id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            {{-- Chỉ định rạp --}}
                            <div class="form-group" id="cinemaSelectBox" style="display: none;">
                                <label>Chỉ định rạp</label>
                                <select class="form-control @error('cinema_id') is-invalid @enderror" name="cinema_id">
                                    <option value="">-- Chọn rạp --</option>
                                    @foreach ($cinemas as $cinema)
                                        <option value="{{ $cinema->cinema_id }}"
                                            {{ old('cinema_id', $cinemaId ?? null) == $cinema->cinema_id ? 'selected' : '' }}>
                                            {{ $cinema->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('cinema_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>



                            {{-- <div class="form-group">
                                <div class="custom-control custom-switch">
                                    <input type="checkbox" class="custom-control-input" id="activeSwitch" name="status"
                                        value="1" {{ old('status', $user->status) == "active" ? 'checked' : '' }}>

                                    <label class="custom-control-label" for="activeSwitch">Kích hoạt tài khoản</label>
                                </div>
                            </div> --}}
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <a href="{{ route('users.index') }}" class="btn btn-default float-right">Hủy bỏ</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/plugins/select2/css/select2.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script>
        $(function() {
            
            $('.select2').select2({
                theme: 'bootstrap4'
            });

           
            $('form').submit(function() {
                return confirm('Bạn có chắc chắn muốn cập nhật thông tin người dùng này?');
            });
        });
    </script>
    <script>
        function toggleCinemaSelect() {
            let roleValue = document.getElementById('roleSelect').value;
            let cinemaBox = document.getElementById('cinemaSelectBox');
            if (roleValue == 2 || roleValue == 3) {
                cinemaBox.style.display = 'block';
            } else {
                cinemaBox.style.display = 'none';
            }
        }

        
        document.getElementById('roleSelect').addEventListener('change', toggleCinemaSelect);
        toggleCinemaSelect();
    </script>
@endpush
