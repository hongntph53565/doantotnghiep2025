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
                    $sortedSeats = $rowSeats->sortBy(fn($seat) => intval(substr($seat->seat_code, 1)))->values();
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
                            $mappedType === 'couple' && $nextSeat && strtolower($nextSeat->seatType->name) === 'couple';

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
<style>
    .btn-checkout {
        display: block;
        background: linear-gradient(to top, #99dc3c, #3fb83f);
        padding: 10px;
        text-align: center;
        color: #fff;
        font-size: 18px;
        font-weight: bold;
        border-radius: 12px;
        margin-top: 10px;
        text-decoration: none;
    }

    .btn-checkout:hover {
        background: linear-gradient(to top, #3fb83f, #3fb83f);
    }

    .btn-back-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 16px;
    }

    .btn-back {
        color: #8bc34a;
        text-decoration: none;
        font-size: 16px;
    }

    .col-md-4 {
        border: 1px solid #ddd;
        border-radius: 20px;
        padding: 20px 20px 0px 20px;
        background-color: #fff;
        height: auto;
    }

    .col-md-4 h3 {
        margin: 0 0 10px;
    }

    .col-md-4.title {
        font-weight: bold;
        font-size: 18px;
    }

    .btn-ghost {
        margin-top: 30px;
        display: inline-block;
        color: #67B72F;
        /* Màu xanh lá */
        border: 1px solid #67B72F;
        /* Viền xanh */
        padding: 8px 20px;
        border-radius: 6px;
        font-weight: 600;
        text-transform: uppercase;
        text-decoration: none;
        font-family: 'Arial', sans-serif;
        font-size: 15px;
        transition: 0.2s ease;
    }

    .btn-ghost:hover {
        background-color: #67B72F;
        color: #fff;
    }

    .col-md-2 img {
        width: 100%;
        padding: 20px;
        border-radius: 30px;
    }

    .legend {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 30px;
        margin-top: 20px;
    }

    .legend-row {
        display: flex;
        gap: 50px;
        justify-content: center;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        color: #ccc;
        font-size: 14px;
    }

    .legend-item img {
        width: 30px;
        height: 30px;
    }

    .seat table {
        margin: 0 auto;
        margin-top: 30px;
        border-collapse: collapse;
    }

    .seat td {
        padding: 4px;
        text-align: center;
    }

    .seat img {
        width: 30px;
        height: 30px;
        cursor: pointer;
        transition: transform 0.2s ease, filter 0.2s ease;
    }


    /* Trạng thái ghế được chọn */
    .seat img.selected {
        filter: sepia(100%) hue-rotate(180deg) saturate(200%);
    }

    /* Ghế đã đặt (ví dụ nếu muốn hiển thị màu xám) */
    .seat img.booked {
        opacity: 0.4;
        cursor: not-allowed;
        filter: grayscale(100%);
    }

    /* Label trái/phải */
    .seat .lable {
        font-weight: bold;
        padding: 0 8px;
        vertical-align: middle;
    }

    .seat .couple {
        display: flex;
    }

    /* Ô chứa ghế đôi */
    td[colspan="2"] {
        text-align: center;
        padding: 8px;
    }
</style>

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