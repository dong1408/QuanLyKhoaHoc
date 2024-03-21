<?php

namespace App\Http\Requests\Detai;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class NghiemThuDeTaiRequest extends FormRequest
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
            "ngaynghiemthu" => "bail|nullable|string",
            "ketquanghiemthu" => [
                "bail", "nullable", "string",
                Rule::in(["Đủ điều kiện", "Không đủ điều kiện"])
            ],
            "ngaycongnhanhoanthanh" => "bail|nullable|string",
            "soqdcongnhanhoanthanh" => "bail|nullable|string",
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Trường :attribute là bắt buộc',
            'integer' => 'Trường :attribute phải là một số',
            'string' => 'Trường :attribute phải là một chuỗi chữ',
            'id.exists' => 'Sản phẩm không tồn tại trên hệ thống'
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), [
            'id' => $this->route('id'),
        ]);
    }
}
