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
                        <path d="
                    M50 40
                    Q400 0 750 40
                    Q400 60 50 40
                    Z" fill="url(#screenGradient)" />

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
                        <img src="{{ asset('images/seat-standard-available.svg') }}" alt="">
                        <span>Standard</span>
                    </div>
                    <div class="legend-item">
                        <img src="{{ asset('images/seat-vip-available.svg') }}" data-type="vip" data-status="available"
                            alt="">
                        <span>VIP</span>
                    </div>
                    <div class="legend-item">
                        <img src="{{ asset('images/seat-couple-available.svg') }}" data-type="double"
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
            @php
                $groupedSeats = $seats->groupBy(function ($seat) {
                    return strtoupper(substr($seat->seat_code, 0, 1));
                });
            @endphp
            @php
                use App\Models\CinemaSeatTypePrice;

                $seatPrices = collect();

                if ($selectedShowtime && $selectedShowtime->room) {
                    $seatPrices = CinemaSeatTypePrice::where('cinema_id', $selectedShowtime->room->cinema_id)
                        ->get()
                        ->keyBy('seat_type_id');
                }
            @endphp
            <div class="seat">
                <table>
                    @foreach ($groupedSeats as $rowLabel => $rowSeats)
                        <tr>
                            <td class="lable">{{ $rowLabel }}</td>

                            @php
                                $sortedSeats = $rowSeats
                                    ->sortBy(fn($seat) => intval(substr($seat->seat_code, 1)))
                                    ->values();
                                $slotCount = 0;
                                $cells = [];
                                $maxSlots = 8;
                            @endphp

                            @for ($i = 0; $i < $sortedSeats->count(); $i++)
                                @php
                                    $seat = $sortedSeats[$i];
                                    $type = strtolower($seat->seatType->name);
                                    $mappedType = $type === 'double' ? 'couple' : $type;
                                    $nextSeat = $sortedSeats[$i + 1] ?? null;
                                    $isCouple =
                                        $mappedType === 'couple' &&
                                        $nextSeat &&
                                        strtolower($nextSeat->seatType->name) === 'couple';

                                    $imgPath = match ($mappedType) {
                                        'standard' => 'seat-standard-available.svg',
                                        'vip' => 'seat-vip-available.svg',
                                        'couple' => 'seat-couple-available.svg',
                                        default => 'seat-standard-available.svg',
                                    };

                                    $price = $seatPrices[$seat->seat_type_id]->price ?? 0;

                                @endphp

                                @if ($isCouple)
                                    @php
                                        $coupleId = $seat->seat_code . '_' . $nextSeat->seat_code;
                                        $cells[] =
                                            '<td colspan="2"><div style="display: flex; gap: 0;">
<img src="' .
                                            asset("images/{$imgPath}") .
                                            '" data-type="couple" data-seat-code="' .
                                            $seat->seat_code .
                                            '" data-seat-id="' .
                                            $seat->seat_id .
                                            '" ' . // Thêm ở đây
                                            'data-couple-id="' .
                                            $coupleId .
                                            '" data-status="available" data-price="' .
                                            $price .
                                            '" title="Ghế ' .
                                            $seat->seat_code .
                                            ' - ' .
                                            $price .
                                            ' VND">
<img src="' .
                                            asset("images/{$imgPath}") .
                                            '" data-type="couple" data-seat-code="' .
                                            $nextSeat->seat_code .
                                            '" data-seat-id="' .
                                            $nextSeat->seat_id .
                                            '" ' . // Thêm ở đây
                                            'data-couple-id="' .
                                            $coupleId .
                                            '" data-status="available" data-price="' .
                                            $price .
                                            '" title="Ghế ' .
                                            $nextSeat->seat_code .
                                            ' - ' .
                                            $price .
                                            ' VND">
</div></td>';

                                        $slotCount += 2;
                                        $i++;
                                    @endphp
                                @else
                                    @php
                                        $cells[] =
                                            '<td><img src="' .
                                            asset("images/{$imgPath}") .
                                            '" data-type="' .
                                            $mappedType .
                                            '" data-seat-code="' .
                                            $seat->seat_code .
                                            '" data-seat-id="' .
                                            $seat->seat_id .
                                            '" ' . // Thêm ở đây
                                            'data-status="available" data-price="' .
                                            $price .
                                            '" title="Ghế ' .
                                            $seat->seat_code .
                                            ' - ' .
                                            $price .
                                            ' VND"></td>';
                                        $slotCount++;
                                    @endphp
                                @endif
                            @endfor

                            @php
                                $missingSlots = $maxSlots - $slotCount;
                                $leftPadding = floor($missingSlots / 2);
                                $rightPadding = $missingSlots - $leftPadding;
                            @endphp

                            @for ($j = 0; $j < $leftPadding; $j++)
                                <td></td>
                            @endfor
                            {!! implode('', $cells) !!}
                            @for ($j = 0; $j < $rightPadding; $j++)
                                <td></td>
                            @endfor

                            <td class="lable">{{ $rowLabel }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <div class="right-box-seat">
            <h3 style="font-weight: bold;">{{ $selectedShowtime->room->cinema->name ?? 'Tên rạp' }}</h3>
            <p>
                <strong style="color: #67B72F;">{{ $selectedShowtime->room->room_name ?? 'Phòng chiếu' }}</strong>
                @if ($selectedShowtime)
                    <span>
                        - {{ \Carbon\Carbon::parse($selectedShowtime->date)->format('d/m/Y') }}
                        - Suất chiếu: {{ \Carbon\Carbon::parse($selectedShowtime->start_time)->format('H:i') }}
                    </span>
                @else
                    <span> - Ngày chiếu - Suất chiếu: giờ </span>
                @endif

            </p>
            <p class="title" style="color: #67B72F; font-weight: bold; font-size: 20px;">
                {{ $movie->title ?? 'Tên phim' }}
            </p>

            <p>
                <span
                    style="background: #0096FF; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px; margin-right: 6px;">
                    {{ $movie->age_rating ?? 'P' }}
                </span>
                <span
                    style="background: black; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px; margin-right: 6px;">
                    {{ $movie->language ?? 'Phụ đề' }}
                </span>
                <span style="background: green; color: white; padding: 2px 6px; border-radius: 4px; font-size: 12px;">
                    {{ $movie->format ?? '2D' }}
                </span>
            </p>

            <div id="selected-seats"></div>
            <hr>
            <div class="total">
                <span>Tổng tiền</span>
                <span id="total-price">0 VND</span>
            </div>

            <p class="note">(Đã bao gồm phụ thu)</p>
            <a href="javascript:void(0);" class="btn-checkout" onclick="goToStep(2)">Chọn đồ ăn (2/4)</a>
            <div class="btn-back-wrapper">
                <a href="javascript:void(0);" class="btn-back" onclick="goBackStep()">← Trở lại</a>
            </div>

        </div>

    </div>
</div>
<script>
    const selectedSeats = new Map();

    document.querySelectorAll('.seat img[data-seat-code]').forEach(img => {
        img.addEventListener('click', () => {
            const code = img.dataset.seatCode;
            const seatId = parseInt(img.dataset.seatId);
            const price = parseInt(img.dataset.price);
            const type = img.dataset.type;
            const coupleId = img.dataset.coupleId;

            if (img.dataset.status === 'booked') return;

            if (type === 'couple' && coupleId) {
                const coupleImgs = document.querySelectorAll(`img[data-couple-id="${coupleId}"]`);
                const coupleKey = `couple-${coupleId}`;
                const isSelected = selectedSeats.has(coupleKey);
                if (isSelected) {
                    selectedSeats.delete(coupleKey);
                    coupleImgs.forEach(el => el.src = '/images/seat-couple-available.svg');
                } else {
                    const codes = Array.from(coupleImgs).map(el => el.dataset.seatCode);
                    const seatIds = Array.from(coupleImgs).map(el => parseInt(el.dataset.seatId));

                    selectedSeats.set(coupleKey, {
                        codes,
                        seat_ids: seatIds,
                        price,
                        type: 'couple'
                    });

                    coupleImgs.forEach(el => el.src = '/images/seat-selected.svg');
                }
            } else {
                if (selectedSeats.has(code)) {
                    selectedSeats.delete(code);
                    img.src = `/images/seat-${type}-available.svg`;
                } else {
                    selectedSeats.set(code, {
                        code,
                        seat_id: seatId,
                        price,
                        type
                    });
                    img.src = `/images/seat-selected.svg`;
                }
            }

            updateSummary();
        });
    });


    function updateSummary() {
        const summary = document.getElementById('selected-seats');
        const total = document.getElementById('total-price');

        const seatGroups = {
            standard: [],
            vip: [],
            couple: []
        };
        let totalPrice = 0;

        selectedSeats.forEach(seat => {
            if (seat.type === 'couple') {
                seatGroups.couple.push(seat.codes.join(' & '));
                totalPrice += seat.price;
            } else {
                seatGroups[seat.type]?.push(seat.code);
                totalPrice += seat.price;
            }
        });

        let html = '';
        if (seatGroups.standard.length) {
            html += `<p class="info">Ghế Standard: ${seatGroups.standard.join(', ')}</p>`;
        }
        if (seatGroups.vip.length) {
            html += `<p class="info">Ghế VIP: ${seatGroups.vip.join(', ')}</p>`;
        }
        if (seatGroups.couple.length) {
            html += `<p class="info">Ghế Couple: ${seatGroups.couple.join(', ')}</p>`;
        }

        summary.innerHTML = html || '<p class="text-muted">Chưa chọn ghế</p>';
        total.innerText = totalPrice.toLocaleString() + ' VND';

        // 👉 Lưu vào sessionStorage để dùng ở bước combo
        sessionStorage.setItem('selectedSeats', JSON.stringify(Array.from(selectedSeats.values())));
        sessionStorage.setItem('ticketTotal', totalPrice);
    }
</script>
