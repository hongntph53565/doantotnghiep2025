<form action="{{ route('showtime.store') }}" method="POST">
    @csrf

    <div>
        <label for="movie_id">Chọn phim:</label>
        <select name="movie_id" id="movie_id" required>
            <option value="">-- Chọn phim --</option>
            @foreach ($movies as $movie)
                <option value="{{ $movie->movie_id }}"
                    {{ old('movie_id') == $movie->movie_id ? 'selected' : '' }}>
                    {{ $movie->title }}
                </option>
            @endforeach
        </select>
        @error('movie_id')
            <div style="color:red">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="room_id">Chọn phòng chiếu:</label>
        <select name="room_id" id="room_id" required>
            <option value="">-- Chọn phòng --</option>
            @foreach ($rooms as $room)
                <option value="{{ $room->room_id }}"
                    {{ old('room_id') == $room->room_id ? 'selected' : '' }}>
                    {{ $room->room_name }} (Rạp: {{ $room->cinema->name ?? 'Chưa có rạp' }})
                </option>
            @endforeach
        </select>
        @error('room_id')
            <div style="color:red">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="start_time">Giờ bắt đầu chiếu:</label>
        <input type="datetime-local" name="start_time" id="start_time"
            value="{{ old('start_time') }}" required>
        @error('start_time')
            <div style="color:red">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="end_time">Giờ kết thúc chiếu:</label>
        <input type="datetime-local" name="end_time" id="end_time"
            value="{{ old('end_time') }}" required>
        @error('end_time')
            <div style="color:red">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="price">Giá vé (VNĐ):</label>
        <input type="number" name="price" id="price" min="1000"
            value="{{ old('price') }}" required>
        @error('price')
            <div style="color:red">{{ $message }}</div>
        @enderror
    </div>

    <div>
        <label for="status">Trạng thái:</label>
        <select name="status" id="status" required>
            <option value="">-- Chọn trạng thái --</option>
            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            <option value="sold_out" {{ old('status') == 'sold_out' ? 'selected' : '' }}>Sold Out</option>
        </select>
        @error('status')
            <div style="color:red">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit">Tạo lịch chiếu mới</button>
</form>
 