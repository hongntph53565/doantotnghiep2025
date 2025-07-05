<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CinemaSeatTypePrice;
use Illuminate\Support\Facades\Validator;

class CinemaSeatTypePriceApiController extends Controller
{
    public function index()
    {
        $prices = CinemaSeatTypePrice::with(['cinema', 'seatType'])->get();
        return response()->json($prices);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cinema_id'    => 'required|exists:cinemas,cinema_id',
            'seat_type_id' => 'required|exists:seat_types,seat_type_id',
            'price'        => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $price = CinemaSeatTypePrice::create($request->only(['cinema_id', 'seat_type_id', 'price']));

        return response()->json($price, 201);
    }

    public function show($id)
    {
        $price = CinemaSeatTypePrice::with(['cinema', 'seatType'])->find($id);

        if (!$price) {
            return response()->json(['message' => 'Not found'], 404);
        }

        return response()->json($price);
    }

    public function update(Request $request, $id)
    {
        $price = CinemaSeatTypePrice::find($id);

        if (!$price) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'cinema_id'    => 'sometimes|exists:cinemas,cinema_id',
            'seat_type_id' => 'sometimes|exists:seat_types,seat_type_id',
            'price'        => 'sometimes|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $price->update($request->only(['cinema_id', 'seat_type_id', 'price']));

        return response()->json($price);
    }

    public function destroy($id)
    {
        $price = CinemaSeatTypePrice::find($id);

        if (!$price) {
            return response()->json(['message' => 'Not found'], 404);
        }

        $price->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
