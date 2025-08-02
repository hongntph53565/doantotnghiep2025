@extends('layouts.app')

@section('title', 'Hệ Thống Rạp')
@push('styles')
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/infoCinema.css') }}">
@endpush

@section('content')
<div class="topbar">
    
    <div class="container py-5">
         <hr>
       
        <div class="row g-4">
            <!-- Thông tin rạp -->
            <div class="col-md-8">
               <div class="card shadow-sm border-0 p-4">
    <h5 class="text-success fw-bold">{{ $cinema->name }}</h5>
    <p><strong>{{ strtoupper($cinema->name) }}</strong><br>
        • Địa điểm: {{ $cinema->address_detail }}<br>
        • Số điện thoại: {{ $cinema->phone ?? 'Chưa cập nhật' }}<br>
        • Email: {{ $cinema->email ?? 'Chưa cập nhật' }}<br>
        • Phòng chiếu: {{ $cinema->rooms->count() }} 
    </p>
</div>

                <!-- Bảng giá vé thường -->
                <div class="card shadow-sm border-0 p-3 mt-4">
                    <img src="{{ asset('images\The-Garden.jpg') }}" alt="Bảng giá vé thường" class="img-fluid rounded shadow-sm">
                </div>

                <!-- Quy định -->
<div class="card shadow-sm border-0 p-4 mt-4">
    <h6 class="fw-bold">CÁC QUY ĐỊNH GIÁ VÉ</h6>
    <ul class="list-unstyled small mt-3 mb-0">
        <li>– Giá vé trẻ em áp dụng cho trẻ em có chiều cao dưới 1,3m. Yêu cầu trẻ em có mặt khi mua vé. Trẻ em dưới 0,7m sẽ được miễn phí vé khi mua cùng 01 vé người lớn đi kèm theo. Không áp dụng kèm với chương trình khuyến mãi ưu đãi về giá vé khác.</li>
        <li>– Giá vé U22 áp dụng cho khách hàng dưới 22 tuổi, với quy định sau:<br>
            &nbsp;&nbsp;+ Khách U22 có thẻ thành viên được mua 2 vé/ngày giá ưu đãi từ 48.000đ, giảm 10% bắp nước và tích điểm đổi quà.<br>
            &nbsp;&nbsp;+ Khách U22 chưa có thẻ vẫn mua 1 vé U22/ngày khi xuất trình VNEID, thẻ HSSV hoặc mặc đồng phục học sinh.
        </li>
        <li>– Ngày lễ: 1/1, Giỗ Tổ Hùng Vương (10/3 Âm Lịch), 30/4, 1/5, 02 ngày Lễ Quốc Khánh.</li>
        <li>– Giá vé Tết Âm Lịch sẽ được áp dụng riêng.</li>
        <li>– Suất chiếu đặc biệt áp dụng giá vé theo khung giờ của ngày. Không áp dụng các giá vé ưu đãi dành cho Privilege Voucher/Staff Voucher, Happy Day. Trong trường hợp suất chiếu đặc biệt trùng với Happy Day (Thứ 3), sẽ áp dụng giá vé của Thứ 3.</li>
    </ul>
</div>
            </div>

            <!-- Địa điểm khác -->
           <div class="col-md-4">
    <div class="card shadow-sm border-0 p-4 h-100 other-cinemas">
        <h6 class="fw-bold text-center mb-3">Địa điểm khác</h6>
        <ul class="list-unstyled mb-0">
            @foreach ($otherCinemas as $other)
                <li>
                    <a href="{{ route('Client.infoCinema', ['cinema_id' => $other->cinema_id]) }}" class="text-decoration-none">
                        {{ $other->name }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>

        </div>
    </div>
    </div>



@endsection
