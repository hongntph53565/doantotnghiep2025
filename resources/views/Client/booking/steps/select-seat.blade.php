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

                    @php
                        $maxSlots = $groupedSeats
                            ->map(function ($rowSeats) {
                                $sorted = $rowSeats->sortBy(fn($s) => intval(substr($s->seat_code, 1)))->values();
                                $slots = 0;
                                for ($i = 0; $i < $sorted->count(); $i++) {
                                    $seat = $sorted[$i];
                                    $type = strtolower($seat->seatType->name);
                                    if (
                                        $type === 'double' &&
                                        isset($sorted[$i + 1]) &&
                                        strtolower($sorted[$i + 1]->seatType->name) === 'double'
                                    ) {
                                        $slots += 2;
                                        $i++; // Skip next seat
                                    } else {
                                        $slots++;
                                    }
                                }
                                return $slots;
                            })
                            ->max();
                    @endphp
                    {{-- @php
    dump("Seat ID: " . $seat->seat_id, $showtimeSeatStatuses[$seat->seat_id] ?? 'not found');
@endphp --}}
                    @foreach ($groupedSeats as $rowLabel => $rowSeats)
                        <tr>
                            <td class="lable">{{ $rowLabel }}</td>

                            @php
                                $sortedSeats = $rowSeats
                                    ->sortBy(fn($seat) => intval(substr($seat->seat_code, 1)))
                                    ->values();
                                $slotCount = 0;
                                $cells = [];

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
                                    $status = $showtimeSeatStatuses[$seat->seat_id] ?? 'available';

                                    $imgPath = match ($status) {
                                         'booked', 'pending' => 'seat-booked.svg',
                                        default => match ($mappedType) {
                                            'standard' => 'seat-standard-available.svg',
                                            'vip' => 'seat-vip-available.svg',
                                            'couple' => 'seat-couple-available.svg',
                                            default => 'seat-standard-available.svg',
                                        },
                                    };

                                    $price = $seatPrices[$seat->seat_type_id]->price ?? 0;

                                @endphp

                                @if ($isCouple)
                                    @php
                                        $coupleId = $seat->seat_code . '_' . $nextSeat->seat_code;

                                        $status1 = $showtimeSeatStatuses[$seat->seat_id] ?? 'available';
                                        $status2 = $showtimeSeatStatuses[$nextSeat->seat_id] ?? 'available';

                                        // Ưu tiên booked > pending > available
                                        $finalStatus =
                                            $status1 === 'booked' || $status2 === 'booked'
                                                ? 'booked'
                                                : ($status1 === 'pending' || $status2 === 'pending'
                                                    ? 'pending'
                                                    : 'available');

                                        $imgPath = match ($finalStatus) {
                                            'booked', 'pending' => 'seat-booked.svg',
                                            default => match ($mappedType) {
                                                'standard' => 'seat-standard-available.svg',
                                                'vip' => 'seat-vip-available.svg',
                                                'couple' => 'seat-couple-available.svg',
                                                default => 'seat-standard-available.svg',
                                            },
                                        };
                                    @endphp

                                    @php
                                        $cells[] =
                                            '<td colspan="2"><div style="display: flex; gap: 0;">
<img src="' .
                                            asset("images/{$imgPath}") .
                                            '" data-type="couple" data-seat-code="' .
                                            $seat->seat_code .
                                            '" data-seat-id="' .
                                            $seat->seat_id .
                                            '" data-couple-id="' .
                                            $coupleId .
                                            '" data-status="' .
                                            $finalStatus .
                                            '" data-price="' .
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
                                            '" data-couple-id="' .
                                            $coupleId .
                                            '" data-status="' .
                                            $finalStatus .
                                            '" data-price="' .
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
                                            'data-status="' .
                                            $status .
                                            '" data-price="' .
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
            <div id="invalidSeatMessage" class="ErrorSeat">
                Bạn không được để 1 ghế trống ngoài cùng bên trái hoặc phải và ở giữa trên cùng hàng ghế mà bạn chọn.
            </div>

            <a href="javascript:void(0);" id="payButton" class="btn-checkout" onclick="goToStep(2)">Chọn đồ ăn (2/4)</a>

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
            updateUIAfterSeatChange();
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

    
        sessionStorage.setItem('selectedSeats', JSON.stringify(Array.from(selectedSeats.values())));
        sessionStorage.setItem('ticketTotal', totalPrice);
    }


    window.userRole = {{ auth()->user()->role_id ?? 'null' }};

    // function isIsolatedSeat(img) {
    //     const seatCode = img.dataset.seatCode;
    //     const row = seatCode.charAt(0);
    //     const col = parseInt(seatCode.slice(1));

    //     // Lấy tất cả ghế trong hàng này
    //     const allSeatsInRow = Array.from(document.querySelectorAll(`img[data-seat-code^="${row}"]`));
    //     const sortedCols = allSeatsInRow
    //         .map(seat => parseInt(seat.dataset.seatCode.slice(1)))
    //         .sort((a, b) => a - b);

    //     const minCol = sortedCols[0];
    //     const maxCol = sortedCols[sortedCols.length - 1];
    //     const secondFromLeft = minCol + 1;
    //     const secondFromRight = maxCol - 1;

    //     const isAtEdge = (col === secondFromLeft || col === secondFromRight);

    //     const leftSeat = document.querySelector(`img[data-seat-code="${row}${col - 1}"]`);
    //     const rightSeat = document.querySelector(`img[data-seat-code="${row}${col + 1}"]`);

    //     const isLeftChosenOrBooked = leftSeat &&
    //         (leftSeat.dataset.status === 'booked' || selectedSeats.has(leftSeat.dataset.seatCode));
    //     const isRightChosenOrBooked = rightSeat &&
    //         (rightSeat.dataset.status === 'booked' || selectedSeats.has(rightSeat.dataset.seatCode));

    //     // ❌ Trường hợp 1: Ghế ở mép và bị lẻ
    //     if (isAtEdge && !isLeftChosenOrBooked && !isRightChosenOrBooked) return true;

    //     // ❌ Trường hợp 2: 1 ghế trống giữa 2 ghế đã chọn/đã bán (VD: chọn A2, A4, để A3 trống)
    //     const seatBefore = document.querySelector(`img[data-seat-code="${row}${col - 1}"]`);
    //     const seatAfter = document.querySelector(`img[data-seat-code="${row}${col + 1}"]`);
    //     if (seatBefore && seatAfter) {
    //         const isBeforeChosen = seatBefore.dataset.status === 'booked' || selectedSeats.has(seatBefore.dataset.seatCode);
    //         const isAfterChosen = seatAfter.dataset.status === 'booked' || selectedSeats.has(seatAfter.dataset.seatCode);

    //         if (isBeforeChosen && isAfterChosen) return true;
    //     }

    //     // ❌ Trường hợp 3: Bỏ 1 ghế ở giữa khi chọn 2 ghế cách nhau (VD: A2 & A5)
    //     const allChosenSeatsInRow = allSeatsInRow.filter(seat =>
    //         selectedSeats.has(seat.dataset.seatCode) || seat.dataset.status === 'booked'
    //     );
    //     const selectedCols = allChosenSeatsInRow.map(seat => parseInt(seat.dataset.seatCode.slice(1)));
    //     selectedCols.push(col); // thêm ghế đang click
    //     selectedCols.sort((a, b) => a - b);

    //     for (let i = 0; i < selectedCols.length - 1; i++) {
    //         if (selectedCols[i + 1] - selectedCols[i] === 2) {
    //             const inBetweenCol = selectedCols[i] + 1;
    //             const inBetweenSeat = document.querySelector(`img[data-seat-code="${row}${inBetweenCol}"]`);
    //             if (inBetweenSeat &&
    //                 inBetweenSeat.dataset.status !== 'booked' &&
    //                 !selectedSeats.has(inBetweenSeat.dataset.seatCode)
    //             ) {
    //                 return true;
    //             }
    //         }
    //     }

    //     return false;
    // }
    function isIsolatedSeat(img) {
        if (window.userRole !== 4) return false;

        const seatCode = img.dataset.seatCode;
        const row = seatCode.charAt(0);
        const col = parseInt(seatCode.slice(1));

        const allSeatsInRow = Array.from(document.querySelectorAll(`img[data-seat-code^="${row}"]`));
        const seatMap = new Map();

        allSeatsInRow.forEach(seat => {
            const c = parseInt(seat.dataset.seatCode.slice(1));
            seatMap.set(c, {
                isSelected: selectedSeats.has(seat.dataset.seatCode),
                isBooked: seat.dataset.status === 'booked'
            });
        });

        // Đảm bảo thêm ghế hiện tại đang click (phòng trường hợp chưa add vào selectedSeats)
        seatMap.set(col, {
            isSelected: true,
            isBooked: false
        });

        const selectedCols = Array.from(seatMap.entries())
            .filter(([_, v]) => v.isSelected || v.isBooked)
            .map(([k, _]) => k)
            .sort((a, b) => a - b);

        const minCol = Math.min(...selectedCols);
        const maxCol = Math.max(...selectedCols);

        // ✅ Điều kiện 1: không được để lại ghế trống kẹt giữa
        for (let i = minCol + 1; i < maxCol; i++) {
            const current = seatMap.get(i);
            const prev = seatMap.get(i - 1);
            const next = seatMap.get(i + 1);

            if (!current || !prev || !next) continue;

            if (!current.isSelected && !current.isBooked &&
                (prev.isSelected || prev.isBooked) &&
                (next.isSelected || next.isBooked)) {
                return true; // Ghế trống bị kẹp giữa
            }
        }

        // ✅ Điều kiện 2: không được để ghế đơn ở mép hàng
        const sortedColsAll = allSeatsInRow.map(seat => parseInt(seat.dataset.seatCode.slice(1))).sort((a, b) => a - b);
        const secondFromLeft = sortedColsAll[0] + 1;
        const secondFromRight = sortedColsAll[sortedColsAll.length - 1] - 1;

        const isAtEdge = (col === secondFromLeft || col === secondFromRight);

        const leftSeat = seatMap.get(col - 1);
        const rightSeat = seatMap.get(col + 1);

        const isLeftOccupied = leftSeat && (leftSeat.isSelected || leftSeat.isBooked);
        const isRightOccupied = rightSeat && (rightSeat.isSelected || rightSeat.isBooked);

        if (isAtEdge && !isLeftOccupied && !isRightOccupied) {
            return true;
        }

        // ✅ Điều kiện 3: không được để lại 1 ghế đơn giữa 2 ghế đã chọn/bán
        if (isLeftOccupied && isRightOccupied) {
            const middleSeat = seatMap.get(col);
            if (middleSeat && !middleSeat.isSelected && !middleSeat.isBooked) {
                return true;
            }
        }

        return false;
    }








    function hasInvalidSeatSelection() {
        if (window.userRole !== 4) return false; 

        for (const key of selectedSeats.keys()) {
            if (key.startsWith('couple-')) continue;

            const img = document.querySelector(`img[data-seat-code="${key}"]`);
            if (img && isIsolatedSeat(img)) return true;
        }
        return false;
    }

    function updateUIAfterSeatChange() {
        const hasInvalid = hasInvalidSeatSelection();

        const payButton = document.querySelector('#payButton'); 
        const errorBox = document.querySelector('#invalidSeatMessage');

        if (hasInvalid) {
            payButton.style.display = 'none';
            errorBox.style.display = 'block';
        } else {
            payButton.style.display = 'block';
            errorBox.style.display = 'none';
        }
    }
</script>
