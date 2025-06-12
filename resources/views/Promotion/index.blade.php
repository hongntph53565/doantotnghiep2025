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

    <a href="{{ route('booking.create') }}" class="btn btn-primary mb-3">Tạo mã khuyến mãi</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Discount Code</th>
                <th>Discount Percent</th>
                <th>Discount Cost</th>
                <th>Status</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($promotions as $promotion)
            <tr>
                <td>{{ $promotion->promo_id }}</td>
                <td>{{ $promotion->discount_code }}</td>
                <td>{{ $promotion->discount_percentage}}</td>
                <td>{{ $promotion->discount_amount}}</td>
                <td>{{ $promotion->status }}</td>
                <td>{{ $promotion->start_date}}</td>
                <td>{{ $promotion->end_date}}</td>
                <td>
                    <a href="{{ route('promotion.show', $promotion->promotion_id) }}" class="btn btn-info btn-sm">Xem</a>
                    <a href="{{ route('promotion.edit', $promotion->promotion_id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <form action="{{ route('promotion.delete', $promotion->promotion_id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Bạn có chắc muốn xóa?')" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $promotions->links() }}
</div>

</body>
</html>
