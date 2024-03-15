<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "passwordcurrent" => "bail|required|string",
            "password" => 'bail|required|confirmed|string|min:6',
            "password_confirmation" => 'bail|required|string|min:6'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Trường :attribute là bắt buộc',
            'integer' => 'Trường :attribute phải là một số',
            'confirmed' => 'Mật khẩu không trùng khớp',
            'string' => 'Trường :attribute phải là một chuỗi chữ',
        ];
    }
}
