<?php

namespace App\Http\Requests\Detai;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TuyenChonDeTaiRequest extends FormRequest
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
            "ketquatuyenchon" => [
                "bail", "required", "string",
                Rule::in(["Đủ điều kiện", "Không đủ điều kiện"])
            ],
            // "lydo" => "bail|nullable|string"
            "lydo" => [
                "bail",
                // Nếu ketquatuyenchon là "Không đủ điều kiện", lydo không được null
                Rule::requiredIf(function () {
                    return request()->ketquatuyenchon === "Không đủ điều kiện";
                }),
                "string"
            ]
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
            'requiredIf' => 'Trường :attribute bắt buộc phải nhập'
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), [
            'id' => $this->route('id'),
        ]);
    }
}
