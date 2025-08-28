@extends('layouts.admin')

@section('title', 'Danh sách hóa đơn')

@section('title2')
    Hóa đơn
@endsection

@section('title1')
    Hóa đơn
@endsection

@push('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endpush

@section('content')
    <div class="filter-section container">
        <form method="GET" action="{{ route('bills.index') }}">
            <div class="row g-2 align-items-center">

                <!-- City -->
                <div class="col">
                    <select name="city" class="form-select">
                        <option value="">Tất cả khu vực</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->city }}" {{ request('city') == $city->city ? 'selected' : '' }}>
                                {{ $city->city }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <select name="cinema" class="form-select">
                        <option value="">Tất cả rạp</option>
                        @foreach ($selectedCinemas as $cinema)
                            <option value="{{ $cinema->cinema_id }}"
                                {{ request('cinema') == $cinema->cinema_id ? 'selected' : '' }}>
                                {{ $cinema->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col">
                    <select name="room" class="form-select">
                        <option value="">Tất cả phòng chiếu</option>
                        @foreach ($selectedRooms as $room)
                            <option value="{{ $room->room_id }}" {{ request('room') == $room->room_id ? 'selected' : '' }}>
                                {{ $room->room_name }}
                            </option>
                        @endforeach
                    </select>


                </div>
                <div class="col">
                    <select name="movie" class="form-select">
                        <option value="">Tất cả phim</option>
                        @foreach ($selectedMovies as $movie)
                            <option value="{{ $movie->movie_id }}"
                                {{ request('movie') == $movie->movie_id ? 'selected' : '' }}>
                                {{ $movie->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col"><input type="date" name="date" class="form-control"></div>
                <div class="col">
                    <select name="status" class="form-select">
                        <option value="">Trạng thái</option>
                        <option value="printed" {{ request('status') == 'printed' ? 'selected' : '' }}>Đã xuất vé</option>
                        <option value="not_printed" {{ request('status') == 'not_printed' ? 'selected' : '' }}>Chưa xuất vé
                        </option>
                    </select>
                </div>
                <div class="col-auto"><button type="submit" class="btn btn-primary">Lọc</button></div>
        </form>

    </div>


    <div class="container mt-4">
       
        <div class="row mb-3">
            <div class="col d-flex justify-content-end">
                <form method="GET" action="" class="input-group" style="max-width: 285px;">
                    <input type="text" name="search" value="{{ $search ?? '' }}" class="form-control"
                        placeholder="Search...">
                    <button class="btn btn-primary" type="submit">Tìm</button>
                </form>
            </div>
        </div>

   
        <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>Mã vé</th>
                    <th>Thông tin người dùng</th>
                    <th>Phim</th>
                    <th>Thông tin vé</th>
                    <th>Chức năng</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr>
                        <td class="align-middle text-center">{{ $booking->booking_code }}</td>

                      
                        <td class="align-middle text-start">
                            <b>Người dùng:</b> {{ $booking->user->full_name ?? 'N/A' }} <br>
                            <b>Email:</b> {{ $booking->user->email ?? 'N/A' }} <br>
                            <b>Phương thức thanh toán:</b> {{ $booking->payment_method ?? 'N/A' }}
                        </td>

                       
                        <td>
                            @if ($booking->showtime_id)
                             
                                <img src="{{ $booking->showtime?->movie?->poster
                                    ? asset('storage/' . $booking->showtime->movie->poster)
                                    : 'https://via.placeholder.com/100' }}"
                                    alt="Poster" width="100">
                            @elseif($booking->bookingFoods->count())
                               
                                @foreach ($booking->bookingFoods as $bf)
                                    <img src="{{ $bf->food->image ? asset('storage/' . $bf->food->image) : 'https://via.placeholder.com/100' }}"
                                        alt="{{ $bf->food->name }}" width="100">
                                @endforeach
                            @endif
                        </td>

                        <td class="align-middle text-start">
                            @if ($booking->showtime_id)
                               
                                <b>Phim:</b> {{ $booking->showtime->movie->title ?? 'N/A' }} <br>
                                <b>Rạp:</b> {{ $booking->showtime->room->cinema->name ?? 'N/A' }} <br>
                                <b>Nơi chiếu:</b> {{ $booking->showtime->room->cinema->city ?? 'N/A' }} -
                                {{ $booking->showtime->room->cinema->ward ?? 'N/A' }} -
                                {{ $booking->showtime->room->cinema->district ?? 'N/A' }} -
                                {{ $booking->showtime->room->room_name ?? 'N/A' }} <br>
                                <b>Ghế:</b>
                                @if ($booking->seats->count())
                                    {{ $booking->seats->pluck('seat_code')->join(', ') }}
                                @else
                                    N/A
                                @endif <br>
                                <b>Tổng tiền:</b> {{ number_format($booking->total_price, 0, ',', '.') }} VND <br>
                                <b>Trạng thái:</b>
                                @if ($booking->printed_count > 0)
                                    <span class="badge bg-success">Đã xuất vé</span>
                                @else
                                    <span class="badge bg-warning">Chưa xuất vé</span>
                                @endif <br>
                                <b>Lịch chiếu:</b>
                                {{ $booking->showtime?->start_time ? \Carbon\Carbon::parse($booking->showtime->start_time)->format('H:i') : '' }}
                                -
                                {{ $booking->showtime?->end_time ? \Carbon\Carbon::parse($booking->showtime->end_time)->format('H:i') : '' }}
                                <br>
                                <b>Thời gian sử dụng:</b>
                                {{ $booking->showtime?->end_time ? \Carbon\Carbon::parse($booking->showtime->end_time)->format('H:i') : '' }}
                                -
                                {{ $booking->showtime?->date ? \Carbon\Carbon::parse($booking->showtime->date)->format('d/m/Y') : '' }}
                                <br>
                            @elseif($booking->bookingFoods->count())
                                {{-- Đơn đồ ăn --}}
                                @foreach ($booking->bookingFoods as $bf)
                                    <b>Món ăn:</b> {{ $bf->food->name ?? 'N/A' }} <br>
                                    <b>Số lượng:</b> {{ $bf->quantity }} <br>
                                    <b>Giá:</b> {{ number_format($bf->food->price ?? 0, 0, ',', '.') }} VND <br>
                                    <b>Trạng thái:</b>
                                    @if ($booking->printed_count > 0)
                                        <span class="badge bg-success">Đã xuất vé</span>
                                    @else
                                        <span class="badge bg-warning">Chưa xuất vé</span>
                                    @endif <br>
                                    <b>Rạp:</b>
                                    {{ $bf->food->cinema_id ? \App\Models\Cinema::find($bf->food->cinema_id)->name : 'N/A' }}
                                    <br>
                                    <b>Tổng tiền:</b>
                                    {{ number_format($bf->quantity * ($bf->food->price ?? 0), 0, ',', '.') }} VND <br>
                                @endforeach
                            @endif
                        </td>


                        <!-- Chức năng -->
                        <td class="align-middle text-center">
                            <a href="{{ route('bills.show', $booking->booking_id) }}" class="btn btn-sm btn-primary">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>

                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            @if (request('search'))
                                Không tìm thấy kết quả cho từ khóa "<b>{{ request('search') }}</b>"
                            @else
                                Không có dữ liệu
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>

        </table>

        <div class="d-flex justify-content-end">
            {{ $bookings->appends(request()->except('page'))->links() }}
        </div>

    </div>
@endsection

@push('scripts')
@endpush
