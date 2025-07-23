@extends('layouts.staff')

@section('title', 'Đồ ăn - Combo')

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')
@foreach ($foods as $food)
<div class="slider-container">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <!-- Slide 1 -->
                <div class="swiper-slide">
                    <div class="movie-box">

                        <div class="movie-img">
                            <img src="{{ $food->image }}" alt="Út Lan">
                            <!-- Nút play - dẫn đến trailer -->

                            <!-- Nút mua vé -->
                           <a href="{{ route('foods.show', $food->food_id) }}" class="buy-button">
                                XEM NGAY

                            </a>

                        </div>
                        <div class="info">
                            <h4 style="color: #5B9836">{{ $food->name }}</h4>
                            <p>{{ $food->description }}</p>
                            <h4>{{ number_format($food->price, 0, ',', '.') }} VNĐ</h4>
                        </div>
                    </div>
                </div>

@endforeach


@endsection
