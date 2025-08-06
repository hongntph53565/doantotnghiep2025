@extends('layouts.app')

@section('title', 'Hệ Thống Rạp')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/CinemaSystem.css') }}">
@endpush

@section('content')

    <div class="container text-center">
        <hr>
        <h3 class="theater-title">Hệ thống rạp</h3>
    </div>

    <div class="container">
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @foreach ($cinemas as $cinema)
                <div class="col">
                    <div class="theater-card">
                        <img src="{{ asset('images/logo.jpg') }}" alt="{{ $cinema->name }}">
                        <div class="theater-name">{{ $cinema->name }}</div>
                        <button class="btn-theater-detail"
                            onclick="window.location.href='{{ url('/thong-tin-rap/' . $cinema->cinema_id) }}'">
                            THÔNG TIN CHI TIẾT
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    <br>
@endsection
