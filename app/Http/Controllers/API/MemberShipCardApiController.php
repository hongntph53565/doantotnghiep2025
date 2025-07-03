<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MemberShipCard;
use Illuminate\Http\Request;

class MemberShipCardApiController extends Controller
{
    // GET /api/membership-cards
    public function index()
    {
        return response()->json(MemberShipCard::all());
    }

    // POST /api/membership-cards
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'     => 'required|integer',
            'card_number' => 'required|string|unique:membership_cards,card_number',
            'card_type'   => 'required|in:silver,gold,platinum',
            'points'      => 'nullable|integer',
        ]);

        $card = MemberShipCard::create($validated);

        return response()->json([
            'message' => 'Thẻ thành viên đã được tạo',
            'data' => $card
        ], 201);
    }

    // GET /api/membership-cards/{id}
    public function show($id)
    {
        $card = MemberShipCard::find($id);

        if (!$card) {
            return response()->json(['message' => 'Không tìm thấy thẻ'], 404);
        }

        return response()->json($card);
    }

    // PUT /api/membership-cards/{id}
    public function update(Request $request, $id)
    {
        $card = MemberShipCard::find($id);

        if (!$card) {
            return response()->json(['message' => 'Không tìm thấy thẻ'], 404);
        }

        $validated = $request->validate([
            'card_number' => 'sometimes|string|unique:membership_cards,card_number,' . $id . ',card_id',
            'card_type'   => 'sometimes|in:silver,gold,platinum',
            'points'      => 'nullable|integer',
        ]);

        $card->update($validated);

        return response()->json([
            'message' => 'Thẻ đã được cập nhật',
            'data' => $card
        ]);
    }

    // DELETE /api/membership-cards/{id}
    public function destroy($id)
    {
        $card = MemberShipCard::find($id);

        if (!$card) {
            return response()->json(['message' => 'Không tìm thấy thẻ'], 404);
        }

        $card->delete();

        return response()->json(['message' => 'Đã xoá thẻ thành viên']);
    }

    // PATCH /api/membership-cards/{id}/points
    public function updatePoints(Request $request, $id)
    {
        $card = MemberShipCard::find($id);

        if (!$card) {
            return response()->json(['message' => 'Không tìm thấy thẻ'], 404);
        }

        $validated = $request->validate([
            'change' => 'required|integer',
        ]);

        $card->points += $validated['change'];
        $card->save();

        return response()->json([
            'message' => 'Điểm đã được cập nhật',
            'new_points' => $card->points,
        ]);
    }
}
