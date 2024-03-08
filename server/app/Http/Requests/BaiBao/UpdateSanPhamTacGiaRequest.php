<?php

namespace App\Http\Requests\BaiBao;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateSanPhamTacGiaRequest extends FormRequest
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
            "tacgias" => 'bail|array',
            "tacgias.*" => [
                "int",
                Rule::exists("users", 'id')
            ],

            "vaitro" => 'bail|array',
            "vaitros.*" => [
                "int",
                Rule::exists("d_m_vai_tro_tac_gias", 'id')
            ],

            "thutu" => 'bail|array',
            "thutu.*" => 'bail|nullable|string',

            "tyledonggop" => 'bail|array',
            "tyledonggop.*" => 'bail|nullable|string'
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
            'tacgias.*.exists' => 'Tác giả không tồn tại trên hệ thống',
            'vaitros.*.exists' => 'Vai trò không tồn tại trên hệ thống'
        ];
    }


    public function validationData()
    {
        return array_merge($this->all(), [
            'id' => $this->route('id'),
        ]);
    }
}
