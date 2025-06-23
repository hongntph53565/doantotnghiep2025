<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Chỉnh sửa loại ghế – Phòng {{ $room->room_name }}</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .seat-card {
      width: 70px;
      height: 50px;
      padding: 4px;
      text-align: center;
      font-size: 0.8rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
    }
    .seat-card select {
      font-size: 0.7rem;
      padding: 1px;
      margin-top: 2px;
    }
    .seat-code {
      font-weight: 600;
      line-height: 1;
      user-select: none;
    }
  </style>
</head>
<body>
  <div class="container py-4">
    <h3 class="mb-4">Chỉnh sửa loại ghế – Phòng {{ $room->room_name }}</h3>
    <form action="{{ route('seat.update', $room->room_id) }}" method="POST">
      @csrf
      <div class="d-flex flex-wrap gap-2">
        @foreach ($seats as $seat)
          <div class="card seat-card shadow-sm">
            <div>
              <div class="seat-code">{{ $seat->seat_code }}</div>
              <input type="hidden" name="seats[{{ $loop->index }}][id]" value="{{ $seat->seat_id }}">
              <select name="seats[{{ $loop->index }}][seat_type]" class="form-select form-select-sm">
                <option value="standard" {{ $seat->seat_type == 'standard' ? 'selected' : '' }}>standard</option>
                <option value="vip" {{ $seat->seat_type == 'vip' ? 'selected' : '' }}>VIP</option>
                <option value="couple" {{ $seat->seat_type == 'couple' ? 'selected' : '' }}>couple</option>
              </select>
            </div>
          </div>
        @endforeach
      </div>
      <div class="mt-4 text-center">
        <button class="btn btn-primary px-5" type="submit">Cập nhật</button>
      </div>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
