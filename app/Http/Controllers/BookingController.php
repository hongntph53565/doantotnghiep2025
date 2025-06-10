<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Movie;
use App\Models\Showtime;
use App\Models\ShowtimeSeat;
use App\Services\BookingService;
use Illuminate\Http\Request;
use App\Services\PayOSService;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{

    protected $payos;

    public function __construct(PayOSService $payos)
    {
        $this->payos = $payos;
    }

    public function index()
    {
        $bookings = Booking::with(['user', 'showtime'])->paginate(10);
        return view('Booking.index', compact('bookings'));
    }

    public function create()
    {
        $movies = Movie::all();
    $showtimes = Showtime::with('room')->get();
    $seats = ShowtimeSeat::all();
        return view('Booking.create', compact('movies', 'showtimes', 'seats'));
    }

    public function store(Request $request,BookingService $bookingService)
    {
        $data = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'showtime_id' => 'required|exists:showtimes,showtime_id',
            'booking_status' => 'required|in:pending,confirmed,cancelled',
            'payment_method' => 'required|in:cash,payos,momo',
            'payment_status' => 'required|in:unpaid,paid',
            'booking_code' => 'unique:bookings,booking_code',
            'total_price' => 'required|numeric|min:1',
            'seats_id' => 'required|array',
        ]);

        $data['booking_code'] = strtoupper(substr(md5(time()),0,9));
        $booking = Booking::create($data);

        $bookingService->createSeats($booking, $data['seats_id']);

        if ($data["payment_method"] == "payos") {
            return redirect()->route('payos.create', [
                'amount' => $data['total_price'],
                'description' => $data['booking_code']
            ]);
        }
    }


    public function show($id)
    {
        $booking = Booking::with(['user', 'showtime'])->findOrFail($id);
        return view('Booking.show', compact('booking'));
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return view('Booking.edit', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id',
            'showtime_id' => 'required|exists:showtimes,showtime_id',
            'booking_status' => 'required|in:pending,confirmed,cancelled',
            'payment_status' => 'required|in:unpaid,paid,refunded',
            'booking_code' => 'required|unique:bookings,booking_code,' . $booking->booking_id . ',booking_id',
        ]);

        $booking->update($validated);

        return redirect()->route('booking.index')->with('success', 'Booking updated successfully.');
    }

    public function delete($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->delete();

        return redirect()->route('booking.index')->with('success', 'Booking deleted successfully.');
    }

public function getSeatsByShowtime($showtime_id)
{
    $showtime = Showtime::with('room.seats')->findOrFail($showtime_id);

    if (!$showtime->room) {
        return response()->json(['error' => 'Showtime không có phòng!'], 500);
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

    return response()->json($seats);
}


}
