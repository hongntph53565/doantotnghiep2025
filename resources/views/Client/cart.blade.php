@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="content-top">
            <select class="cinema-select">
                <option>BHD Star 3.2</option>
                <option>BHD Star Huế</option>
                <option>BHD Star Thảo Điền</option>
            </select>

            <div class="cart-wrapper">
                <div class="cart-icon">🛒</div>
                <div class="cart-badge">0</div>
            </div>
        </div>

        <button class="btn1">CONCESSION</button>

        <div class="combo-container">
            <!-- Combo 1 -->
            <div class="combo-card">
                <img src="{{ asset('images/662722.png') }}" alt="Combo 1" />
                <div class="combo-content">
                    <div class="combo-title">
                        OL Combo Single Sweet 32Oz - Pepsi 22Oz
                    </div>
                    <div class="combo-desc">
                        01 bắp nhỏ vị ngọt + 01 ly nước 22Oz. Nhận trong ngày xem phim.
                    </div>
                </div>
                <div class="combo-footer">
                    <div class="price">77.000 VND</div>
                    <button class="buy-btn">MUA NGAY</button>
                </div>
            </div>

            <!-- Combo 2 -->
            <div class="combo-card">
                <img src="" alt="Combo 2" />
                <div class="combo-content">
                    <div class="combo-title">
                        OL Combo Couple Sweet 32Oz - Pepsi 22Oz
                    </div>
                    <div class="combo-desc">
                        01 bắp nhỏ vị ngọt + 02 ly nước 22Oz. Nhận trong ngày xem phim.
                    </div>
                </div>
                <div class="combo-footer">
                    <div class="price">109.000 VND</div>
                    <button class="buy-btn">MUA NGAY</button>
                </div>
            </div>

            <!-- Combo 3 -->
            <div class="combo-card">
                <img src="" alt="Combo 3" />
                <div class="combo-content">
                    <div class="combo-title">
                        OL Food CB Ga Vong Sweet 32Oz - Pepsi 22Oz
                    </div>
                    <div class="combo-desc">
                        01 bắp nhỏ vị ngọt + 01 ly nước 22Oz + 01 gà vòng chiên. Nhận
                        trong ngày xem phim.
                    </div>
                </div>
                <div class="combo-footer">
                    <div class="price">114.000 VND</div>
                    <button class="buy-btn">MUA NGAY</button>
                </div>
            </div>

            <!-- Combo 4 -->
            <div class="combo-card">
                <img src="" alt="Combo 4" />
                <div class="combo-content">
                    <div class="combo-title">
                        OL Food CB KTC Sweet 32Oz - Pepsi 22Oz
                    </div>
                    <div class="combo-desc">
                        01 bắp nhỏ vị ngọt + 01 ly nước 22Oz + 01 khoai tây chiên. Nhận
                        trong ngày xem phim.
                    </div>
                </div>
                <div class="combo-footer">
                    <div class="price">114.000 VND</div>
                    <button class="buy-btn">MUA NGAY</button>
                </div>
            </div>
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
