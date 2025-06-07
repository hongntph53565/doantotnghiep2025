<?php

namespace App\Http\Controllers;

use App\Models\Cinema;
use App\Models\Movie;
use App\Models\Room;
use App\Models\Showtime;
use Exception;
use Illuminate\Http\Request;

class ShowtimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $showTime = Showtime::all();
        return view('Showtime.list', compact('showTime'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $movies = Movie::select('movie_id', 'title')->get();
        $rooms = Room::select('room_id', 'room_name', 'cinema_id')->get();
        $cinemas = Cinema::all();
        return view('Showtime.create', compact('movies', 'rooms', 'cinemas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'movie_id'   => 'required|exists:movies,movie_id',
            'cinema_id'  => 'required|exists:cinemas,cinema_id',
            'room_id'    => 'required|exists:rooms,room_id',
            'show_date'  => 'required|date|after_or_equal:today',
            'price'      => 'required|integer|min:1000',
            'status'     => 'required|in:active,inactive',
        ]);

        try {
            Showtime::create($data);
            return redirect("/Showtime");
        } catch (Exception $e) {
            $logPath = storage_path('logs/RoomsLogs');
            if (!file_exists($logPath)) {
                mkdir($logPath, 0755, true);
            }
            $dateName = date("d-m-Y");
            file_put_contents($dateName . '_logs.txt', $e->getMessage() . "\n", FILE_APPEND);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $movies = Movie::select('movie_id', 'title')->get();
        $rooms = Room::select('room_id', 'room_name', 'cinema_id')->get();
        $cinemas = Cinema::all();
        $showtime = Showtime::with(['room.cinema'])->find($id);
        return view('Showtime.edit', compact('movies', 'rooms', 'cinemas', 'showtime'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'movie_id'   => 'required|exists:movies,movie_id',
            'cinema_id'  => 'required|exists:cinemas,cinema_id',
            'room_id'    => 'required|exists:rooms,room_id',
            'show_date'  => 'required|date|after_or_equal:today',
            'price'      => 'required|integer|min:1000',
            'status'     => 'required|in:active,inactive',
        ]);

        try {
             $showtime = Showtime::find($id);

            if (!$showtime) {
                return redirect()->back()->withErrors(['error' => 'Phòng không tồn tại']);
            }

            $showtime->update($data);

        } catch (Exception $e) {
            $logPath = storage_path('logs/RoomsLogs');
            if (!file_exists($logPath)) {
                mkdir($logPath, 0755, true);
            }
            $dateName = date("d-m-Y");
            file_put_contents($dateName . '_logs.txt', $e->getMessage() . "\n", FILE_APPEND);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(string $id)
    {
        try {
             $showtime = Showtime::findOrFail($id);

            if (!$showtime) {
                return redirect()->back()->withErrors(['error' => 'Phòng không tồn tại']);
            }

            $showtime->delete();

        } catch (Exception $e) {
            $logPath = storage_path('logs/RoomsLogs');
            if (!file_exists($logPath)) {
                mkdir($logPath, 0755, true);
            }
            $dateName = date("d-m-Y");
            file_put_contents($dateName . '_logs.txt', $e->getMessage() . "\n", FILE_APPEND);
        }
    }

    public function dele(){
               return view('Showtime.delete');
    }
}
