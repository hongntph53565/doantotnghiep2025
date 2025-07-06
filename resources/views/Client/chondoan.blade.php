@extends('layouts.headerBooking')
@section('title', 'Chọn đồ ăn')

@push('scripts')
    <script src="{{ asset('js/calendar.js') }}"></script>
@endpush

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/chondoan.css') }}">
@endpush

@section('content')

    {{-- THÔNG TIN PHIM --}}
    <div class="container mt-4">
        <h1 class="entry-title text-center">Bước 3: Chọn đồ ăn</h1>
      <div class="cinema-box">
            <img src="{{ asset('images/1.jpg') }}" alt="DORAEMON: NOBITA'S ART WORLD TALES" />
            <div>
                <h6>DORAEMON: NOBITA'S ART WORLD TALES</h6>
                <p class="mb-1 cinema-info">
                    Thế giới trong lễ các châu Âu thú trung cổ được mở ra từ trong các bức tranh. Doraemon và những người
                    bạn của mình nhảy vào "thế giới của bức tranh" cùng với Claire và những người bạn của cô là Milo và Chài
                    khi họ bắt đầu một cuộc phiêu lưu tuyệt vời.
                </p>
                <p class="mb-1 cinema-info"><strong>Phân loại:</strong> <span class="tag">P</span> Phim phổ biến với mọi độ
                    tuổi</p>
                <p class="mb-1 cinema-info"><strong>Định dạng:</strong> <span class="tag">2D</span></p>
                <p class="mb-1 cinema-info"><strong>Đạo diễn:</strong> Yukiyo Teramoto</p>
                <p class="mb-1 cinema-info"><strong>Diễn viên:</strong> Megumi Ohara, Wasabi Mizuta</p>
                <p class="mb-1 cinema-info"><strong>Thể loại:</strong> Family</p>
                <p class="mb-1 cinema-info"><strong>Khởi chiếu:</strong> 23/05/2025 | Thời lượng: 105 phút</p>
                <p class="mb-1 cinema-info"><strong>Ngôn ngữ:</strong> Phụ đề/Lồng tiếng</p>

                <a href="#" class="btn-ghost">← CHỌN PHIM KHÁC</a>
            </div>
        </div>
    </div>
<div class="container mt-4">
    <div class="container-combo">
            <div class="left-box">
                <div class="tag-button">Concession</div>
                <hr>

                <div class="combo-item">
                    <div class="col">
                        <img src="{{ asset('images/662722.png') }}" alt="combo1">
                        <div class="row">
                            <div class="combo-title">OL Combo1 - Sweet 22Oz</div>
                            <div class="quantity-control">
                                <button class="minus">-</button>
                                <span class="number">0</span>
                                <button class="plus">+</button>
                            </div>
                        </div>

                    </div>

                    <div class="combo-price">
                        <del>85.000 VND</del>
                        <p>76.500 VND</p>
                    </div>

                </div>
                <div class="combo-item">
                    <div class="col">
                        <img src="{{ asset('images/662722.png') }}" alt="combo1">
                        <div class="row">
                            <div class="combo-title">OL Combo1 - Sweet 22Oz</div>
                            <div class="quantity-control">
                                <button class="minus">-</button>
                                <span class="number">0</span>
                                <button class="plus">+</button>
                            </div>
                        </div>

                    </div>

                    <div class="combo-price">
                        <del>85.000 VND</del>
                        <p>76.500 VND</p>
                    </div>

                </div>
                <div class="combo-item">
                    <div class="col">
                        <img src="{{ asset('images/662722.png') }}" alt="combo1">
                        <div class="row">
                            <div class="combo-title">OL Combo1 - Sweet 22Oz</div>
                            <div class="quantity-control">
                                <button class="minus">-</button>
                                <span class="number">0</span>
                                <button class="plus">+</button>
                            </div>
                        </div>

                    </div>

                    <div class="combo-price">
                        <del>85.000 VND</del>
                        <p>76.500 VND</p>
                    </div>

                </div>
                <div class="combo-item">
                    <div class="col">
                        <img src="{{ asset('images/662722.png') }}" alt="combo1">
                        <div class="row">
                            <div class="combo-title">OL Combo1 - Sweet 22Oz</div>
                            <div class="quantity-control">
                                <button class="minus">-</button>
                                <span class="number">0</span>
                                <button class="plus">+</button>
                            </div>
                        </div>

                    </div>

                    <div class="combo-price">
                        <del>85.000 VND</del>
                        <p>76.500 VND</p>
                    </div>

                </div>


            </div>

            <div class="right-box">
                <h3 style="font-weight: bold;">BHD Star The Garden</h3>
                <p><strong style="color: #67B72F;">Screen 6</strong> <span> - 13/6/2025 - Suất chiếu: 14h40</span></p>
                <p class="title">DORAEMON: NOBITA'S ART WORLD TALES</p>
                <p>
                    <span
                        style="background: #0096FF; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px;">P</span>
                    <span
                        style="background: black; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px;">PHỤ
                        ĐỀ</span>
                    <span
                        style="background: green; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px;">2D</span>
                </p>
                <p class="info">1 x Adult - Stand - 2D<br>Ghế: C15 <strong style="float:right">100.000 VND</strong></p>
                <hr>
                <div class="total">
                    <span>Tổng tiền</span>
                    <span>100.000</span>
                </div>
                <p class="note">(Đã bao gồm phụ thu)</p>
                <a href="{{ url('/thanh-toan') }}" class="btn-checkout">THANH TOÁN (3/4)</a>
                <div class="btn-back-wrapper">
                    <a href="{{ url()->previous() }}" class="btn-back">← Trở lại</a>
                </div>

            </div>

        </div>
          </div>

              <button class="btn1">TIN NỔI BẬT</button>
        <div class="featured-news">
            <a href="#">
                <img src="{{ asset('images/cong-tu-bac-lieu-1-1728987515-8367-1728987588.jpg') }}" alt="">
            </a>
        </div>

        



@endsection
@prepend('scripts')
    <script>
        console.log('Chạy đầu tiên');
    </script>
@endprepend

@push('scripts')
    <script>
        console.log('Chạy sau');
    </script>
@endpush