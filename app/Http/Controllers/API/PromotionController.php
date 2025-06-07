<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion; // Assuming you have a Promotion model

class PromotionController extends Controller
{
    public function index()
    {
        $promotions = Promotion::all();
        return response()->json([
            'promotions' => $promotions,
            'message' => 'Get all promotions successfully',
            'success' => true
        ], 200);
    }

    public function show($id)
    {
        $promotion = Promotion::find($id);
        if (!$promotion) {
            return response()->json([
                'message' => 'Promotion not found',
                'success' => false
            ], 404);
        }
        return response()->json([
            'promotion' => $promotion,
            'message' => 'Get promotion successfully',
            'success' => true
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'discount_code' => 'required|string|max:255',
            'discount_percentage' => 'required|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $promotion = Promotion::create($request->all());

        return response()->json([
            'promotion' => $promotion,
            'message' => 'Promotion created successfully',
            'success' => true
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $promotion = Promotion::find($id);
        if (!$promotion) {
            return response()->json([
                'message' => 'Promotion not found',
                'success' => false
            ], 404);
        }

        $request->validate([
            'discount_code' => 'sometimes|required|string|max:255',
            'discount_percentage' => 'sometimes|required|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'start_date' => 'sometimes|required|date',
            'end_date' => 'sometimes|required|date|after_or_equal:start_date',
        ]);

        $promotion->update($request->all());

        return response()->json([
            'promotion' => $promotion,
            'message' => 'Promotion updated successfully',
            'success' => true
        ], 200);
    }

    public function destroy($id)
    {
        $promotion = Promotion::find($id);

        if (!$promotion) {
            return response()->json([
                'message' => 'Promotion not found',
                'success' => false
            ], 404);
        }

        $promotion->delete();

        return response()->json([
            'message' => 'Promotion deleted (soft delete) successfully',
            'success' => true
        ], 200);
    }

    public function restore($id)
{
    $promotion = Promotion::withTrashed()->find($id);

    if (!$promotion) {
        return response()->json([
            'message' => 'Promotion not found',
            'success' => false
        ], 404);
    }

    $promotion->restore();

    return response()->json([
        'message' => 'Promotion restored successfully',
        'success' => true
    ]);
}

}
