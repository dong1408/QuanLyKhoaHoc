<?php

namespace App\Http\Requests\TapChi;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTinhDiemTapChiRequest extends FormRequest
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
            "id_nganhtinhdiem" => [
                "bail", "required", "integer",
                Rule::exists('d_m_nganh_tinh_diems', 'id')
            ],
            "id_chuyennganhtinhdiem" => [
                "bail", "required", "integer",
                Rule::exists('d_m_chuyen_nganh_tinh_diems', 'id')
            ],
            "diem" => "bail|nullable|string",
            "namtinhdiem" => "bail|nullable|string",
            "ghichu" => "bail|nullable|string",
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Trường :attribute là bắt buộc',
            'integer' => 'Trường :attribute phải là một số',
            'string' => 'Trường :attribute phải là một chuỗi chữ',
            'id_chuyennganhtinhdiem.exists' => 'Chuyên ngành tính điểm không tồn tại trong hệ thống',
            'id_nganhtinhdiem.exists' => 'Ngành tính điểm không tồn tại trong hệ thống',
        ];
    }
}
