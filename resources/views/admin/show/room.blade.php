@extends('layouts.admin')

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/css/show/room.css') }}">
    <style>
        .vip-zone {
            position: relative;
        }

        .vip-zone::after {
            content: "VIP";
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 10px;
            color: gold;
            font-weight: bold;
        }
    </style>
@endpush

@section('content')
    <div class="container-seat">
        <div class="left-box-seat">
            <div class="screen">
                <!-- Phần màn hình giữ nguyên như cũ -->
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

            <!-- Phần chú thích giữ nguyên -->
            <div class="legend">
                <div class="legend-row">
                    <div class="legend-item">
                        <img src="{{ asset('admin/pictures/seat-normal-available.svg') }}" alt="">
                        <span>Standard</span>
                    </div>
                    <div class="legend-item">
                        <img src="{{ asset('admin/pictures/seat-vip-available.svg') }}" data-type="vip"
                            data-status="available" alt="">
                        <span>VIP</span>
                    </div>
                    <div class="legend-item">
                        <img src="{{ asset('admin/pictures/seat-double-available.svg') }}" data-type="double"
                            data-status="available" alt="">
                        <img src="{{ asset('admin/pictures/seat-double-available.svg') }}" data-type="double"
                            data-status="available" alt="">
                        <span>Couple</span>
                    </div>
                </div>
            </div>

            <div class="seat">
                @php

                    $groupedSeats = [];
                    foreach ($seats as $seat) {
                        $row = substr($seat->seat_code, 0, 1);
                        $groupedSeats[$row][] = $seat;
                    }

                    ksort($groupedSeats);

                    $seatsPerRow = count(current($groupedSeats));
                    $vipZoneStart = floor($seatsPerRow * 0.3);
                    $vipZoneEnd = floor($seatsPerRow * 0.7);
                @endphp

                <table>
                    @foreach ($groupedSeats as $row => $seatsInRow)
                        @php
                            usort($seatsInRow, function ($a, $b) {
                                return substr($a->seat_code, 1) <=> substr($b->seat_code, 1);
                            });
                        @endphp
                        <tr>
                            <td class="lable">{{ $row }}</td>

                            @foreach ($seatsInRow as $index => $seat)
                                @php
                                    $isVipZone = $index >= $vipZoneStart && $index <= $vipZoneEnd;
                                    if ($isVipZone && $seat->seat_type_id != 2) {
                                    }
                                @endphp
                                @if ($seat->seatType->name !== 'couple')
                                    <td>
                                        <img src="{{ $seat->img_url }}" data-type="{{ $seat->seatType->name ?? 'normal' }}"
                                            data-status="available" data-seat-id="{{ $seat->seat_id }}"
                                            class="{{ $isVipZone ? 'vip-zone' : '' }}" alt="{{ $seat->seat_code }}">
                                    </td>
                                @else
                                    <td>
                                        <img src="{{ $seat->img_url }}"
                                            data-type="{{ $seat->seatType->name ?? 'normal' }}" data-status="available"
                                            data-seat-id="{{ $seat->seat_id }}" class="{{ $isVipZone ? 'vip-zone' : '' }}"
                                            alt="{{ $seat->seat_code }}">

                                    </td>
                                    <td>
                                        <img src="{{ $seat->img_url }}"
                                            data-type="{{ $seat->seatType->name ?? 'normal' }}" data-status="available"
                                            data-seat-id="{{ $seat->seat_id }}" class="{{ $isVipZone ? 'vip-zone' : '' }}"
                                            alt="{{ $seat->seat_code }}">

                                    </td>
                                @endif
                            @endforeach

                            <td class="lable">{{ $row }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div style="height: 100px"></div>
@endsection
