<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Tạo Booking mới</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-4">
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

            <input type="hidden" name="user_id" value="1">
            <input type="hidden" name="booking_status" value="pending">
            <input type="hidden" name="payment_status" value="unpaid">

            <!-- Chọn phim -->
            <div class="mb-3">
                <label for="movie_id" class="form-label">Chọn phim</label>
                <select name="movie_id" id="movie_id" class="form-select" required>
                    <option value="">-- Chọn phim --</option>
                    @foreach ($movies as $movie)
                        <option value="{{ $movie->movie_id }}">{{ $movie->title }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Chọn suất chiếu -->
            <div class="mb-3">
                <label for="showtime_id" class="form-label">Chọn suất chiếu</label>
                <select name="showtime_id" id="showtime_id" class="form-select" required>
                    <option value="">-- Chọn suất chiếu --</option>
                    @foreach ($showtimes as $show)
                        <option value="{{ $show->showtime_id }}" data-movie="{{ $show->movie_id }}">
                            {{ \Carbon\Carbon::parse($show->start_time)->format('H:i d/m/Y') }} - Phòng
                            {{ $show->room->room_name ?? 'N/A' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Ghế -->
            <div class="mb-3" id="seats-wrapper" style="display: none;">
                <label class="form-label">Chọn ghế</label>
                <div id="seats" class="row border rounded p-3 bg-light"></div>
            </div>

            <!-- Phương thức thanh toán -->
            <div class="mb-3">
                <label class="form-label">Phương thức thanh toán</label>
                <select name="payment_method" class="form-select" required>
                    <option value="cash">Tiền mặt</option>
                    <option value="payos">PayOS</option>
                    <option value="zalopay">zalo pay</option>
                </select>
            </div>

            <!-- Tổng tiền -->
            <div class="mb-3">
                <label class="form-label">Tổng tiền</label>
                <input type="number" name="total_price" id="total_price" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Lưu Booking</button>
            <a href="{{ route('booking.index') }}" class="btn btn-secondary">Hủy</a>
        </form>
    </div>

    <!-- JS -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const movieSelect = document.getElementById("movie_id");
            const showtimeSelect = document.getElementById("showtime_id");
            const seatsWrapper = document.getElementById("seats-wrapper");
            const seatsDiv = document.getElementById("seats");
            const totalPriceInput = document.getElementById("total_price");

            // Lọc suất chiếu theo phim
            movieSelect.addEventListener("change", function() {
                const selectedMovieId = this.value;

                Array.from(showtimeSelect.options).forEach(option => {
                    const movieId = option.getAttribute("data-movie");
                    if (!movieId || movieId === selectedMovieId) {
                        option.style.display = "";
                    } else {
                        option.style.display = "none";
                        option.selected = false;
                    }
                });

                showtimeSelect.value = "";
                seatsDiv.innerHTML = "";
                seatsWrapper.style.display = "none";
                totalPriceInput.value = "";
            });

            // Load ghế khi chọn suất chiếu
            showtimeSelect.addEventListener("change", function() {
                const showtimeId = this.value;
                console.log("Selected Showtime ID:", showtimeId);
                if (!showtimeId) {
                    seatsWrapper.style.display = "none";
                    seatsDiv.innerHTML = "";
                    totalPriceInput.value = "";
                    return;
                }

                fetch(`/seats/${showtimeId}`)
                    .then(res => res.json())
                    .then(seats => {
                        seatsDiv.innerHTML = "";
                        seatsWrapper.style.display = "block";

seats.forEach(seat => {
    const label = document.createElement("label");
    label.style = "width: 80px; margin: 5px; text-align: center;";
    label.className = "border rounded p-1";
    if (seat.status !== 'available') {
        label.classList.add("bg-secondary", "text-white");
    }

    const checkbox = document.createElement("input");
    checkbox.type = "checkbox";
    checkbox.name = "seats_id[]";
    checkbox.value = seat.seat_id;
    checkbox.dataset.price = seat.price;
    checkbox.disabled = seat.status !== 'available';
    checkbox.addEventListener("change", updateTotalPrice);

    label.appendChild(checkbox);

    const priceText = seat.price != null
        ? `${parseFloat(seat.price).toLocaleString()}đ`
        : "N/A";
    const statusText = seat.status === 'available' ? "" : "<br><small><i>Đã đặt</i></small>";

    label.innerHTML += `
        <br>Ghế ${seat.seat_id}
        <br><small>${seat.seat_type}</small>
        <br><small>${priceText}</small>
        ${statusText}
    `;

    seatsDiv.appendChild(label);
});

                    });
            });

            // Cập nhật tổng tiền
            function updateTotalPrice() {
                const checked = document.querySelectorAll('input[name="seats_id[]"]:checked');
                let total = 0;
                checked.forEach(cb => {
                    total += parseFloat(cb.dataset.price);
                });
                totalPriceInput.value = total;
            }
        });
    </script>
</body>

</html>
