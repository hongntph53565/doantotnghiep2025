@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/css/show/room.css') }}">
    <style>
        .container-seat {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .left-box-seat {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .screen {
            margin-bottom: 30px;
            text-align: center;
        }

        .seat-map {
            width: 100%;
            overflow-x: auto;
        }

        .seat-row {
            display: flex;
            justify-content: center;
            margin-bottom: 15px;
            align-items: center;
        }

        .row-label {
            font-weight: bold;
            width: 30px;
            text-align: center;
        }

        .seat-container {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            justify-content: center;
            align-items: center;
        }

        .seat-card {
            width: 40px;
            height: 60px;
            border: 1px solid #ddd;
            border-radius: 6px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: white;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .seat-card.couple {
            width: 85px; /* Bằng 2 ghế thường + khoảng cách */
            padding: 5px;
        }

        .seat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .seat-card img {
            max-width: 90%;
            max-height: 70%;
            object-fit: contain;
        }

        .seat-code {
            font-size: 10px;
            color: #555;
            margin-top: 2px;
        }

        .legend {
            margin: 20px 0;
            padding: 15px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .legend-row {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .legend-item img {
            width: 30px;
            height: 45px;
        }

        .legend-item .couple-sample {
            width: 65px;
        }

        .legend-item span {
            font-size: 14px;
            color: #555;
        }

        @media (max-width: 768px) {
            .seat-card {
                width: 30px;
                height: 45px;
            }
            
            .seat-card.couple {
                width: 65px;
            }
            
            .legend-item img {
                width: 25px;
                height: 38px;
            }
            
            .legend-item .couple-sample {
                width: 55px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container-seat">
        <div class="left-box-seat">
            <div class="screen">
                <div style="text-align: center; margin-bottom: 10px;">
                    <svg width="100%" height="100" viewBox="0 0 800 100">
                        <defs>
                            <linearGradient id="screenGradient" x1="0" y1="0" x2="0" y2="1">
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
                    <div style="margin-top: -35px; font-weight: bold; color: #acacac; font-size: 20px;">Màn hình</div>
                </div>
            </div>

            <div class="legend">
                <div class="legend-row">
                    <div class="legend-item">
                        <img src="{{ asset('admin/pictures/seat-normal-available.svg') }}" alt="">
                        <span>Standard</span>
                    </div>
                    <div class="legend-item">
                        <img src="{{ asset('admin/pictures/seat-vip-available.svg') }}" alt="">
                        <span>VIP</span>
                    </div>
                    <div class="legend-item">
                        <div class="couple-sample">
                            <img src="{{ asset('admin/pictures/seat-double-available.svg') }}" alt="">
                        </div>
                        <span>Couple</span>
                    </div>
                </div>
            </div>

            <div class="seat-map">
                @php
                    $groupedSeats = [];
                    foreach ($seats as $seat) {
                        $row = substr($seat->seat_code, 0, 1);
                        $groupedSeats[$row][] = $seat;
                    }
                    ksort($groupedSeats);
                    
                    // Xác định khu VIP (30-70% chiều ngang)
                    $seatsPerRow = count(current($groupedSeats));
                    $vipZoneStart = floor($seatsPerRow * 0.3);
                    $vipZoneEnd = floor($seatsPerRow * 0.7);
                @endphp

                @foreach ($groupedSeats as $row => $seatsInRow)
                    @php
                        // Sắp xếp ghế theo số thứ tự
                        usort($seatsInRow, function ($a, $b) {
                            return substr($a->seat_code, 1) <=> substr($b->seat_code, 1);
                        });
                    @endphp
                    
                    <div class="seat-row">
                        <div class="row-label">{{ $row }}</div>
                        
                        <div class="seat-container">
                            @foreach ($seatsInRow as $index => $seat)
                                @php
                                    $isVipZone = $index >= $vipZoneStart && $index <= $vipZoneEnd;
                                    $isCouple = $seat->seatType->name === 'couple';
                                @endphp
                                
                                <div class="seat-card {{ $isCouple ? 'couple' : '' }} {{ $isVipZone ? 'vip-zone' : '' }}"
                                     data-seat-id="{{ $seat->seat_id }}"
                                     data-type="{{ $seat->seatType->name ?? 'normal' }}">
                                    <img src="{{ $seat->img_url }}" alt="{{ $seat->seat_code }}">
                                    <div class="seat-code">{{ $seat->seat_code }}</div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="row-label">{{ $row }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <div style="height: 100px"></div>
@endsection