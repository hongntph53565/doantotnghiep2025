<div class="container mb-5">
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
                <a href="javascript:void(0);" class="btn-checkout" onclick="goToStep(2)">THANH TOÁN (2/4)</a>
                <div class="btn-back-wrapper">
    <a href="javascript:void(0);" class="btn-back" onclick="goBackStep()">← Trở lại</a>
</div>

            </div>

        </div>
          </div>