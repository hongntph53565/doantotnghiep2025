<?php

namespace App\Http\Controllers;

use App\Models\ExtraPrice;
use Illuminate\Http\Request;

class ExtraPriceApiController extends Controller
{
    public function index()
    {
        return response()->json(ExtraPrice::all());
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'day_type'   => 'required|in:weekday,weekend,holiday',
            'date'       => 'nullable|date',
            'percentage' => 'required|integer|min:0|max:100',
            'description'=> 'nullable|string|max:255',
        ]);

        $extraPrice = ExtraPrice::create($data);
        return response()->json($extraPrice, 201);
    }

    public function show($id)
    {
        $extraPrice = ExtraPrice::findOrFail($id);
        return response()->json($extraPrice);
    }

    public function update(Request $request, $id)
    {
        $extraPrice = ExtraPrice::findOrFail($id);
        $data = $request->validate([
            'day_type'   => 'sometimes|in:weekday,weekend,holiday',
            'date'       => 'nullable|date',
            'percentage' => 'sometimes|integer|min:0|max:100',
            'description'=> 'nullable|string|max:255',
        ]);

        $extraPrice->update($data);
        return response()->json($extraPrice);
    }

    public function destroy($id)
    {
        $extraPrice = ExtraPrice::findOrFail($id);
        $extraPrice->delete();
        return response()->json(['message' => 'Deleted successfully']);
    }
}
