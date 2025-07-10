@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/css/chair.css') }}">
@endpush

@section('content')
                <div class="card border-0 shadow-sm mt-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold">Sơ đồ ghế</h6>


                    </div>
                    <div class="main-wrapper">
                        <!-- Cột trái: sơ đồ ghế -->
                        <div class="flex-grow-1">
                            <div class="screen">MÀN HÌNH CHIẾU</div>

                            <div class="seat-map">

                                <!-- Hàng A -->
                                <div class="seat-row mb-2">
                                    <span class="seat">A1</span><span class="seat">A2</span><span
                                        class="seat">A3</span><span class="seat">A4</span>
                                    <span class="seat">A5</span><span class="seat">A6</span><span
                                        class="seat">A7</span><span class="seat">A8</span>
                                    <span class="seat">A9</span><span class="seat">A10</span>
                                </div>

                                <!-- Hàng B -->
                                <div class="seat-row mb-2">
                                    <span class="seat">B1</span><span class="seat">B2</span><span
                                        class="seat">B3</span><span class="seat vip">B4</span>
                                    <span class="seat vip">B5</span><span class="seat vip">B6</span><span
                                        class="seat vip">B7</span><span class="seat">B8</span>
                                    <span class="seat">B9</span><span class="seat">B10</span>
                                </div>

                                <!-- Hàng C -->
                                <div class="seat-row mb-2">
                                    <span class="seat">C1</span><span class="seat">C2</span><span
                                        class="seat">C3</span><span class="seat vip">C4</span>
                                    <span class="seat vip">C5</span><span class="seat vip">C6</span><span
                                        class="seat vip">C7</span><span class="seat">C8</span>
                                    <span class="seat">C9</span><span class="seat">C10</span>
                                </div>

                                <!-- Hàng D -->
                                <div class="seat-row mb-2">
                                    <span class="seat">D1</span><span class="seat">D2</span><span
                                        class="seat">D3</span><span class="seat vip">D4</span>
                                    <span class="seat vip">D5</span><span class="seat vip">D6</span><span
                                        class="seat vip">D7</span><span class="seat">D8</span>
                                    <span class="seat">D9</span><span class="seat">D10</span>
                                </div>

                                <!-- Hàng E -->
                                <div class="seat-row mb-2">
                                    <span class="seat">E1</span><span class="seat">E2</span><span
                                        class="seat">E3</span><span class="seat">E4</span>
                                    <span class="seat">E5</span><span class="seat">E6</span><span
                                        class="seat">E7</span><span class="seat">E8</span>
                                    <span class="seat">E9</span><span class="seat">E10</span>
                                </div>

                                <!-- Hàng F - ghế đôi VIP -->
                                <div class="seat-row mb-2">
                                    <span class="seat double vip">F1</span>
                                    <span class="seat double vip">F2</span>
                                    <span class="seat double vip">F3</span>
                                </div>

                            </div>
                        </div>

                        <!-- Cột phải -->
                        <div class="right-box">
                            <!-- Trạng thái -->
                            <div class="info-box">
                                <p><strong>Trạng Thái:</strong> Đã xuất bản</p>
                                <p><strong>Hoạt động:</strong> <input type="checkbox" checked /></p>
                                <a href="list_rooms.html" class="btn btn-primary w-100 mb-2">Danh sách</a>
                                <a href="duong-dan-den-cap-nhat.html" class="btn btn-outline-primary w-100">Cập nhật</a>

                            </div>

                            <!-- Ghi chú -->
                            <div class="info-box">
                                <h6 class="fw-bold">Chú Thích</h6>
                                <div class="legend-item"><span class="seat"></span> Ghế Thường</div>
                                <div class="legend-item"><span class="seat vip"></span> Ghế VIP</div>
                                <div class="legend-item"><span class="seat double"></span> Ghế Đôi</div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
@endsection