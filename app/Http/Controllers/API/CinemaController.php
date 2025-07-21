<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin\Cinema;
use Illuminate\Http\Request;

class CinemaController extends Controller
{
    public function index()
    {
        return response()->json(Cinema::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'address_detail' => 'required',
            'ward' => 'required|max:100',
            'district' => 'required|max:100',
            'city' => 'required|max:100',
            'phone' => 'required|max:20',
            'email' => 'required|email',
        ]);

        $cinema = Cinema::create($request->all());

        return response()->json($cinema, 201);
    }

    public function show($id)
    {
        $cinema = Cinema::findOrFail($id);
        return response()->json($cinema);
    }

    public function update(Request $request, $id)
    {
        $cinema = Cinema::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|required|max:255',
            'address_detail' => 'sometimes|required',
            'ward' => 'sometimes|required|max:100',
            'district' => 'sometimes|required|max:100',
            'city' => 'sometimes|required|max:100',
            'phone' => 'sometimes|required|max:20',
            'email' => 'sometimes|required|email',
        ]);

        $cinema->update($request->all());

        return response()->json($cinema);
    }

    public function destroy($id)
    {
        $cinema = Cinema::findOrFail($id);
        $cinema->delete();

        return response()->json(['message' => 'Cinema deleted successfully.']);
    }
}
