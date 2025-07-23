@extends('layouts.staff')
@section('title', 'Đặt vé')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/movie_details.css') }}">
@endpush


@section('content')

    <section class="combo-detail">
  <div class="combo-wrapper">
    <!-- Cột trái: Ảnh -->
    <div class="combo-image">
      <img src="{{ $food->image }}" alt="Combo chính">
    </div>

    <!-- Cột phải: Thông tin -->
    <div class="combo-info">
      <h1>{{ $food->name }}</h1>
      <p>{{ $food->description }}</p>

      <div class="price-row">
        <span>Giá bán</span>
        <span class="strike">{{ number_format($food->price, 0, ',', '.') }} VNĐ</span>
      </div>


      <div class="quantity-control">
        <span>Số lượng</span>
        <div class="quantity-box">
          <button>-</button>
          <input type="number" value="0" min="0" />
          <button>+</button>
        </div>
      </div>

      <div class="total-row">
        <span>Tổng tiền</span>
        <span>0 VND</span>
      </div>

      <div class="actions">
        <button class="add-cart">THÊM VÀO GIỎ</button>
        <button class="buy">MUA NGAY</button>
      </div>
    </div>
  </div>
</section>

@endsection
