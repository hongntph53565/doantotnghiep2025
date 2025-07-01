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
    <h3>Danh sách phòng chiếu</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID phòng</th>
                <th>Tên phòng</th>
                <th>Rạp</th>
                <th>Số ghế</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rooms as $room)
            <tr>
                <td>{{ $room->room_id }}</td>
                <td>{{ $room->room_name }}</td>
                <td>{{ $room->cinema->name ?? 'Chưa có rạp' }}</td>
                <td>{{ $room->total_seats }}</td>
                <td>
                    <a href="{{ route('seat.edit', $room->room_id) }}" class="btn btn-sm btn-primary">Chỉnh ghế</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>


</body>
</html>