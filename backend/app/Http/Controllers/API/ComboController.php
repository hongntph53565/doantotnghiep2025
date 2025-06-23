<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Combo;
use Illuminate\Http\Request;

class ComboController extends Controller
{
    public function index()
    {
        $combos  = Combo::all();
        return response()->json([
            'message' => 'Get all combos successfully',
            'success' => true,
            'data' => $combos
        ], 200);
    }

    public function show($id)
    {
        $combo = Combo::find($id);
        return response()->json([
            'message' => "Get combo with ID $id successfully",
            'success' => true,
            'data' => $combo
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:1000',
            'items' => 'required|array',
            'items.*.id' => 'required|integer|exists:items,id',
            'items.*.quantity' => 'required|integer|min:1'
        ]);
        return response()->json([
            'message' => 'Combo created successfully',
            'success' => true
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // Logic to update an existing combo by ID
        return response()->json([
            'message' => "Combo with ID $id updated successfully",
            'success' => true
        ], 200);
    }

    public function delete($id)
    {
        // Logic to soft delete a combo by ID
        return response()->json([
            'message' => "Combo with ID $id deleted successfully",
            'success' => true
        ], 200);
    }
}
