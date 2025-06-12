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
    <h1>Chi tiết khuyến mãi{{ $promotion->discount_code }}</h1>

    <table class="table table-bordered">
        <tr>
            <th>Discount Percent</th>
            <td>{{ $promotion->promotion_code }}</td>
        </tr>
        <tr>
            <th>Discount Cost</th>
            <td>{{ $promotion->discount_amount?? 'No use cost' }}</td>
        </tr>

        <tr>
            <th>Promotion Status</th>
            <td>{{ $promotion->status }}</td>
        </tr>
        <tr>
            <th>Start Date</th>
            <td>{{ $promotion->start_date }}</td>
        </tr>
        <tr>
            <th>End Date</th>
            <td>{{ $promotion->end_date}}</td>
        </tr>
    </table>

    <a href="{{ route('promotion.edit', $promotion->promo_id) }}" class="btn btn-warning">Chỉnh sửa</a>
    <a href="{{ route('promotion.index') }}" class="btn btn-secondary">Quay lại danh sách</a>
</div>


</body>
</html>
