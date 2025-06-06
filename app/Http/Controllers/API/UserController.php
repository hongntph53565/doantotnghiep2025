<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;


class UserController extends Controller
{
    // Lấy danh sách user
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    // Lấy chi tiết 1 user
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['message' => 'User not found'], 404);
        return response()->json($user, 200);
    }

    // Tạo mới user
    public function store(UserRequest $request)
    {
        $user = User::create([
            'username' => $request->username,
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role ?? 2,
        ]);

        return response()->json($user, 201);
    }

    // Cập nhật user
    public function update(UserRequest $request, $id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['message' => 'User not found'], 404);

        $user->update($request->only([
            'username',
            'full_name',
            'email',
            'phone',
            'role'
        ]));

        return response()->json($user, 200);
    }

    // Xoá user
    public function delete($id)
    {
        $user = User::find($id);
        if (!$user) return response()->json(['message' => 'User not found'], 404);
        $user->delete();
        return response()->json(['message' => 'User deleted'], 200);
    }
}
