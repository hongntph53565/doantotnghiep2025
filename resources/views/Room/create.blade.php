<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>create</title>
</head>
<body>
    <form action="{{ route('rooms.store') }}" method="POST">
    @csrf

    <div>
        <label for="cinema_id">Chọn rạp chiếu (Cinema):</label>
        <select name="cinema_id" id="cinema_id" required>
            <option value="">-- Chọn rạp --</option>
            @foreach ($cinemas as $cinema)
                <option value="{{ $cinema->cinema_id }}">{{ $cinema->name }}</option>
            @endforeach
        </select>
        @error('cinema_id')
            <div style="color:red">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="room_name">Tên phòng:</label>
        <input type="text" name="room_name" id="room_name" value="{{ old('room_name') }}" required>
        @error('room_name')
            <div style="color:red">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="total_seats">Tổng số ghế:</label>
        <input type="number" name="total_seats" id="total_seats" value="{{ old('total_seats') }}" required min="1">
        @error('total_seats')
            <div style="color:red">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit">Tạo phòng mới</button>
</form>

</body>
</html>