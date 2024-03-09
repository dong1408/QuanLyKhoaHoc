<?php

namespace App\Http\Requests\BaiBao;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateBaiBaoRequest extends FormRequest
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
            // san pham
            "sanpham.tensanpham" => "bail|required|unique:san_phams,tensanpham",
//            "sanpham.id_loaisanpham" => [
//                "bail", "integer",
//                Rule::exists('d_m_san_phams', 'id')
//            ],
            "sanpham.tongsotacgia" => "bail|required|integer",
            "sanpham.solandaquydoi" => "bail|required|integer",
            "sanpham.cosudungemailtruong" => "bail|nullable|boolean",
            "sanpham.cosudungemaildonvikhac" => "bail|nullable|boolean",
            "sanpham.cothongtintruong" => "bail|nullable|boolean",
            "sanpham.cothongtindonvikhac" => "bail|nullable|boolean",
            "sanpham.id_thongtinnoikhac" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_to_chucs', 'id')
            ],
            "sanpham.conhantaitro" => "bail|nullable|boolean",
            "sanpham.id_donvitaitro" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_to_chucs', 'id')
            ],
            "sanpham.chitietdonvitaitro" => "bail|nullable|string",
            "sanpham.ngaykekhai" => "bail|required|string",
            "sanpham.id_nguoikekhai" => [
                "bail", "required", "integer",
                Rule::exists('users', 'id')
            ],
            "sanpham.diemquydoi" => "bail|required|string",
            "sanpham.gioquydoi" => "bail|required|string",
            "sanpham.thongtinchitiet" => "bail|required|string",
            "sanpham.capsanpham" => "bail|required|string",
            "sanpham.thoidiemcongbohoanthanh" => "bail|required|string",

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


            // // san pham _ tac gia            
            "sanpham_tacgia" => "bail|array",
            "sanpham_tacgia.*.id_tacgia" => [
                "bail", "required", "int",
                Rule::exists("users", "id")
            ],
            "sanpham_tacgia.*.id_vaitro" => [
                "bail", "required", "int",
                Rule::exists("d_m_vai_tro_tac_gias", "id")
            ],
            "sanpham_tacgia.*.thutu" => "bail|nullable|string",
            "sanpham_tacgia.*.tyledonggop" => "bail|nullable|string",

            // file minh chung san pham
            "fileminhchungsanpham.loaiminhchung" => "bail|nullable|string",
            "fileminhchungsanpham.url" => "bail|required|string"
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
//            'sanpham.id_loaisanpham.exists' => 'Danh mục sản phẩm không tồn tại trên hệ thông',
            'sanpham.id_thongtinnoikhac.exists' => 'Thông tin nơi khác không tồn tại trên hệ thống',
            'sanpham.id_donvitaitro.exists' => 'Thông tin đơn vị tài trợ không tồn tại trên hệ thống',
            'sanpham.id_nguoikekhai.exists' => 'Thông tin người kê khai không tồn tại trên hệ thống',
            'id_tapchi.exists' => 'Thông tin tạp chí không tồn tại trên hệ thống',
            'sanpham.tensanpham.unique' => 'Tên sản phẩm đã tồn tại trên hệ thống',
            "sanpham_tacgia.*.id_tacgia.exists" => "Tác giả không tồn tại trên hệ thống",
            "sanpham_tacgia.*.id_vaitro.exists" => "Vai trò tác giả không tồn tại trên hệ thống"
        ];
    }
}
