<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Booking;

class StaffScanController extends Controller
{
public function index()
    {
        // Trả về view chứa camera quét QR
        return view('staff.scan');
    }

    // app/Http/Controllers/Staff/TicketScanController.php

// public function find(Request $request)
// {
//     $code = trim((string)$request->input('code'));

//     $user = Auth::user();

// if (!$user || !$user->cinema_id) {
//     return response()->json(['status' => 'error', 'message' => 'Bạn không có quyền thực hiện thao tác này.'], 403);
// }

// $cinemaId = $user->cinema_id;

//     if ($code === '') {
//         return response()->json(['status' => 'error', 'message' => 'Thiếu mã vé'], 422);
//     }

//     // bóc code nếu là URL...
//     if (filter_var($code, FILTER_VALIDATE_URL)) {
//         $p = parse_url($code);
//         if (!empty($p['query'])) { parse_str($p['query'], $q); $code = $q['code'] ?? $q['booking_code'] ?? $code; }
//         elseif (!empty($p['path'])) { $parts = array_values(array_filter(explode('/', $p['path']))); if ($parts) $code = end($parts); }
//     }
//     $code = preg_replace('/\s+/u', '', $code);

//     $with = [
//         'user',
//         'showtime.movie',
//         'showtime.room.cinema',
//         'foods',
//         'bookingSeats.showtimeSeat.seat',
//     ];
//     // nếu có khai báo quan hệ printedBy thì load để lấy tên
//     if (method_exists(Booking::class, 'printedBy')) {
//         $with[] = 'printedBy:id,full_name,name';
//     }

//     // $booking = \App\Models\Booking::with($with)
//     //     ->where('booking_code', $code)
//     //     ->first();

//         $booking = Booking::with($with)
//     ->where('booking_code', $code)
//     ->where(function ($q) use ($cinemaId) {
//         $q->whereHas('showtime.room', function ($sub) use ($cinemaId) {
//             $sub->where('cinema_id', $cinemaId);
//         })
//         ->orWhereHas('foods', function ($sub) use ($cinemaId) {
//             $sub->where('cinema_id', $cinemaId);
//         });
//     })
//     ->first();

//     // if (!$booking) {
//     //     return response()->json(['status' => 'error', 'message' => 'Không tìm thấy vé']);
//     // }

//     $rawBooking = Booking::with($with)->where('booking_code', $code)->first();

// if (!$rawBooking) {
//     return response()->json([
//         'status' => 'error',
//         'message' => '❌ Vé không tồn tại trong hệ thống.'
//     ]);
// }

// $booking = Booking::with($with)
//     ->where('booking_code', $code)
//     ->where(function ($q) use ($cinemaId) {
//         $q->whereHas('showtime.room', function ($sub) use ($cinemaId) {
//             $sub->where('cinema_id', $cinemaId);
//         })
//         ->orWhereHas('foods', function ($sub) use ($cinemaId) {
//             $sub->where('cinema_id', $cinemaId);
//         });
//     })
//     ->first();

// if (!$booking) {
//     return response()->json([
//         'status' => 'error',
//         'message' => '⚠️ Vé này không thuộc về rạp của bạn.'
//     ]);
// }


//     $movie  = $booking->showtime?->movie;
//     $room   = $booking->showtime?->room;
//     $cinema = $room?->cinema;

//     // seats qua bookingSeats -> showtimeSeat -> seat
//     $seats = collect($booking->bookingSeats ?? [])
//         ->map(fn($bs) => $bs->showtimeSeat?->seat?->seat_code)
//         ->filter()->values()->all();

//     $foods = collect($booking->foods ?? [])->map(fn($f) => [
//         'id' => $f->id,
//         'name' => $f->name,
//         'quantity' => $f->pivot->quantity ?? null,
//     ])->values()->all();

//     // map đường dẫn ảnh trong storage
//     $banner = $movie?->banner ? asset('storage/poster/'.$movie->banner) : null;
//     $poster = $movie?->poster ? asset('storage/'.$movie->poster) : null;

//     // thông tin in ấn
//     $printedCount = (int)($booking->printed_count ?? 0);
//     $printedAt    = optional($booking->printed_at)->toDateTimeString();
//     $printedById  = $booking->printed_by ?? null;
//     $printedByName = null;
//     if (isset($booking->printedBy)) {
//         $printedByName = $booking->printedBy->full_name ?? $booking->printedBy->name ?? null;
//     }

// $detailUrl = url("staff/staff/booking/{$booking->booking_id}");
// $printUrl  = url("staff/staff/booking/{$booking->booking_id}/print");

//     return response()->json([
//         'status' => 'ok',
//         'booking' => [
//             'booking_id'     => $booking->booking_id,
//             'booking_code'   => $booking->booking_code,
//             'booking_status' => $booking->booking_status,
//             'checked_in_at'  => optional($booking->checked_in_at)->toDateTimeString(),
//             'printed_count'  => $printedCount,
//             'printed_at'     => $printedAt,
//             'printed_by'     => $printedById,
//             'printed_by_name'=> $printedByName, // có thể null nếu không load quan hệ
//             'user' => [
//                 'full_name' => $booking->user->full_name ?? $booking->user->name ?? null,
//             ],
//             'showtime' => [
//                 'date'       => $booking->showtime?->date,
//                 'start_time' => $booking->showtime?->start_time,
//                 'room' => [
//                     'name'   => $room?->room_name,
//                     'cinema' => ['name' => $cinema?->name],
//                 ],
//                 'movie' => [
//                     'title'  => $movie?->title,
//                     'banner' => $banner,
//                     'poster' => $poster,
//                 ],
//             ],
//         ],
//         'related' => [
//             'seats' => array_map(fn($c) => ['seat_code' => $c], $seats),
//             'foods' => $foods,
//             'detail_url' => $detailUrl,
//             'print_url'  => $printUrl,
//         ],
//     ]);
// }

public function find(Request $request)
{
    $code = trim((string)$request->input('code'));
    $user = Auth::user();

    if (!$user || !$user->cinema_id) {
        return response()->json(['status' => 'error', 'message' => 'Bạn không có quyền thực hiện thao tác này.'], 403);
    }

    $cinemaId = $user->cinema_id;

    if ($code === '') {
        return response()->json(['status' => 'error', 'message' => 'Thiếu mã vé'], 422);
    }

    // bóc code nếu là URL...
    if (filter_var($code, FILTER_VALIDATE_URL)) {
        $p = parse_url($code);
        if (!empty($p['query'])) {
            parse_str($p['query'], $q);
            $code = $q['code'] ?? $q['booking_code'] ?? $code;
        } elseif (!empty($p['path'])) {
            $parts = array_values(array_filter(explode('/', $p['path'])));
            if ($parts) $code = end($parts);
        }
    }
    $code = preg_replace('/\s+/u', '', $code);

    $with = [
        'user',
        'showtime.movie',
        'showtime.room.cinema',
        'foods',
        'bookingSeats.showtimeSeat.seat',
    ];
    if (method_exists(Booking::class, 'printedBy')) {
        $with[] = 'printedBy:id,full_name,name';
    }

    // 1. Kiểm tra vé có tồn tại trong hệ thống không
    $rawBooking = Booking::with($with)->where('booking_code', $code)->first();
    if (!$rawBooking) {
        return response()->json([
            'status' => 'error',
            'message' => '❌ Vé không tồn tại trong hệ thống.'
        ]);
    }

    // 2. Kiểm tra vé có thuộc rạp user quản lý không
    $booking = Booking::with($with)
        ->where('booking_code', $code)
        ->where(function ($q) use ($cinemaId) {
            $q->whereHas('showtime.room', function ($sub) use ($cinemaId) {
                $sub->where('cinema_id', $cinemaId);
            })
            ->orWhereHas('foods', function ($sub) use ($cinemaId) {
                $sub->where('cinema_id', $cinemaId);
            });
        })
        ->first();

    if (!$booking) {
        return response()->json([
            'status' => 'error',
            'message' => '⚠️ Vé này không thuộc về rạp của bạn.'
        ]);
    }

    // -------- Mapping dữ liệu trả về --------
    $movie  = $booking->showtime?->movie;
    $room   = $booking->showtime?->room;
    $cinema = $room?->cinema;

    $seats = collect($booking->bookingSeats ?? [])
        ->map(fn($bs) => $bs->showtimeSeat?->seat?->seat_code)
        ->filter()->values()->all();

    $foods = collect($booking->foods ?? [])->map(fn($f) => [
    'id'       => $f->id,
    'name'     => $f->name,
    'quantity' => $f->pivot->quantity ?? 0,
    'price'    => (int) ($f->pivot->price ?? 0),
    'image'    => $f->image ? asset('storage/'.$f->image) : null,

])->values()->all();

    $banner = $movie?->banner ? asset('storage/poster/'.$movie->banner) : null;
    $poster = $movie?->poster ? asset('storage/'.$movie->poster) : null;

    $printedCount = (int)($booking->printed_count ?? 0);
    $printedAt    = optional($booking->printed_at)->toDateTimeString();
    $printedById  = $booking->printed_by ?? null;
    $printedByName = $booking->printedBy->full_name ?? $booking->printedBy->name ?? null ?? null;

    $detailUrl = url("staff/staff/booking/{$booking->booking_id}");
    $printUrl  = url("staff/staff/booking/{$booking->booking_id}/print");

    return response()->json([
        'status' => 'ok',
        'booking' => [
            'booking_id'     => $booking->booking_id,
            'booking_code'   => $booking->booking_code,
            'booking_status' => $booking->booking_status,
            'checked_in_at'  => optional($booking->checked_in_at)->toDateTimeString(),
            'printed_count'  => $printedCount,
            'printed_at'     => $printedAt,
            'printed_by'     => $printedById,
             'printed_by_name'=> $booking->printer?->full_name ?? $booking->printer?->name,
            'user' => [
                'full_name' => $booking->user->full_name ?? $booking->user->name ?? null,
            ],
            'showtime' => [
                'date'       => $booking->showtime?->date,
                'start_time' => $booking->showtime?->start_time,
                'room' => [
                    'room_name'   => $room?->room_name,
                    'cinema' => ['name' => $cinema?->name],
                ],
                'movie' => [
                    'title'  => $movie?->title,
                    'banner' => $banner,
                    'poster' => $poster,
                ],
            ],
        ],
        'related' => [
            'seats' => array_map(fn($c) => ['seat_code' => $c], $seats),
            'foods' => $foods,
            'detail_url' => $detailUrl,
            'print_url'  => $printUrl,
        ],
    ]);
}


}
