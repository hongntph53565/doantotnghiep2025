<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật lịch chiếu</title>
</head>

<body>
    <form action="{{ route('showtime.update', ['id' => $showtime->showtime_id]) }}" method="POST">
        @csrf

        <div>
            <label for="movie_id">Chọn phim:</label>
            <select name="movie_id" id="movie_id" required>
                <option value="">-- Chọn phim --</option>
                @foreach ($movies as $movie)
                    <option value="{{ $movie->movie_id }}"
                        {{ old('movie_id', $showtime->movie_id) == $movie->movie_id ? 'selected' : '' }}>
                        {{ $movie->title }}
                    </option>
                @endforeach
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
                    <option value="{{ $cinema->cinema_id }}"
                        {{ old('cinema_id', $showtime->room->cinema->cinema_id) == $cinema->cinema_id ? 'selected' : '' }}>
                        {{ $cinema->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="room_id">Chọn phòng chiếu:</label>
            <select name="room_id" id="room_id" required>
                <option value="">-- Chọn phòng --</option>
                @foreach ($rooms as $room)
                    <option value="{{ $room->room_id }}" data-cinema="{{ $room->cinema_id }}"
                        {{ old('room_id', $showtime->room_id) == $room->room_id ? 'selected' : '' }}>
                        {{ $room->room_name }}
                    </option>
                @endforeach
            </select>
            @error('room_id')
                <div style="color:red">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="start_time">Thời gian bắt đầu:</label>
            <input type="datetime-local" name="start_time" id="start_time"
                value="{{ old('start_time', \Carbon\Carbon::parse($showtime->start_time)->format('Y-m-d\TH:i')) }}"
                required>
            @error('start_time')
                <div style="color:red">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="end_time">Thời gian kết thúc:</label>
            <input type="datetime-local" name="end_time" id="end_time"
                value="{{ old('end_time', \Carbon\Carbon::parse($showtime->end_time)->format('Y-m-d\TH:i')) }}">
            @error('end_time')
                <div style="color:red">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="price">Giá vé (VNĐ):</label>
            <input type="number" name="price" id="price" min="1000"
                value="{{ old('price', $showtime->price) }}" required>
            @error('price')
                <div style="color:red">{{ $message }}</div>
            @enderror
        </div>

        <div>
            <label for="status">Trạng thái:</label>
            <select name="status" id="status" required>
                <option value="">-- Chọn trạng thái --</option>
                <option value="active" {{ old('status', $showtime->status) == 'active' ? 'selected' : '' }}>Active</option>
                <option value="cancelled" {{ old('status', $showtime->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                <option value="sold_out" {{ old('status', $showtime->status) == 'sold_out' ? 'selected' : '' }}>Sold Out</option>
            </select>
            @error('status')
                <div style="color:red">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit">Cập nhật lịch chiếu</button>
    </form>

    <script>
        const cinemaSelect = document.getElementById('cinema_id');
        const roomSelect = document.getElementById('room_id');

        function filterRooms() {
            const selectedCinemaId = cinemaSelect.value;
            const options = roomSelect.querySelectorAll('option');

            options.forEach(option => {
                if (!option.value) return;
                const roomCinema = option.getAttribute('data-cinema');
                option.style.display = roomCinema === selectedCinemaId ? 'block' : 'none';
            });
        }

        cinemaSelect.addEventListener('change', filterRooms);
        window.addEventListener('DOMContentLoaded', filterRooms);
    </script>
</body>

</html>
