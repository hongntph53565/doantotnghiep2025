<?php


namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use Symfony\Component\HttpFoundation\Response;



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

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy người dùng.'
            ], Response::HTTP_NOT_FOUND);
        }

        $user->delete(); // Xóa mềm

        return response()->json([
            'status' => 'success',
            'message' => 'Người dùng đã được xóa mềm thành công.',
            'data' => [
                'id' => $user->user_id,
                'username' => $user->username,
                'email' => $user->email,
            ]
        ], Response::HTTP_OK);
    }
    public function restore($id)
    {
        $user = User::withTrashed()->find($id);

        if (!$user || !$user->trashed()) {
            return response()->json([
                'message' => 'Người dùng không tồn tại hoặc chưa bị xóa'
            ], Response::HTTP_NOT_FOUND);
        }

        $user->restore();

        return response()->json([
            'message' => 'Khôi phục người dùng thành công'
        ], Response::HTTP_OK);
    }

    public function forceDelete($id)
    {
        $user = User::withTrashed()->find($id);
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Không tìm thấy người dùng.'
            ], Response::HTTP_NOT_FOUND);
        }

        $user->forceDelete();

        return response()->json([
            'status' => 'success',
            'message' => 'Người dùng đã được xóa vĩnh viễn khỏi hệ thống.',
            'data' => [
                'id' => $user->user_id ?? $user->id,
                'username' => $user->username,
                'email' => $user->email,
            ]
        ], Response::HTTP_OK);
    }
}
