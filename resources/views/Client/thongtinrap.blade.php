@extends('layouts.app')

@section('title', 'Hệ Thống Rạp')
@push('styles')
    <link rel="stylesheet" href="{{ asset('client/css/thongtinrap.css') }}">
@endpush

@section('content')
<div class="topbar">
    <div class="container py-5">
        <div class="row g-4">
            <!-- Thông tin rạp -->
            <div class="col-md-8">
                <div class="card shadow-sm border-0 p-4">
                    <h5 class="text-success fw-bold">BHD Star 3.2</h5>
                    <p><strong>BHD STAR 3/2</strong><br>
                        • Địa điểm: Tầng 5, Vincom Plaza 3/2, 3C Đường 3 Tháng 2, P.11, Quận 10, TPHCM<br>
                        • Số điện thoại: 1900 2099 hoặc gọi 028 6264 5821<br>
                        • Email: cskh@bhdstar.vn<br>
                        • Phòng chiếu: 5 phòng chiếu 2D & 3D
                    </p>
                </div>

                <!-- Bảng giá vé thường -->
                <div class="card shadow-sm border-0 p-3 mt-4">
                    <h6 class="fw-bold mb-3">BẢNG GIÁ VÉ THƯỜNG</h6>
                    <img src="{{ asset('images\Screenshot 2025-06-10 163452.png') }}" alt="Bảng giá vé thường" class="img-fluid rounded shadow-sm">
                </div>

                <!-- Bảng giá vé ngày lễ -->
                <div class="card shadow-sm border-0 p-3 mt-4">
                    <h6 class="fw-bold mb-3">BẢNG GIÁ VÉ NGÀY LỄ</h6>
                    <img src="{{ asset('images\Screenshot 2025-06-10 163505.png') }}" alt="Bảng giá vé ngày lễ" class="img-fluid rounded shadow-sm">
                </div>
                <!-- Quy định -->
                <div class="card shadow-sm border-0 p-4 mt-4">
                    <h6 class="fw-bold">CÁC QUY ĐỊNH GIÁ VÉ</h6>
                    <ul class="list-unstyled small mt-3 mb-0">
                        <li>- Giá vé trẻ em áp dụng cho trẻ em có chiều cao dưới 1.3m...</li>
                        <li>- Trẻ em dưới 0.7m được miễn phí khi đi kèm với người lớn...</li>
                        <li>- Vé U22 áp dụng cho thành viên dưới 22 tuổi...</li>
                        <li>- Các ngày lễ: 1/1, Giỗ Tổ Hùng Vương, 30/4, 1/5, 2/9...</li>
                        <li>- Giá vé Tết Âm Lịch báo riêng.</li>
                        <li>- Suất chiếu đặc biệt không áp dụng khuyến mãi.</li>
                    </ul>
                </div>
            </div>

            <!-- Địa điểm khác -->
            <div class="col-md-4">
                <div class="card shadow-sm border-0 p-4 h-100">
                    <h6 class="fw-bold text-center mb-3">Địa điểm khác</h6>
                    <ul class="list-unstyled mb-0">
                      <li><strong class="text-success">BHD Star 3.2</strong></li>
                       <li><strong class="text-success">BHD Star 3.2</strong></li>
                        <li><strong class="text-success">BHD Star 3.2</strong></li>
                        <li><strong class="text-success">BHD Star 3.2</strong></li>
                      <li><strong class="text-success">BHD Star 3.2</strong></li>
                        <li><strong class="text-success">BHD Star 3.2</strong></li>
                        <li><strong class="text-success">BHD Star 3.2</strong></li>
                      <li><strong class="text-success">BHD Star 3.2</strong></li>
                       <li><strong class="text-success">BHD Star 3.2</strong></li>
                        <li><strong class="text-success">BHD Star 3.2</strong></li>
                        <li><strong class="text-success">BHD Star 3.2</strong></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    </div>



@endsection
