<?php

namespace App\Http\Requests\TapChi;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrangThaiTapChiRequest extends FormRequest
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
            "trangthai" => "required|boolean"
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Trường :attribute là bắt buộc',
            'boolean' => 'Trường :attribute phải là true/false'
        ];
    }
}
