<?php

namespace App\Http\Controllers\Staff;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Cinema;
use App\Models\Showtime;
use Carbon\Carbon;
use App\Models\Booking;
use Barryvdh\DomPDF\Facade\Pdf;
// use Milon\Barcode\Facades\DNS1D;
use Milon\Barcode\Facades\DNS1DFacade as DNS1D;
use Milon\Barcode\DNS2D;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;






class BookingController extends Controller
{
    public function step1(Request $request)
{
    $movie = Movie::with('genre')->findOrFail($request->movie_id);
    $movie_id = $movie->movie_id;

    $cinemas = Cinema::with(['rooms.showtimes' => function ($query) use ($movie_id) {
        $query->where('movie_id', $movie_id)
              ->where('date', '>=', Carbon::today())
              ->orderBy('date')
              ->orderBy('start_time');
    }])->whereHas('rooms.showtimes', function ($query) use ($movie_id) {
        $query->where('movie_id', $movie_id)
              ->where('date', '>=', Carbon::today());
    })->get();

    return view('staff.booking1', compact('movie', 'cinemas'));
}



// public function printView($id)
// {
//     $booking = Booking::with([
//         'user',
//         'showtime.movie',
//         'showtime.room.cinema',
//         'foods',
//         'bookingSeats.showtimeSeat.seat'
//     ])->findOrFail($id);

//     $cinema = $booking->showtime->room->cinema ?? null;

//     $dns2d = new DNS2D();
//     $dns2d->setStorPath(public_path('cache/'));

//     $barcode = base64_encode(
//         $dns2d->getBarcodePNG($booking->booking_code, 'QRCODE', 8, 8)
//     );

//     return view('pdf.ticket', compact('booking', 'barcode', 'cinema'));
// }
public function printView(Request $request, $id)
{
    $booking = Booking::with([
        'user',
        'showtime.movie',
        'showtime.room.cinema',
        'foods',
        'bookingSeats.showtimeSeat.seat'
    ])->findOrFail($id);

    if ($booking->printed_count > 0 && !$request->boolean('reprint')) {
        return back()->with('error', 'Đơn này đã được in trước đó. Thêm ?reprint=1 để in lại.');
    }

    $dns2d = new DNS2D();
    $dns2d->setStorPath(public_path('cache/'));
    $barcode = base64_encode($dns2d->getBarcodePNG($booking->booking_code, 'QRCODE', 8, 8));

    $markPrintedUrl = route('staff.bookings.markPrinted', $booking->booking_id);

    $cinema = $booking->showtime?->room?->cinema;

return view('pdf.ticket', compact('booking', 'barcode', 'markPrintedUrl', 'cinema'));
}

public function markPrinted(Request $request, $id)
{
    $booking = Booking::findOrFail($id);

    // Lấy ID nhân viên hiện tại (tùy bạn đang dùng user_id hay id)
    $uid = Auth::user()->user_id ?? Auth::id();

    // Tăng số lần in, set printed_by là người vừa in
    $updates = [
        'printed_count' => DB::raw('printed_count + 1'),
        'printed_by'    => $uid,
        // Nếu muốn chỉ set printed_at lần đầu:
        // 'printed_at' => $booking->printed_at ? $booking->printed_at : now(),
    ];

    // Nếu muốn mỗi lần in đều ghi thời gian in gần nhất, dùng:
    // $updates['printed_at'] = now();

    if (is_null($booking->printed_at)) {
        $updates['printed_at'] = now();
    }

    Booking::where('booking_id', $id)->update($updates);

    $booking->refresh();

    return response()->json([
        'ok'            => true,
        'printed_count' => $booking->printed_count,
        'printed_at'    => optional($booking->printed_at)->toDateTimeString(),
        'printed_by'    => $booking->printed_by,
    ]);
}


    public function step2(Request $request)
    {
        // Logic xử lý tiếp theo
        return view('staff.booking2');
    }
}