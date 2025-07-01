<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'genre_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'genre_name.required' => 'Tên thể loại là bắt buộc.',
            'genre_name.string' => 'Tên thể loại phải là chuỗi.',
            'genre_name.max' => 'Tên thể loại không được dài quá 255 ký tự.',
            'description.string' => 'Mô tả phải là chuỗi.',
        ];
    }
}
