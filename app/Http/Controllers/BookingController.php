<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Services\PayOSService;

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
        return view('Booking.create');
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

        Booking::create($data);

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
}
