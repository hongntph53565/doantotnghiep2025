@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <br>
        <div class="container-top">
            <h1 class="entry-title text-center">Bước 3: Chọn đồ ăn</h1>
            <div class="card mb-3">
                <div class="row g-0">
                    <div class="col-md-2">
                        <img src="{{ asset('images/1.jpg') }}" class="img" alt="...">
                    </div>
                    <div class="col-md-10">
                        <div class="card-body">
                            <h5 class="card-title">DORAEMON: NOBITA'S ART WORLD TALES</h5>
                            <p class="card-description">Thế giới tráng lệ của châu Âu thời trung cổ được mô tả trong các
                                bức
                                tranh.
                                Doraemon và những người bạn của mình nhảy vào "thế giới của bức tranh" cùng với Claire
                                và
                                những người bạn của cô là Milo và Chai khi họ bắt đầu một cuộc phiêu lưu tuyệt vời.</p>
                            <div class="text">
                                <p class="card-text">Đạo diễn: <span>Yukiyo Teramoto</span></p>
                                <p class="card-text">Diễn viên: <span>Megumi Ohara, Wasabi Mizuta</span></p>
                                <p class="card-text">Thể loại: <span>Family</span></p>
                                <p class="card-text">Khởi chiếu: 23/05/2025 | Thời lượng: 105 phút</p>
                            </div>

                            <a href="#" class="btn-ghost">← CHỌN PHIM KHÁC</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                <a href="#" class="btn-checkout">THANH TOÁN (3/4)</a>
                <div class="btn-back-wrapper">
                    <a href="#" class="btn-back">← Trở lại</a>
                </div>

            </div>

        </div>

        <button class="btn1">TIN NỔI BẬT</button>
        <div class="featured-news">
            <a href="#">
                <img src="{{ asset('images/cong-tu-bac-lieu-1-1728987515-8367-1728987588.jpg') }}" alt="">
            </a>
        </div>


        <button class="btn1">KHUYẾN MÃI</button>

        <div class="promo-container">
            <!-- Promo 1 -->
            <div class="promo-card">
                <img src="{{ asset('images/giu-xe-01.jpg') }}" alt="Giữ xe miễn phí" />
                <div class="promo-content">
                    <div class="promo-title">
                        MIỄN PHÍ VÉ GỬI XE – ĐI XEM PHIM THẢ GA, KHÔNG LO PHÍ GIỮ XE
                    </div>
                    <div class="promo-desc">
                        Từ nay, đi xem phim tại BHD Star Cineplex lại càng tiện lợi và
                        tiết kiệm hơn bao giờ hết! Chúng tôi chính thức triển khai chương
                        trình <strong>MIỄN PHÍ VÉ GỬI XE</strong> dành cho tất cả khách
                        hàng khi mua vé xem phim tại rạp BHS Star – Huế.<br />📌 Áp dụng
                        cho khách […]
                    </div>
                </div>
            </div>

            <!-- Promo 2 -->
            <div class="promo-card">
                <img src="" alt="Xem phim khuyến mãi 50K" />
                <div class="promo-content">
                    <div class="promo-title">
                        🔥 XEM PHIM KHUYA – GIÁ CỰC MÊ CHỈ TỪ 50K 🔥
                    </div>
                    <div class="promo-desc">
                        Bạn là “cú đêm” chính hiệu? Bạn muốn tìm một hoạt động thú vị sau
                        22h? BHD Star Cineplex có ngay deal hấp dẫn dành cho bạn! 🎬
                        <strong>XEM PHIM TRỄ – GIÁ CỰC MÊ</strong> 📍 Áp dụng cho tất cả
                        các suất chiếu sau 22h tại một vài cụm rạp BHD Star Cineplex 🟢
                        […]
                    </div>
                </div>
            </div>

            <!-- Promo 3 -->
            <div class="promo-card">
                <img src="" alt="Happy Day 45K" />
                <div class="promo-content">
                    <div class="promo-title">Happy Day – Vé chỉ từ 45k</div>
                    <div class="promo-desc">
                        Vào thứ hai hàng tuần – Happy Day, giá vé
                        <strong>CHỈ TỪ 45K</strong>. Thưởng thức phim cả ngày không lo về
                        giá. Ưu đãi 45.000đ/vé áp dụng tại cụm rạp: BHD Star Phú Mỹ, BHD
                        Star Huế. Ưu đãi 50.000đ/vé áp dụng tại cụm rạp: BHD Star The
                        Garden; BHD Star Phạm Ngọc […]
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection

@push('styles')
@endpush

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
