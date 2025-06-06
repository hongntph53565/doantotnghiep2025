<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Services\PayOSService;
use Illuminate\Http\Request;

class BookingApiController extends Controller
{
    protected $payos;

    public function __construct(PayOSService $payos)
    {
        $this->payos = $payos;
    }

    public function index()
    {
        $bookings = Booking::with(['user', 'showtime'])->paginate(10);
        return response()->json($bookings);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'showtime_id' => 'required|exists:showtimes,showtime_id',
            'booking_status' => 'required|in:pending,confirmed,cancelled',
            'payment_method' => 'required|in:cash,payos,momo',
            'payment_status' => 'required|in:unpaid,paid',
            'booking_code' => 'required|unique:bookings,booking_code',
            'total_price' => 'required|numeric|min:1',
        ]);
        
        $data['booking_code'] = strtoupper(substr(md5(time()),0,9));

        $booking = Booking::create($data);

        if ($data["payment_method"] == "payos") {
            return response()->json([
                'message' => 'Redirect to PayOS',
                'redirect_url' => route('payos.create', [
                    'amount' => $data['total_price'],
                    'description' => $data['booking_code']
                ])
            ], 201);
        }

        return response()->json($booking, 201);
    }

    public function show($id)
    {
        $booking = Booking::with(['user', 'showtime'])->find($id);
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }
        return response()->json($booking);
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'showtime_id' => 'required|exists:showtimes,showtime_id',
            'booking_status' => 'required|in:pending,confirmed,cancelled',
            'payment_status' => 'required|in:unpaid,paid,refunded',
            'booking_code' => 'required|unique:bookings,booking_code,' . $booking->booking_id . ',booking_id',
        ]);

        $booking->update($validated);

        return response()->json([
            'message' => 'Booking updated successfully',
            'booking' => $booking
        ]);
    }

    public function destroy($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $booking->delete();

        return response()->json(['message' => 'Booking deleted successfully']);
    }
}
