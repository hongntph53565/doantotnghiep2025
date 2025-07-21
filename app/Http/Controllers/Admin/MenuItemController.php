<?php

namespace App\Http\Controllers\API;

use App\Models\MenuItem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index()
    {
        // Logic to get all menu items
        $menuItems = MenuItem::all();
        if ($menuItems->isEmpty()) {
            return response()->json([
                'message' => 'No menu items found',
                'success' => false,
                'data' => []
            ], 404);
        }
        return response()->json([
            'message' => 'Get all menu items successfully',
            'success' => true,
            'data' => $menuItems
        ], 200);
        return response()->json([
            'message' => 'Get all menu items successfully',
            'success' => true,
            'data' => [] // Replace with actual data
        ], 200);
    }

    public function show($id)
    {
        // Logic to get a specific menu item by ID
        $menuItem = MenuItem::find($id);
        if (!$menuItem) {
            return response()->json([
                'message' => "Menu item with ID $id not found",
                'success' => false,
                'data' => null
            ], 404);
        }
        return response()->json([
            'message' => "Get menu item with ID $id successfully",
            'success' => true,
            'data' => $menuItem
        ], 200);
    }
    public function store(Request $request)
    {
        // Logic to create a new menu item
        $request->validate([
            'item_name' => 'required|string|max:255',
            'is_combo' => 'required',
            'price' => 'required|numeric|min:0',
            'status' => 'required',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|max:2048'
        ]);

        $menuItem = MenuItem::create($request->all());

        return response()->json([
            'message' => 'Menu item created successfully',
            'success' => true,
            'data' => $menuItem
        ], 201);
    }
    public function update(Request $request, $id)
    {
        // Logic to update an existing menu item by ID
        $menuItem = MenuItem::find($id);
        if (!$menuItem) {
            return response()->json([
                'message' => "Menu item with ID $id not found",
                'success' => false,
                'data' => null
            ], 404);
        }

        $request->validate([
            'item_name' => 'sometimes|required|string|max:255',
            'is_combo' => 'sometimes|required|boolean',
            'price' => 'sometimes|required|numeric|min:0',
            'status' => 'sometimes|required|boolean',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|max:2048'
        ]);

        $menuItem->update($request->all());

        return response()->json([
            'message' => "Menu item with ID $id updated successfully",
            'success' => true,
            'data' => $menuItem
        ], 200);
    }
    public function delete($id)
    {
        // Logic to soft delete a menu item by ID
        $menuItem = MenuItem::find($id);
        if (!$menuItem) {
            return response()->json([
                'message' => "Menu item with ID $id not found",
                'success' => false,
                'data' => null
            ], 404);
        }

        $menuItem->delete();

        return response()->json([
            'message' => "Menu item with ID $id deleted successfully",
            'success' => true,
            'data' => null
        ], 200);
    }
    public function restore($id)
    {
        // Logic to restore a soft-deleted menu item by ID
        $menuItem = MenuItem::withTrashed()->find($id);
        if (!$menuItem) {
            return response()->json([
                'message' => "Menu item with ID $id not found",
                'success' => false,
                'data' => null
            ], 404);
        }

        $menuItem->restore();

        return response()->json([
            'message' => "Menu item with ID $id restored successfully",
            'success' => true,
            'data' => $menuItem
        ], 200);
    }
    public function forceDelete($id)
    {
        // Logic to permanently delete a menu item by ID
        $menuItem = MenuItem::withTrashed()->find($id);
        if (!$menuItem) {
            return response()->json([
                'message' => "Menu item with ID $id not found",
                'success' => false,
                'data' => null
            ], 404);
        }

        $menuItem->forceDelete();

        return response()->json([
            'message' => "Menu item with ID $id permanently deleted successfully",
            'success' => true,
            'data' => null
        ], 200);
    }
    public function getCombos()
    {
        // Logic to get all combos
        $combos = MenuItem::where('is_combo', true)->get();
        if ($combos->isEmpty()) {
            return response()->json([
                'message' => 'No combos found',
                'success' => false,
                'data' => []
            ], 404);
        }
        return response()->json([
            'message' => 'Get all combos successfully',
            'success' => true,
            'data' => $combos
        ], 200);
    }
    public function getCombo($id)
    {
        // Logic to get a specific combo by ID
        $combo = MenuItem::where('item_id', $id)->where('is_combo', true)->first();
        if (!$combo) {
            return response()->json([
                'message' => "Combo with ID $id not found",
                'success' => false,
                'data' => null
            ], 404);
        }
        return response()->json([
            'message' => "Get combo with ID $id successfully",
            'success' => true,
            'data' => $combo
        ], 200);
    }
}
