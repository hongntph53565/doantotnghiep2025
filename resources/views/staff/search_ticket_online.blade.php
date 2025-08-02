@extends('layouts.staff')

@section('title', 'Vé Online')

@push('styles')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
  <link rel="stylesheet" href="{{ asset('css/home.css') }}">
@endpush

@section('content')

<style>
    form {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    input[type="text"] {
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 8px;
        min-width: 180px;
        font-size: 14px;
    }

    button {
        padding: 8px 16px;
        background-color: #3490dc;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s;
    }

    button:hover {
        background-color: #2779bd;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    th, td {
        padding: 10px;
        border: 1px solid #ddd;
        text-align: center;
    }

    th {
        background-color: #f8f9fa;
        font-weight: bold;
    }

    tbody tr:nth-child(even) {
        background-color: #f1f1f1;
    }

    tbody tr:hover {
        background-color: #e2e8f0;
    }
</style>

@if (session('error'))
    <div style="color: red; margin-bottom: 10px;">
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('staff.search_ticket_online') }}" method="GET" class="mb-4">
    <input type="text" name="query" placeholder="Nhập mã vé, tên khách hàng hoặc ngày chiếu..." value="{{ request('query') }}">
    <button type="submit">Tìm kiếm</button>
</form>

@if ($bookings->count())
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Người đặt</th>
                <th>Tên phim</th>
                <th>Ngày chiếu</th>
                <th>Mã vé</th>
                <th>Trạng thái</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->booking_id }}</td>
                    <td>{{ $booking->user->full_name ?? 'Không rõ' }}</td>
                    <td>{{ $booking->showtime->movie->title ?? 'Đơn đồ ăn' }}</td>
                    <td>{{ $booking->showtime->date ?? '' }}</td>
                    <td>{{ $booking->booking_code }}</td>
                    <td>{{ $booking->booking_status }}</td>
                    <td>
                        <a href="{{ route('staff.booking.print', $booking->booking_id) }}" target="_blank">
                            <button>In vé</button>
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Nếu có phân trang --}}
    @if (method_exists($bookings, 'links'))
        <div class="mt-3 d-flex justify-content-center">
            {{ $bookings->appends(['query' => request('query')])->links() }}
        </div>
    @endif

@else
    <p class="text-muted">Không tìm thấy kết quả phù hợp.</p>
@endif

@endsection
