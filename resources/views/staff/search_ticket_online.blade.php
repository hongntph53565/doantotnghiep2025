@extends('layouts.staff')

@section('title', 'Vé Online')

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')




<form action="{{ route('staff.search') }}" method="GET" class="mb-4">
    <input type="text" name="booking_id" placeholder="Mã vé" value="{{ request('booking_id') }}">
    <input type="text" name="last_name" placeholder="tên khách hàng" value="{{ request('last_name') }}">
    <input type="text" name="show_date" placeholder="Ngày chiếu" value="{{ request('show_date') }}">


    <button type="submit">Tìm kiếm</button>
</form>

{{-- Hiển thị danh sách vé --}}
@if (isset($bookings))

<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Người đặt</th>
            <th>Tên phim</th>
            <th>Ngày chiếu</th>
            <th>Giờ chiếu</th>
            <th>Ghế</th>
            <th>Trạng thái</th>
            <th>Ngày đặt</th>
        </tr>
    </thead>
    <tbody>
        @foreach($bookings as $booking)
            <tr>
                <td>{{ $booking->id }}</td>
                <td>{{ $booking->user->last_name ?? 'Không rõ' }}</td>
                <td>{{ $booking->showtime->movie->title ?? 'Không rõ' }}</td>
                <td>{{ $booking->showtime->date ?? '' }}</td>
                <td>{{ $booking->showtime->start_time ?? '' }}</td>
                <td>{{ $booking->seat_number }}</td>
                <td>{{ $booking->status }}</td>
                <td>{{ $booking->created_at->format('d/m/Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $bookings->withQueryString()->links() }}

@endif



@endsection
