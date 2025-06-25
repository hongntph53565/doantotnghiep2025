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
        <h1>Tạo Booking mới</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('booking.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="user_id" class="form-label">User ID</label>
                <input type="number" name="user_id" id="user_id" class="form-control" value="{{ old('user_id') }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="showtime_id" class="form-label">Showtime ID</label>
                <input type="number" name="showtime_id" id="showtime_id" class="form-control"
                    value="{{ old('showtime_id') }}" required>
            </div>

            <div class="mb-3">
                <label for="booking_status" class="form-label">Booking Status</label>
                <select name="booking_status" id="booking_status" class="form-control" required>
                    <option value="pending" {{ old('booking_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="confirmed" {{ old('booking_status') == 'confirmed' ? 'selected' : '' }}>Confirmed
                    </option>
                    <option value="cancelled" {{ old('booking_status') == 'cancelled' ? 'selected' : '' }}>Cancelled
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label for="payment_status" class="form-label">Payment Status</label>
                <select name="payment_status" id="payment_status" class="form-control" required>
                    <option value="unpaid" {{ old('payment_status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                    <option value="paid" {{ old('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="refunded" {{ old('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <select name="payment_method" id="payment_method" class="form-control" required>
                    <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash on Delivery
                        (COD)</option>
                    <option value="payos" {{ old('payment_method') == 'payos' ? 'selected' : '' }}>PayOS</option>
                    <option value="momo" {{ old('payment_method') == 'momo' ? 'selected' : '' }}>MoMo</option>
                </select>
            </div>


            <div class="mb-3">
                <label for="total_price" class="form-label">Tổng tiền (Total Price)</label>
                <input type="number" name="total_price" id="total_price" class="form-control"
                    value="{{ old('total_price') }}" required>
            </div>

            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('booking.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>

</body>

</html>
