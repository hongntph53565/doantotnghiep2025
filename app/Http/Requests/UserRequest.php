<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'username'   => 'required|string|max:50|unique:users,username',
            'full_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255|unique:users,email',
            'password'   => 'required|string|min:8|confirmed',
            'phone'      => 'nullable|string|max:15',
            'role'       => 'required|in:user,admin,staff',
        ];
    }

    public function messages()
    {
        return [
            'username.required' => 'Tên đăng nhập là bắt buộc.',
            'username.string'   => 'Tên đăng nhập phải là chuỗi.',
            'username.max'      => 'Tên đăng nhập không được vượt quá 50 ký tự.',
            'username.unique'   => 'Tên đăng nhập đã tồn tại.',

            'full_name.required' => 'Họ và tên là bắt buộc.',
            'full_name.string'   => 'Họ và tên phải là chuỗi.',
            'full_name.max'      => 'Họ và tên không được vượt quá 255 ký tự.',

            'email.required' => 'Email là bắt buộc.',
            'email.email'    => 'Email không đúng định dạng.',
            'email.max'      => 'Email không được vượt quá 255 ký tự.',
            'email.unique'   => 'Email đã tồn tại.',

            'password.required'  => 'Mật khẩu là bắt buộc.',
            'password.string'    => 'Mật khẩu phải là chuỗi.',
            'password.min'       => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',

            'phone.string' => 'Số điện thoại phải là chuỗi.',
            'phone.max'    => 'Số điện thoại không được vượt quá 15 ký tự.',

            'role.required' => 'Vai trò là bắt buộc.',
            'role.in'       => 'Vai trò không hợp lệ. Chỉ chấp nhận user, admin hoặc staff.',
        ];
    }
}
