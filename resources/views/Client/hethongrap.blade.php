@extends('layouts.app')

@section('title', 'Hệ Thống Rạp')
@push('styles')
    <link rel="stylesheet" href="{{ asset('css/hethongrap.css') }}">
@endpush

@section('content')
        <div class="container text-center">
            <h3 class="theater-title">Hệ thống rạp</h3>
        </div>
        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <div class="col">
                    <div class="theater-card">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Lumi Star The Garden">
                        <div class="theater-name">Lumi Star The Garden</div>
                        <button class="btn-theater-detail" onclick="window.location.href='{{ url('/thong-tin-rap') }}'">
                            THÔNG TIN CHI TIẾT
                        </button>

                    </div>
                </div>
                <div class="col">
                    <div class="theater-card">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Lumi Star The Garden">
                        <div class="theater-name">Lumi Star The Garden</div>
                        <button class="btn-theater-detail" onclick="window.location.href='{{ url('/thong-tin-rap') }}'">
                            THÔNG TIN CHI TIẾT
                        </button>
                    </div>
                </div>
                <div class="col">
                    <div class="theater-card">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Lumi Star The Garden">
                        <div class="theater-name">Lumi Star The Garden</div>
                        <button class="btn-theater-detail" onclick="window.location.href='{{ url('/thong-tin-rap') }}'">
                            THÔNG TIN CHI TIẾT
                        </button>
                    </div>
                </div>
                <div class="col">
                    <div class="theater-card">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Lumi Star The Garden">
                        <div class="theater-name">Lumi Star The Garden</div>
                        <button class="btn-theater-detail" onclick="window.location.href='{{ url('/thong-tin-rap') }}'">
                            THÔNG TIN CHI TIẾT
                        </button>
                    </div>
                </div>
                <div class="col">
                    <div class="theater-card">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Lumi Star The Garden">
                        <div class="theater-name">Lumi Star The Garden</div>
                        <a href="{{ url('/thong-tin-rap') }}" class="btn-theater-detail">THÔNG TIN CHI TIẾT</a>
                    </div>
                </div>
                <div class="col">
                    <div class="theater-card">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Lumi Star The Garden">
                        <div class="theater-name">Lumi Star The Garden</div>
                        <button class="btn-theater-detail" onclick="window.location.href='{{ url('/thong-tin-rap') }}'">
                            THÔNG TIN CHI TIẾT
                        </button>
                    </div>
                </div>
                <div class="col">
                    <div class="theater-card">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Lumi Star The Garden">
                        <div class="theater-name">Lumi Star The Garden</div>
                        <button class="btn-theater-detail" onclick="window.location.href='{{ url('/thong-tin-rap') }}'">
                            THÔNG TIN CHI TIẾT
                        </button>
                    </div>
                </div>
                <div class="col">
                    <div class="theater-card">
                        <img src="{{ asset('images/logo.jpg') }}" alt="Lumi Star The Garden">
                        <div class="theater-name">Lumi Star The Garden</div>
                        <button class="btn-theater-detail" onclick="window.location.href='{{ url('/thong-tin-rap') }}'">
                            THÔNG TIN CHI TIẾT
                        </button>
                    </div>
                </div>

            </div>
        </div>
@endsection
