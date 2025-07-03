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
    <h1>Chỉnh sửa Booking #{{ $booking->booking_id }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('booking.update', $booking->booking_id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="user_id" class="form-label">User ID</label>
            <input type="number" name="user_id" id="user_id" class="form-control" value="{{ old('user_id', $booking->user_id) }}" required>
        </div>

        <div class="mb-3">
            <label for="showtime_id" class="form-label">Showtime ID</label>
            <input type="number" name="showtime_id" id="showtime_id" class="form-control" value="{{ old('showtime_id', $booking->showtime_id) }}" required>
        </div>

        <div class="mb-3">
            <label for="booking_status" class="form-label">Booking Status</label>
            <select name="booking_status" id="booking_status" class="form-control" required>
                <option value="pending" {{ (old('booking_status', $booking->booking_status) == 'pending') ? 'selected' : '' }}>Pending</option>
                <option value="confirmed" {{ (old('booking_status', $booking->booking_status) == 'confirmed') ? 'selected' : '' }}>Confirmed</option>
                <option value="cancelled" {{ (old('booking_status', $booking->booking_status) == 'cancelled') ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="payment_status" class="form-label">Payment Status</label>
            <select name="payment_status" id="payment_status" class="form-control" required>
                <option value="unpaid" {{ (old('payment_status', $booking->payment_status) == 'unpaid') ? 'selected' : '' }}>Unpaid</option>
                <option value="paid" {{ (old('payment_status', $booking->payment_status) == 'paid') ? 'selected' : '' }}>Paid</option>
                <option value="refunded" {{ (old('payment_status', $booking->payment_status) == 'refunded') ? 'selected' : '' }}>Refunded</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="booking_code" class="form-label">Booking Code</label>
            <input type="text" name="booking_code" id="booking_code" class="form-control" value="{{ old('booking_code', $booking->booking_code) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('booking.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>


</body>
</html>