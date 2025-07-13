<div class="container mb-5">
    <div class="container-combo">
        <div class="left-box">
            <div class="tag-button">Concession</div>
            <hr>

            @if (isset($foods) && count($foods))
                @foreach ($foods as $type => $items)
                    @foreach ($items as $food)
                        <div class="combo-item mb-3" data-price="{{ $food->price }}">
                            <div class="col">
                                <img src="{{ asset('storage/' . $food->image) }}" alt="{{ $food->name }}">
                                <div class="row">
                                    <div class="combo-title">{{ $food->name }}</div>
                                    <div class="quantity-control">
                                        <button class="minus" data-id="{{ $food->food_id }}">-</button>
                                        <span class="number" id="combo-qty-{{ $food->food_id }}">0</span>
                                        <button class="plus" data-id="{{ $food->food_id }}">+</button>
                                    </div>
                                </div>
                            </div>
                            <div class="combo-price">
                                <p>{{ number_format($food->price, 0, ',', '.') }} VND</p>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            @else
                <p>Không có combo phù hợp cho rạp này.</p>
            @endif
        </div>

        <div class="right-box">
            <h3 style="font-weight: bold;">
                {{ $selectedShowtime->room->cinema->name ?? 'Tên rạp' }}
            </h3>
            <p>
                <strong style="color: #67B72F;">{{ $selectedShowtime->room->room_name ?? 'Phòng chiếu' }}</strong>
                <span>
                    -
                    {{ optional($selectedShowtime)->date ? \Carbon\Carbon::parse($selectedShowtime->date)->format('d/m/Y') : 'Ngày chiếu' }}
                    - Suất chiếu:
                    {{ optional($selectedShowtime)->start_time ? \Carbon\Carbon::parse($selectedShowtime->start_time)->format('H:i') : 'Giờ' }}
                </span>
            </p>
            <p class="title">{{ $movie->title ?? 'Tên phim' }}</p>
            <p>
                <span
                    style="background: #0096FF; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px;">{{ $movie->rated ?? 'P' }}</span>
                <span
                    style="background: black; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px;">PHỤ
                    ĐỀ</span>
                <span
                    style="background: green; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px;">2D</span>
            </p>
            <p class="info" id="seat-info">Đang tải ghế...</p>
            <hr>
            <div id="food-selected-list" style="margin-bottom: 10px;"></div>
            <hr>
            <div class="total">
                <span>Tổng tiền</span>
                <span id="final-total">0 VND</span>
            </div>
            <p class="note">(Đã bao gồm phụ thu)</p>
            <a href="javascript:void(0);" class="btn-checkout" onclick="goToStep(3)">THANH TOÁN (3/4)</a>
            <div class="btn-back-wrapper">
                <a href="javascript:void(0);" class="btn-back" onclick="goBackStep()">← Trở lại</a>
            </div>
        </div>
    </div>
</div>
