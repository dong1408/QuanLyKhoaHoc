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
        return false;
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
            "hoidongnghiemthu" => "bail|required|string",
            "ngaynghiemthu" => "bail|nullable|string",
            "ketquanghiemthu" => "bail|nullable|string",
            "ngaycongnhanhoanthanh" => "bail|nullable|string",
            "soqdcongnhanhoanthanh" => "bail|nullable|string",
            "thoigiangiahan" => "bail|nullable|string",
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
