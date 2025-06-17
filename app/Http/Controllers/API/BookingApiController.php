<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Movie;
use App\Models\Showtime;
use App\Models\ShowtimeSeat;
use App\Services\BookingService;
use Illuminate\Http\Request;
use App\Services\PayOSService;
use Illuminate\Support\Facades\DB;

class BookingApiController extends Controller
{

    public function __construct()
    {
    }

    public function index()
    {
        $bookings = Booking::with(['user', 'showtime'])->paginate(10);
        return response()->json($bookings, 200);
    }

    public function createData()
    {
        // API version của create() chỉ đơn giản trả về dữ liệu cần thiết
        $movies = Movie::all();
        $showtimes = Showtime::with('room')->get();
        $seats = ShowtimeSeat::all();
        return response()->json(compact('movies', 'showtimes', 'seats'), 200);
    }

    public function store(Request $request, BookingService $bookingService)
    {
        try {
            $data = $request->validate([
                'user_id' => 'required|exists:users,user_id',
                'showtime_id' => 'required|exists:showtimes,showtime_id',
                'booking_status' => 'required|in:pending,confirmed,cancelled',
                'payment_method' => 'required|in:cash,payos,zalopay,vnpay',
                'payment_status' => 'required|in:unpaid,paid',
                'booking_code' => 'nullable|unique:bookings,booking_code',
                'total_price' => 'required|numeric|min:1',
                'seats_id' => 'required|array',
            ]);

            $data['booking_code'] = strtoupper(substr(md5(time()), 0, 9));
            $booking = Booking::create($data);

            $bookingService->createSeats($booking, $data['seats_id']);

            // Trả về thông tin thanh toán nếu cần redirect
            if ($data["payment_method"] == "payos") {
                $payosUrl = route('payos.create', [
                    'amount' => $data['total_price'],
                    'description' => $data['booking_code']
                ]);
                return response()->json(['payment_url' => $payosUrl], 200);
            }

            if ($data["payment_method"] == "zalopay") {
                $zalopayUrl = route('zalopay.create', [
                    'amount' => $data['total_price'],
                    'description' => $data['booking_code']
                ]);
                return response()->json(['payment_url' => $zalopayUrl], 200);
            }

            if ($data["payment_method"] == "vnpay") {
                $VnpayUrl = route('vnpay.create', [
                    'amount' => $data['total_price'],
                    'description' => $data['booking_code']
                ]);
                return response()->json(['payment_url' => $VnpayUrl], 200);
            }

            return response()->json($booking, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        $booking = Booking::with(['user', 'showtime'])->find($id);

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        return response()->json($booking, 200);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'showtime_id' => 'required|exists:showtimes,showtime_id',
            'booking_status' => 'required|in:pending,confirmed,cancelled',
            'payment_status' => 'required|in:unpaid,paid,refunded',
            'booking_code' => 'required|unique:bookings,booking_code,' . $booking->booking_id . ',booking_id',
        ]);

        $booking->update($validated);

        return response()->json(['message' => 'Booking updated successfully'], 200);
    }

    public function delete($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json(['error' => 'Booking not found'], 404);
        }

        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully'], 200);
    }

    public function getSeatsByShowtime($showtime_id)
    {
        $showtime = Showtime::with('room.seats')->find($showtime_id);

        if (!$showtime || !$showtime->room) {
            return response()->json(['error' => 'Showtime hoặc Room không tồn tại!'], 404);
        }

        $seats = $showtime->room->seats->map(function ($seat) use ($showtime_id) {
            $isBooked = DB::table('showtime_seats')
                ->where('showtime_id', $showtime_id)
                ->where('seat_id', $seat->id)
                ->exists();

            return [
                'id' => $seat->id,
                'seat_id' => $seat->seat_id,
                'seat_type' => $seat->seat_type,
                'price' => $seat->price,
                'status' => $isBooked ? 'booked' : 'available',
            ];
        });

        return response()->json($seats, 200);
    }
}
