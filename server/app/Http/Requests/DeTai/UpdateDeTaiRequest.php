<?php

namespace App\Http\Requests\Detai;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class UpdateDeTaiRequest extends FormRequest
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
                Rule::exists('san_phams', 'id')
            ],
            // "maso" => "bail|required|string|unique:de_tais,maso",
            "maso" => [
                "bail", "required", "string",
                Rule::unique('de_tais')->ignore(Route::input('id'), 'id_sanpham')
            ],
            "ngaydangky" => "bail|nullable|string",
            "ngoaitruong" => "bail|nullable|boolean",
            "truongchutri" => "bail|nullable|boolean",
            "id_tochucchuquan" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_to_chucs', 'id')
            ],
            "id_loaidetai" => [
                "bail", "nullable", "integer",
                Rule::exists('phan_loai_de_tais', 'id')
            ],
            "detaihoptac" => "bail|nullable|boolean",
            "id_tochuchoptac" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_to_chucs', 'id')
            ],
            "tylekinphidonvihoptac" => "bail|nullable|string",
            "capdetai" => "bail|nullable|string",
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
            'maso.unique' => 'Mã số đề tài đã tồn tại trên hệ thống'
            // 'sanphamtacgia.tacgias.*.exists' => 'Tác giả không tồn tại trên hệ thống',
            // 'sanphamtacgia.vaitros.*.exists' => 'Vai trò không tồn tại trên hệ thống'
        ];
    }



    public function validationData()
    {
        return array_merge($this->all(), [
            'id' => $this->route('id'),
        ]);
    }
}
