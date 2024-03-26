<?php

namespace App\Http\Requests\TapChi;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateTapChiRequest extends FormRequest
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
            "name" => "bail|required|unique:tap_chis,name",
            "issn" => "bail|nullable|string",
            "eissn" => "bail|nullable|string",
            "pissn" => "bail|nullable|string",
            "website" => "bail|nullable|string",
            "quocte" => "bail|nullable|boolean",
            "id_nhaxuatban" => [
                "bail", "nullable", "integer",
                Rule::exists('nha_xuat_bans', 'id')
            ],
            "id_donvichuquan" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_to_chucs', 'id')
            ],
            "address" => "bail|nullable|string",
            "id_address_city" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_tinh_thanhs', 'id')
            ],
            "id_address_country" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_quoc_gias', 'id')
            ],
            "dmnganhtheohdgs" => "bail|nullable|array",
            "dmnganhtheohdgs.*" => [
                "integer",
                Rule::exists('d_m_nganh_theo_hdgs', 'id')
            ],
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Trường :attribute là bắt buộc',
            'integer' => 'Trường :attribute phải là một số',
            'array' => 'Trường :attribute phải là một mảng',
            'string' => 'Trường :attribute phải là một chuỗi chữ',
            'boolean' => 'Trường :attribute phải là true/false',
            'dmnganhtheohdgs.*.exists' => 'Danh mục ngành theo HDGS không tồn tại trên hệ thống',
            'dmphanloaitapchi.*.exists' => 'Danh mục phân loại tạp chí không tồn tại trên hệ thống',
            'tinhdiemtapchi.id_chuyennganhtinhdiem.exists' => 'Chuyên ngành tính điểm không tồn tại trong hệ thống',
            'tinhdiemtapchi.id_nganhtinhdiem.exists' => 'Ngành tính điểm không tồn tại trong hệ thống',
            'id_nhaxuatban.exists' => 'Nhà xuất bản không tồn tại trên hệ thống',
            'id_donvichuquan.exists' => 'Đơn vị chủ quản không tồn tại trên hệ thống',
            'id_address_city.exists' => 'Thành phố không tồn tại trên hệ thống',
            'id_address_country.exists' => 'Quốc gia không tồn tại trên hệ thống',
            'name.unique' => 'Tên tạp chí đã tồn tại trong hệ thống'
        ];
    }
}
