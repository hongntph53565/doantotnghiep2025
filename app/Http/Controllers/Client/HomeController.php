<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Showtime;
use App\Models\Food;
use App\Models\Cinema;
use App\Models\ShowtimeSeat;
use App\Models\Booking;
use App\Models\Promotion;
use App\Models\MembershipCard;


use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{
    public function home()
    {
        $today = Carbon::now()->toDateString();

        // Phim đang chiếu
        $moviesNow = Movie::with('genre')
            ->whereDate('release_date', '<=', $today)
            ->orderBy('release_date', 'desc')
            ->get();

        // Phim sắp chiếu
        $moviesComing = Movie::with('genre')
            ->whereDate('release_date', '>', $today)
            ->orderBy('release_date', 'asc')
            ->get();

        // Xử lý trailer cho cả 2 danh sách
        foreach ([$moviesNow, $moviesComing] as $movieList) {
            foreach ($movieList as $movie) {
                if (!empty($movie->trailer) && Str::contains($movie->trailer, 'watch?v=')) {
                    $videoId = explode('watch?v=', $movie->trailer)[1];
                    $movie->trailer = 'https://www.youtube.com/embed/' . $videoId;
                }
            }
        }

        return view('Client.home', compact('moviesNow', 'moviesComing'));
    }



    // {
//     $movie = Movie::with('genre')->findOrFail($movie_id);
//     $date = $request->input('date', now()->toDateString());

    //     $query = Showtime::with('room.cinema')
//         ->where('movie_id', $movie_id)
//         ->where('status', 'active')
//         ->whereDate('date', Carbon::parse($date)->toDateString());

    //     $showtimes = $query
//         ->orderBy('start_time')
//         ->get()
//         ->groupBy(fn($item) => $item->room->cinema->cinema_id);

    //     $selectedShowtimeId = $request->input('showtime_id');
//     $selectedShowtime = null;
//     $seats = collect();
//     $foods = collect();
//     $step = 0;


    //     if ($selectedShowtimeId) {
//         // Chuyển hướng nếu chưa đăng nhập
//         if (!Auth::check()) {
//             return redirect()->route('register.form')->with('message', 'Vui lòng đăng ký hoặc đăng nhập để tiếp tục đặt vé.');
//         }



    //         $selectedShowtime = Showtime::with(['room.cinema', 'room.seats.seatType', 'movie'])->find($selectedShowtimeId);

    //         if ($selectedShowtime && $selectedShowtime->room) {
//             $seats = $selectedShowtime->room->seats;
//             $step = 1;

    //             $cinemaId = $selectedShowtime->room->cinema_id;
//             $foods = Food::where('cinema_id', $cinemaId)
//                 ->where('status', 'active')
//                 ->get()
//                 ->groupBy('type');
//         }
//     }



    //     return view('Client.booking.home', compact(
//         'movie',
//         'showtimes',
//         'selectedShowtimeId',
//         'selectedShowtime',
//         'seats',
//         'step',
//         'foods'
//     ));
// }




    //    public function booking(Request $request, $movie_id)
// {
//     $movie = Movie::with('genre')->findOrFail($movie_id);
//     $date = $request->input('date', now()->toDateString());

    //     // 🔹 Lấy thành phố đã chọn từ session
//     $selectedCity = Session::get('selected_city');


    //     // 🔹 Query lọc suất chiếu theo phim, ngày và thành phố (nếu có)
//     $query = Showtime::with('room.cinema')
//         ->where('movie_id', $movie_id)
//         ->where('status', 'active')
//         ->whereDate('date', Carbon::parse($date)->toDateString());

    //    if ($selectedCity) {
//     $query->whereHas('room.cinema', function ($q) use ($selectedCity) {
//         $q->whereRaw('LOWER(city) = ?', [strtolower($selectedCity)]);
//     });
// }

    //     $showtimes = $query
//         ->orderBy('start_time')
//         ->get()
//         ->groupBy(fn($item) => $item->room->cinema->cinema_id);

    //     // 🔸 Các phần khác giữ nguyên
//     $promotions = Promotion::where('status', 'active')
//         ->whereDate('start_date', '<=', now())
//         ->whereDate('end_date', '>=', now())
//         ->get();

    //     $selectedShowtimeId = $request->input('showtime_id');
//     $selectedShowtime = null;
//     $seats = collect();
//     $foods = collect();
//     $step = 0;
//     $showtimeSeatStatuses = [];

    //     if ($selectedShowtimeId) {
//         if (!Auth::check()) {
//             return redirect()->route('register.form')->with('message', 'Vui lòng đăng ký hoặc đăng nhập để tiếp tục đặt vé.');
//         }

    //         $selectedShowtime = Showtime::with(['room.cinema', 'room.seats.seatType', 'movie'])->find($selectedShowtimeId);

    //         if ($selectedShowtime && $selectedShowtime->room) {
//             $seats = $selectedShowtime->room->seats;
//             $step = 1;

    //             $showtimeSeatStatuses = \App\Models\ShowtimeSeat::where('showtime_id', $selectedShowtime->showtime_id)
//                 ->pluck('status', 'seat_id')
//                 ->toArray();

    //             $cinemaId = $selectedShowtime->room->cinema_id;
//             $foods = Food::where('cinema_id', $cinemaId)
//                 ->where('status', 'active')
//                 ->get()
//                 ->groupBy('type');
//         }
//     }

    //     return view('Client.booking.home', compact(
//         'movie',
//         'showtimes',
//         'selectedShowtimeId',
//         'selectedShowtime',
//         'seats',
//         'step',
//         'foods',
//         'showtimeSeatStatuses',
//         'promotions',
//         'selectedCity'
//     ));
// }

    public function booking(Request $request, $movie_id)
    {
        $movie = Movie::with('genre')->findOrFail($movie_id);
        $date = $request->input('date', now()->toDateString());

        $selectedCity = trim(strtolower(Session::get('selected_city')));

        $query = Showtime::with([
            'room' => function ($q) {
                $q->with('cinema');
            }
        ])
            ->where('movie_id', $movie_id)
            ->where('status', 'active')
            ->whereDate('date', Carbon::parse($date)->toDateString());

        if ($selectedCity) {
            $query->whereHas('room.cinema', function ($q) use ($selectedCity) {
                $q->whereRaw('LOWER(city) LIKE ?', ['%' . strtolower($selectedCity) . '%']);
            });
        }

        $showtimes = $query->orderBy('start_time')->get()
            ->groupBy(fn($item) => $item->room->cinema->cinema_id);

        $user = Auth::user();
        $userCardType = null;

        // Nếu user đã đăng nhập, lấy card_type từ bảng membership_cards
        if ($user) {
            $card = MembershipCard::where('user_id', $user->user_id)->first();
            $userCardType = $card ? $card->card_type : null;
        }

        // Lấy các voucher còn hiệu lực và áp dụng cho loại thẻ của user
        $promotions = Promotion::where('status', 'active')
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->where(function ($query) use ($userCardType) {
                $query->whereNull('card_type'); // voucher áp dụng cho tất cả thẻ
                if ($userCardType) {
                    $query->orWhere('card_type', $userCardType); // voucher dành riêng cho loại thẻ
                }
            })
            ->get();

        $selectedShowtimeId = $request->input('showtime_id');
        $selectedShowtime = null;
        $seats = collect();
        $foods = collect();
        $step = 0;
        $showtimeSeatStatuses = [];

        if ($selectedShowtimeId) {
            if (!Auth::check()) {
                return redirect()->route('register.form')->with('message', 'Vui lòng đăng ký hoặc đăng nhập để tiếp tục đặt vé.');
            }

            $selectedShowtime = Showtime::with(['room.cinema', 'room.seats.seatType', 'movie'])->find($selectedShowtimeId);

            if ($selectedShowtime && $selectedShowtime->room) {
                $seats = $selectedShowtime->room->seats;
                $step = 1;

                $showtimeSeatStatuses = \App\Models\ShowtimeSeat::where('showtime_id', $selectedShowtime->showtime_id)
                    ->pluck('status', 'seat_id')
                    ->toArray();

                $cinemaId = $selectedShowtime->room->cinema_id;
                $foods = Food::where('cinema_id', $cinemaId)
                    ->where('status', 'active')
                    ->get()
                    ->groupBy('type');
            }
        }

        return view('Client.booking.home', compact(
            'movie',
            'showtimes',
            'selectedShowtimeId',
            'selectedShowtime',
            'seats',
            'step',
            'foods',
            'showtimeSeatStatuses',
            'promotions',
            'selectedCity'
        ));
    }
    public function fetchSeatStatuses($id)
    {
        $statuses = ShowtimeSeat::where('showtime_id', $id)
            ->pluck('status', 'seat_id');

        return response()->json($statuses);
    }




    public function setCity($city)
    {
        session(['selected_city' => $city]);
        return redirect()->back();
    }

    public function ShowtimesByCinema(Request $request, $cinema_id)
    {
        $date = $request->input('date', now()->toDateString());
        $nowVN = Carbon::now('Asia/Ho_Chi_Minh');
        $selectedCity = session('selected_city');

        // Lấy thông tin rạp
        $cinema = Cinema::findOrFail($cinema_id);

        // Nếu rạp không thuộc thành phố đã chọn → quay lại danh sách rạp
        if ($cinema->city !== $selectedCity) {
            return redirect()->route('Client.cinemaShowtime')
                ->with('warning', 'Rạp này không nằm trong khu vực bạn đã chọn. Vui lòng chọn rạp khác.');
        }

        // Truy vấn suất chiếu của rạp
        $query = Showtime::with(['room.cinema', 'movie'])
            ->whereHas('room.cinema', function ($q) use ($cinema_id, $selectedCity) {
                $q->where('cinema_id', $cinema_id)
                    ->where('city', $selectedCity);
            })
            ->where('status', 'active')
            ->whereDate('date', Carbon::parse($date)->toDateString());

        // Nếu hôm nay, chỉ lấy những suất chưa chiếu
        if ($date === $nowVN->toDateString()) {
            $query->whereTime('start_time', '>=', $nowVN->toTimeString());
        }

        // Lấy và group theo movie_id
        $showtimes = $query
            ->orderBy('start_time')
            ->get()
            ->groupBy(fn($item) => $item->movie->movie_id);

        return view('Client.MovieShowtimesByCinema', compact('cinema', 'showtimes', 'date'));
    }






    // public function MovieShowtimes()
    // {
    //     $selectedCity = session('selected_city');
    //     $today = Carbon::today();


    //     $movieIds = Showtime::whereHas('room.cinema', function ($q) use ($selectedCity) {
    //         $q->where('city', $selectedCity);
    //     })
    //         ->pluck('movie_id')
    //         ->unique();


    //     $nowShowing = Movie::with('genre')
    //         ->whereIn('movie_id', $movieIds)
    //         ->whereDate('release_date', '<=', $today)
    //         ->orderBy('release_date', 'desc')
    //         ->get();


    //     $comingSoon = Movie::with('genre')
    //         ->whereNotIn('movie_id', $movieIds)
    //         ->whereDate('release_date', '>', $today)
    //         ->orderBy('release_date', 'asc')
    //         ->get();

    //     return view('Client.MovieShowtimes', compact('nowShowing', 'comingSoon'));
    // }
    public function MovieShowtimes()
    {
        $selectedCity = session('selected_city');
        $today = Carbon::today();

        // Lấy tất cả phim đang chiếu theo release_date
        $nowShowing = Movie::with('genre')
            ->whereDate('release_date', '<=', $today)
            ->orderBy('release_date', 'desc')
            ->get();

        // Lấy tất cả phim sắp chiếu theo release_date
        $comingSoon = Movie::with('genre')
            ->whereDate('release_date', '>', $today)
            ->orderBy('release_date', 'asc')
            ->get();

        return view('Client.MovieShowtimes', compact('nowShowing', 'comingSoon', 'selectedCity'));
    }




    public function loadShowtimes(Request $request)
    {
        $movie_id = $request->input('movie_id');
        $date = $request->input('date');

        $movie = Movie::with('genre')->findOrFail($movie_id);

        $query = Showtime::with('room.cinema')
            ->where('movie_id', $movie_id)
            ->where('status', 'active');

        if ($date) {
            $query->whereDate('date', Carbon::parse($date)->toDateString());
        }

        $showtimes = $query
            ->orderBy('start_time')
            ->get()
            ->groupBy(fn($item) => $item->room->cinema->cinema_id);

        return view('Client.booking.steps.select_showtime', compact('movie', 'showtimes'))->render();
    }
    public function ajaxShowtimes(Request $request)
    {
        $movieId = $request->input('movie_id');
        $date = $request->input('date');
        $nowVN = Carbon::now('Asia/Ho_Chi_Minh');

        $selectedCity = strtolower(trim(Session::get('selected_city')));

        $query = Showtime::with(['room.cinema', 'movie'])
            ->where('movie_id', $movieId)
            ->where('status', 'active')
            ->whereDate('date', Carbon::parse($date)->toDateString());

       
        if (Auth::check() && Auth::user()->role_id == 3 && Auth::user()->cinema_id) {
            $cinemaId = Auth::user()->cinema_id;
            $query->whereHas('room.cinema', function ($q) use ($cinemaId) {
                $q->where('cinema_id', $cinemaId);
            });
        }
       
        elseif (!empty($selectedCity)) {
            $query->whereHas('room.cinema', function ($q) use ($selectedCity) {
                $q->whereRaw('LOWER(city) LIKE ?', ['%' . $selectedCity . '%']);
            });
        }

        
        if ($date === $nowVN->toDateString()) {
            $query->whereTime('start_time', '>=', $nowVN->toTimeString());
        }

        $showtimes = $query
            ->orderBy('start_time')
            ->get()
            ->groupBy(function ($item) {
                return $item->room->cinema_id;
            });

        return view('ajax.showtimes', [
            'showtimes' => $showtimes,
            'movie' => Movie::find($movieId),
            'selectedCity' => $selectedCity,
        ]);
    }


    public function ajaxShowtimesByCinema(Request $request)
    {
        $cinemaId = $request->input('cinema_id');
        $date = $request->input('date', now()->toDateString());

        $nowVN = Carbon::now('Asia/Ho_Chi_Minh');
        $selectedCity = strtolower(trim(Session::get('selected_city'))); 

        $query = Showtime::with(['room.cinema', 'movie'])
            ->whereHas('room', function ($q) use ($cinemaId) {
                $q->where('cinema_id', $cinemaId);
            })
            ->where('status', 'active')
            ->whereDate('date', Carbon::parse($date)->toDateString());

        if ($date === $nowVN->toDateString()) {
            $query->whereTime('start_time', '>=', $nowVN->toTimeString());
        }

        $showtimes = $query
            ->orderBy('start_time')
            ->get()
            ->groupBy(fn($item) => $item->movie->movie_id);

        return view('ajax.showtimes-by-cinema', [
            'showtimes' => $showtimes,
            'selectedCity' => $selectedCity, 
        ])->render();
    }
    public function about_us()
    {
        return view('Client.about_us');
    }

    public function recruitment()
    {
        return view('Client.recruitment');
    }
    public function importantNotice()
    {
        return view('Client.notice'); 
    }

    public function faq()
    {
        return view('Client.faq');
    }



}