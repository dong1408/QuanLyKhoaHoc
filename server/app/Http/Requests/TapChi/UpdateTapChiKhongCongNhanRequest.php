<?php

namespace App\Http\Requests\TapChi;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTapChiKhongCongNhanRequest extends FormRequest
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
            "khongduoccongnhan" => "bail|nullable|boolean",
            "ghichu" => "bail|nullable|string",
        ];
    }

    public function messages(){
        return [
            'string' => 'Trường :attribute phải là một chuỗi chữ',
            'boolean' => 'Trường :attribute phải là true/false',
        ];
    }
}
