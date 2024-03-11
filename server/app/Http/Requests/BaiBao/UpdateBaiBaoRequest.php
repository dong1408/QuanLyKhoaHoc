<?php

namespace App\Http\Requests\BaiBao;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class UpdateBaiBaoRequest extends FormRequest
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
            // Thong tin chi tiet bai bao
            "doi" => "bail|nullable|string",
            "url" => "bail|nullable|string",
            "received" => "bail|nullable|string",
            "accepted" => "bail|nullable|string",
            "published" => "bail|nullable|string",
            "abstract" => "bail|nullable|string",
            "keywords" => "bail|nullable|string",
            "id_tapchi" => [
                "bail", "required", "integer",
                Rule::exists('tap_chis', 'id')
            ],
            "volume" => "bail|nullable|string",
            "issue" => "bail|nullable|string",
            "number" => "bail|nullable|string",
            "pages" => "bail|nullable|string",


            // san pham _ tac gia
            // "sanphamtacgia.tacgias" => 'bail|array',
            // "sanphamtacgia.tacgias.*" => [
            //     "int",
            //     Rule::exists("users", 'id')
            // ],

            // "sanphamtacgia.vaitro" => 'bail|array',
            // "sanphamtacgia.vaitros.*" => [
            //     "int",
            //     Rule::exists("d_m_vai_tro_tac_gias", 'id')
            // ],

            // "sanphamtacgia.thutu" => 'bail|array',
            // "sanphamtacgia.thutu.*" => 'bail|nullable|string',

            // "sanphamtacgia.tyledonggop" => 'bail|array',
            // "sanphamtacgia.tyledonggop.*" => 'bail|nullable|string'

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
            'id_tapchi.exists' => 'Thông tin tạp chí không tồn tại trên hệ thống',
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
