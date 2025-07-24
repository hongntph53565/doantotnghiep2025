@extends('layouts.app')

@section('title', 'Thanh toán ZaloPay')

@section('content')
<div class="text-center mt-5">
    <h2>Quét mã QR ZaloPay để thanh toán</h2>
    <img src="{{ $qr_url }}" alt="ZaloPay QR" style="width: 300px; height: 300px;">
    <p>Mã đơn: {{ $booking_code }}</p>
    <p>Số tiền: {{ number_format($amount) }} VND</p>
    <p>Vui lòng quét mã và chờ kết quả xử lý!</p>
</div>
@endsection
