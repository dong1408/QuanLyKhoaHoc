<?php

namespace App\Http\Requests\TapChi;

use Illuminate\Foundation\Http\FormRequest;

class UpdateXepHangTapChiRequest extends FormRequest
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
            "wos" => "bail|nullable|string",
            "if" => "bail|nullable|string",
            "quartile" => "bail|nullable|string",
            "abs" => "bail|nullable|string",
            "abcd" => "bail|nullable|string",
            "aci" => "bail|nullable|string",
            "ghichu" => "bail|nullable|string",
        ];
    }

    public function  messages(){
        return [
            'string' => 'Trường :attribute phải là một chuỗi chữ'
        ];
    }
}
