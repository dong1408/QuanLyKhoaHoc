<?php

namespace App\Http\Requests\SanPham;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class UpdateSanPhamRequest extends FormRequest
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
            "tensanpham" => [
                "bail", "required",
                Rule::unique('san_phams')->ignore(Route::input('id'), 'id')
            ],
//            "tongsotacgia" => "bail|required|integer",
            "solandaquydoi" => "bail|nullable|integer",
            "cosudungemailtruong" => "bail|nullable|boolean",
            "cosudungemaildonvikhac" => "bail|nullable|boolean",
            "cothongtintruong" => "bail|nullable|boolean",
            "cothongtindonvikhac" => "bail|nullable|boolean",
            "id_thongtinnoikhac" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_to_chucs', 'id')
            ],
            "conhantaitro" => "bail|nullable|boolean",
            "id_donvitaitro" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_to_chucs', 'id')
            ],
            "chitietdonvitaitro" => "bail|nullable|string",
            "ngaykekhai" => "bail|required|string",
            "diemquydoi" => "bail|nullable|string",
            "gioquydoi" => "bail|nullable|string",
            "thongtinchitiet" => "bail|nullable|string",
            "capsanpham" => "bail|nullable|string",
            "thoidiemcongbohoanthanh" => "bail|nullable|string",
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
            //            'id_loaisanpham.exists' => 'Danh mục sản phẩm không tồn tại trên hệ thông',
            'id_thongtinnoikhac.exists' => 'Thông tin nơi khác không tồn tại trên hệ thống',
            'id_donvitaitro.exists' => 'Thông tin đơn vị tài trợ không tồn tại trên hệ thống',
            //            'id_nguoikekhai.exists' => 'Thông tin người kê khai không tồn tại trên hệ thống',
            //            'id_nguoirasoat.exists' => 'Thông tin người rà soát không tồn tại trên hệ thống',
            'tensanpham.unique' => 'Tên sản phẩm đã tồn tại trên hệ thống',
        ];
    }


    public function validationData()
    {
        return array_merge($this->all(), [
            'id' => $this->route('id'),
        ]);
    }
}
