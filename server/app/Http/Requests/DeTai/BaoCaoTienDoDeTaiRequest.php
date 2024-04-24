<?php

namespace App\Http\Requests\DeTai;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class BaoCaoTienDoDeTaiRequest extends FormRequest
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
            "id" => [
                "bail", "required", "integer",
                Rule::exists('san_phams', 'id')
            ],
            "tenbaocao" => "bail|required|string",
            "ngaynopbaocao" => "bail|required|string",
            "ketquaxet" => [
                "bail", "required", "string",
                Rule::in(["Đồng ý", "Không đồng ý"])
            ],
            "thoigiangiahan" => "bail|nullable|integer",
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Trường :attribute là bắt buộc',
            'integer' => 'Trường :attribute phải là một số',
            'string' => 'Trường :attribute phải là một chuỗi chữ',
            'id.exists' => 'Sản phẩm không tồn tại trên hệ thống',
            'in' => 'Trường :attribute phải là một trong các giá trị :values',
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), [
            'id' => $this->route('id'),
        ]);
    }
}
