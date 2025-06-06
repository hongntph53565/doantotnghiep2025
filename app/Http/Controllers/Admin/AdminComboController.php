<?php

namespace App\Http\Controllers\Admin;

use App\Models\Combo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminComboController extends Controller
{
    public function index()
    {
        try {
            $combos = Combo::all();
            return response()->json($combos, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to retrieve combos: ' . $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $combo = Combo::findOrFail($id);
            return response()->json($combo, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Combo not found: ' . $e->getMessage()], 404);
        }
    }
    public function store(Request $request)
    {
        try {
            $combo = Combo::create($request->all());
            return response()->json($combo, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create combo: ' . $e->getMessage()], 500);
        }
    }
    public function update(Request $request, $id)
    {
        try {
            $combo = Combo::findOrFail($id);
            $combo->update($request->all());
            return response()->json($combo, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update combo: ' . $e->getMessage()], 500);
        }
    }
    public function destroy($id)
    {
        try {
            $combo = Combo::findOrFail($id);
            $combo->delete();
            return response()->json(['message' => 'Combo deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete combo: ' . $e->getMessage()], 500);
        }
    }
    public function search(Request $request)
    {
        try {
            $query = $request->input('query');
            $combos = Combo::where('name', 'LIKE', '%' . $query . '%')->get();
            return response()->json($combos, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Search failed: ' . $e->getMessage()], 500);
        }
    }
    public function filter(Request $request)
    {
        try {
            $filters = $request->all();
            $query = Combo::query();

            if (isset($filters['name'])) {
                $query->where('name', 'LIKE', '%' . $filters['name'] . '%');
            }
            if (isset($filters['price_min'])) {
                $query->where('price', '>=', $filters['price_min']);
            }
            if (isset($filters['price_max'])) {
                $query->where('price', '<=', $filters['price_max']);
            }

            $combos = $query->get();
            return response()->json($combos, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Filter failed: ' . $e->getMessage()], 500);
        }
    }
}
