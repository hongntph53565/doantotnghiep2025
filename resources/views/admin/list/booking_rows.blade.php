@forelse($bookings as $booking)
    <tr>
        <td class="align-middle text-center">{{ $booking->booking_code }}</td>
        <td class="align-middle text-start">
            <b>Người dùng:</b> {{ $booking->user->full_name ?? 'N/A' }} <br>
            <b>Email:</b> {{ $booking->user->email ?? 'N/A' }} <br>
            <b>Phương thức thanh toán:</b> {{ $booking->payment_method ?? 'N/A' }}
        </td>
        <td>
            <img src="{{ $booking->showtime?->movie?->poster
                ? asset('storage/' . $booking->showtime->movie->poster)
                : 'https://via.placeholder.com/100' }}"
                alt="Poster" width="100">
        </td>
        <td class="align-middle text-start">
            <b>Phim:</b> {{ $booking->showtime->movie->title ?? 'N/A' }} <br>
            <b>Rạp:</b> {{ $booking->showtime->cinema->name ?? 'N/A' }} <br>
            <b>Ghế:</b> {{ $booking->seats->pluck('seat_code')->join(', ') ?? 'N/A' }} <br>
            <b>Tổng tiền:</b> {{ number_format($booking->total_price, 0, ',', '.') }} VND <br>
            <b>Trạng thái:</b>
            @if ($booking->printed_count > 0)
                <span class="badge bg-success">Đã xuất vé</span>
            @else
                <span class="badge bg-warning">Chưa xuất vé</span>
            @endif <br>
            <b>Lịch chiếu:</b>
            {{ $booking->showtime?->start_time ? \Carbon\Carbon::parse($booking->showtime->start_time)->format('H:i') : '' }}

            -
            {{ $booking->showtime?->end_time ? \Carbon\Carbon::parse($booking->showtime->end_time)->format('H:i') : '' }}
            <br>
            <b>Thời gian sử dụng:</b>
            {{ $booking->showtime?->end_time ? \Carbon\Carbon::parse($booking->showtime->end_time)->format('H:i') : '' }}
            -
            {{ $booking->showtime?->date ? \Carbon\Carbon::parse($booking->showtime->date)->format('d/m/Y') : '' }}
            <br>
        </td>
        <td class="align-middle text-center">
            <a href="{{ route('bills.show', $booking->booking_id) }}" class="btn btn-sm btn-primary">
                <i class="fas fa-eye"></i>
            </a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="5" class="text-center">Không có dữ liệu</td>
    </tr>
@endforelse
