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
    <h1>Chi tiết Booking #{{ $booking->booking_id }}</h1>

    <table class="table table-bordered">
        <tr>
            <th>Booking Code</th>
            <td>{{ $booking->booking_code }}</td>
        </tr>
        <tr>
            <th>User</th>
            <td>{{ $booking->user->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Showtime</th>
            <td>{{ $booking->showtime->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <th>Booking Status</th>
            <td>{{ ucfirst($booking->booking_status) }}</td>
        </tr>
        <tr>
            <th>Payment Status</th>
            <td>{{ ucfirst($booking->payment_status) }}</td>
        </tr>
        <tr>
            <th>Created At</th>
            <td>{{ $booking->created_at->format('d/m/Y H:i') }}</td>
        </tr>
        <tr>
            <th>Updated At</th>
            <td>{{ $booking->updated_at->format('d/m/Y H:i') }}</td>
        </tr>
    </table>

    <a href="{{ route('booking.edit', $booking->booking_id) }}" class="btn btn-warning">Chỉnh sửa</a>
    <a href="{{ route('booking.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
</div>


</body>
</html>