<?php

namespace App\Http\Requests\UserInfo\ToChuc;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;


class UpdateToChucRequest extends FormRequest
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
            'id' => [
                "bail", "required", "integer",
                Rule::exists('d_m_to_chucs', 'id')
            ],

            "matochuc" => [
                "bail", "required", "string",
                Rule::unique('d_m_to_chucs', 'matochuc')->ignore(Route::input('id'), 'id')
            ],
            "tentochuc" => "bail|nullable|string",
            "tentochuc_en" => "bail|nullable|string",
            "website" => "bail|nullable|string",
            "dienthoai" => "bail|nullable|string",
            "address" => "bail|nullable|string",
            "id_address_city" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_tinh_thanhs', 'id')
            ],
            "id_address_country" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_quoc_gias', 'id')
            ],
            "id_phanloaitochuc" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_phan_loai_to_chucs', 'id')
            ],
        ];
    }


    public function messages()
    {
        return [
            'matochuc.unique' => 'Mã tổ chức đã tồn tại trên hệ thống',
            'required' => 'Trường :attribute là bắt buộc',
            'integer' => 'Trường :attribute phải là một số',
            'string' => 'Trường :attribute phải là một chuỗi chữ',
            'id_address_city.exists' => 'Tỉnh thành không tồn tại trong hệ thống',
            'id_address_country.exists' => 'Quốc gia không tồn tại trong hệ thống',
            'id_phanloaitochuc.exists' => 'Phân loại tổ chức không tồn tại trong hệ thống',
        ];
    }


    public function validationData()
    {
        return array_merge($this->all(), [
            'id' => $this->route('id'),
        ]);
    }
}
