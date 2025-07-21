@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <br>
        <div class="container-top">
            <h1 class="entry-title text-center">Bước 2: Chọn ghế</h1>
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
        <div class="container-seat">
            <div class="left-box-seat">
                <div class="screen">
                    <div style="text-align: center; margin-bottom: 10px;">
                        <svg width="100%" height="100" viewBox="0 0 800 100">
                            <defs>
                                <linearGradient id="screenGradient" x1="0" y1="0" x2="0"
                                    y2="1">
                                    <stop offset="0%" stop-color="#adff2f" stop-opacity="0.4" />
                                    <stop offset="100%" stop-color="white" stop-opacity="0" />
                                </linearGradient>
                            </defs>

                            <!-- Vùng shadow cong theo đường cong -->
                            <path d="
                    M50 40
                    Q400 0 750 40
                    Q400 60 50 40
                    Z" fill="url(#screenGradient)" />

                            <!-- Đường cong chính -->
                            <path d="M50 40 Q400 0 750 40" stroke="#adff2f" stroke-width="5" stroke-linecap="round"
                                fill="none" />
                        </svg>

                        <div style="margin-top: -35px; font-weight: bold; color: #acacac; font-size: 20px;">Màn hình
                        </div>
                    </div>


                </div>
                <div class="legend">
                    <div class="legend-row">
                        <div class="legend-item">
                            <img src="{{ asset('images/seat-normal-available.svg') }}" alt="">
                            <span>Standard</span>
                        </div>
                        <div class="legend-item">
                            <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip" data-status="available"
                                alt="">
                            <span>VIP</span>
                        </div>
                        <div class="legend-item">
                            <img src="{{ asset('images/seat-double-available.svg') }}" data-type="double"
                                data-status="available" alt="">
                            <span>Couple</span>
                        </div>
                    </div>
                    <div class="legend-row">
                        <div class="legend-item">
                            <img src="{{ asset('images/seat-selected.svg') }}" alt="">
                            <span>Ghế đã chọn</span>
                        </div>
                        <div class="legend-item">
                            <img src="{{ asset('images/seat-booked.svg') }}" alt="">
                            <span>Ghế đã bán</span>
                        </div>
                    </div>
                </div>
                <div class="seat">
                    <table>
                        <tr>
                            <td class="lable">A</td>

                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>

                            <td class="lable">A</td>
                        </tr>
                        <tr>
                            <td class="lable">B</td>

                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>

                            <td class="lable">B</td>
                        </tr>
                        <tr>
                            <td class="lable">C</td>

                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>

                            <td class="lable">C</td>
                        </tr>


                        <tr>
                            <td class="lable">D</td>

                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>

                            <td class="lable">D</td>
                        </tr>
                        <tr>
                            <td class="lable">E</td>

                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>

                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>

                            <td class="lable">E</td>
                        </tr>
                        <tr>
                            <td class="lable">F</td>

                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>

                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>

                            <td class="lable">F</td>
                        </tr>
                        <tr>
                            <td class="lable">G</td>

                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>

                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>

                            <td class="lable">G</td>
                        </tr>
                        <tr>
                            <td class="lable">H</td>

                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>

                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip"
                                    data-status="available" alt="ghế vip">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>
                            <td>
                                <img src="{{ asset('images/seat-normal-available.svg') }}" data-type="normal"
                                    data-status="available" alt="ghế thường">
                            </td>

                            <td class="lable">H</td>
                        </tr>
                        <tr>
                            <td class="lable">J</td>
                            <td colspan="2">
                                <img src="{{ asset('images/seat-double-available.svg') }}" data-type="double"
                                    data-status="available" alt="ghế đôi">
                                <img src="{{ asset('images/seat-double-available.svg') }}" data-type="double"
                                    data-status="available" alt="ghế đôi">
                            </td>
                            <td colspan="2">
                                <img src="{{ asset('images/seat-double-available.svg') }}" data-type="double"
                                    data-status="available" alt="ghế đôi">
                                <img src="{{ asset('images/seat-double-available.svg') }}" data-type="double"
                                    data-status="available" alt="ghế đôi">
                            </td>
                            <td colspan="2">
                                <img src="{{ asset('images/seat-double-available.svg') }}" data-type="double"
                                    data-status="available" alt="ghế đôi">
                                <img src="{{ asset('images/seat-double-available.svg') }}" data-type="double"
                                    data-status="available" alt="ghế đôi">
                            </td>
                            <td colspan="2">
                                <img src="{{ asset('images/seat-double-available.svg') }}" data-type="double"
                                    data-status="available" alt="ghế đôi">
                                <img src="{{ asset('images/seat-double-available.svg') }}" data-type="double"
                                    data-status="available" alt="ghế đôi">
                            </td>
                            <td colspan="2">
                                <img src="{{ asset('images/seat-double-available.svg') }}" data-type="double"
                                    data-status="available" alt="ghế đôi">
                                <img src="{{ asset('images/seat-double-available.svg') }}" data-type="double"
                                    data-status="available" alt="ghế đôi">
                            </td>
                            <td colspan="2">
                                <img src="{{ asset('images/seat-double-available.svg') }}" data-type="double"
                                    data-status="available" alt="ghế đôi">
                                <img src="{{ asset('images/seat-double-available.svg') }}" data-type="double"
                                    data-status="available" alt="ghế đôi">
                            </td>
                            <td colspan="2">
                                <img src="{{ asset('images/seat-double-available.svg') }}" data-type="double"
                                    data-status="available" alt="ghế đôi">
                                <img src="{{ asset('images/seat-double-available.svg') }}" data-type="double"
                                    data-status="available" alt="ghế đôi">
                            </td>
                            <td colspan="2">
                                <img src="{{ asset('images/seat-double-available.svg') }}" data-type="double"
                                    data-status="available" alt="ghế đôi">
                                <img src="{{ asset('images/seat-double-available.svg') }}" data-type="double"
                                    data-status="available" alt="ghế đôi">
                            </td>
                            <td class="lable">J</td>
                        </tr>

                    </table>
                </div>

            </div>

            <div class="right-box-seat">
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
                <p class="info">1 x OL Combo1 - Sweet 22Oz <strong style="float:right">85.000 VND</strong></p>
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
