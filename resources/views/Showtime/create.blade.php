<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form action="{{ route('showtime.store') }}" method="POST">
        @csrf

        <div>
            <label for="movie_id">Chọn phim:</label>
            <select name="movie_id" id="movie_id" required>
                <option value="">-- Chọn phim --</option>
                @foreach ($movies as $movie)
                    <option value="{{ $movie->movie_id }}"
                        {{ old('movie_id') == $movie->movie_id || (isset($oldValue) && $oldValue->movie_id == $movie->movie_id) ? 'selected' : '' }}>
                        {{ $movie->title }}
                    </option>
                @endforeachPto
            </select>
            @error('movie_id')
                <div style="color:red">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="cinema_id">Chọn rạp chiếu:</label>
            <select name="cinema_id" id="cinema_id" required>
                <option value="">-- Chọn rạp --</option>
                @foreach ($cinemas as $cinema)
                    <option value="{{ $cinema->cinema_id }}">{{ $cinema->room_name }} - {{ $cinema->name }}</option>
                @endforeach
            </select>
            @error('room_id')
                <div style="color:red">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="room_id">Chọn phòng chiếu:</label>
            <select name="room_id" id="room_id" required>
                <option value="">-- Chọn phòng --</option>
               @foreach ($rooms as $room)
    <option value="{{ $room->room_id }}" data-cinema="{{ $room->cinema_id }}">
        {{ $room->room_name }}
    </option>
@endforeach
            </select>
            @error('room_id')
                <div style="color:red">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="show_date">Ngày chiếu:</label>
            <input type="date" name="show_date" id="show_date"
                value="{{ old('show_date') ?? ($oldValue->show_date ?? '') }}" required>
            @error('show_date')
                <div style="color:red">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="price">Giá vé (VNĐ):</label>
            <input type="number" name="price" id="price" min="0"
                value="{{ old('price') ?? ($oldValue->price ?? '') }}" required>
            @error('price')
                <div style="color:red">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="status">Trạng thái:</label>
            <select name="status" id="status" required>
                <option value="">-- Chọn trạng thái --</option>
                <option value="active"
                    {{ old('status') == 'active' || (isset($oldValue) && $oldValue->status == 'active') ? 'selected' : '' }}>
                    Active</option>
                <option value="inactive"
                    {{ old('status') == 'inactive' || (isset($oldValue) && $oldValue->status == 'inactive') ? 'selected' : '' }}>
                    Inactive</option>
            </select>
            @error('status')
                <div style="color:red">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">{{ isset($oldValue) ? 'Cập nhật lịch chiếu' : 'Tạo lịch chiếu mới' }}</button>
    </form>
    @vite(['resources/js/custom/Showtime/showtime.js'])
</body>

</html>
