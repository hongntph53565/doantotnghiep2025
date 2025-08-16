<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    
<div class="container">
    @if(session('checkout'))
    <p>Mã đơn hàng: {{ session('checkout')['data']['orderCode'] ?? 'N/A' }}</p>
@endif
    <h1>Danh sách Booking</h1>

    <a href="{{ route('booking.create') }}" class="btn btn-primary mb-3">Tạo booking mới</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Booking Code</th>
                <th>User</th>
                <th>Showtime</th>
                <th>Booking Status</th>
                <th>Payment Status</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->booking_id }}</td>
                <td>{{ $booking->booking_code }}</td>
                <td>{{ $booking->user->name ?? 'N/A' }}</td>
                <td>{{ $booking->showtime->name ?? 'N/A' }}</td>
                <td>{{ $booking->booking_status }}</td>
                <td>{{ $booking->payment_status }}</td>
                <td>
                    <a href="{{ route('booking.show', $booking->booking_id) }}" class="btn btn-info btn-sm">Xem</a>
                    <a href="{{ route('booking.edit', $booking->booking_id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('booking.delete', $booking->booking_id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa?')" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $bookings->links() }}
</div>

</body>
</html>