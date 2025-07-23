<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
public function index()
{
    $users = User::with('role')->latest()->paginate(10);
    $roles = Role::all();
    
    return view('admin.list.user', compact('users', 'roles'));
}

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $roles = Role::select('role_id', 'name')->get();
        return view('admin.edit.user', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $data = $request->validate([
            'username' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->user_id . ',user_id',
            'phone' => 'nullable|string|max:20',
            'role_id' => 'required|exists:roles,role_id',
            'password' => 'nullable|string|min:6|confirmed',
            'status' => 'nullable|boolean', // status là checkbox
        ]);

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        $data['status'] = $request->has('status') ? 'active' : 'inactive';

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Cập nhật người dùng thành công!');
    }


    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
