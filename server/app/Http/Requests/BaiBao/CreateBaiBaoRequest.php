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
            "sanpham.tongsotacgia" => "bail|required|integer",
            "sanpham.conhantaitro" => "bail|nullable|boolean",
            "sanpham.id_donvitaitro" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_to_chucs', 'id')
            ],
            "sanpham.chitietdonvitaitro" => "bail|nullable|string",
            "sanpham.thoidiemcongbohoanthanh" => "bail|required|string",

            // Thong tin chi tiet bai bao
            "doi" => "bail|nullable|string",
            "url" => "bail|nullable|string",
            "received" => "bail|nullable|string",
            "accepted" => "bail|nullable|string",
            "published" => "bail|nullable|string",
            "abstract" => "bail|nullable|string",

            "keywords" => "bail|nullable|array",
            "keywords.*.id_keyword" => [
                "bail", "nullable", "integer",
                Rule::exists("keywords", "id")
            ],
            "keywords.*.name" => "bail|required|string",

            "tapchi" => "bail|array",
            "tapchi.id_tapchi" => [
                "bail", "nullable", "integer",
                Rule::exists('tap_chis', 'id')
            ],
            "tapchi.name" => [
                "bail", "required", "string",
                Rule::unique('tap_chis', 'name')->where(function ($query) {
                    // Kiểm tra xem trường 'tapchi.id_tapchi' có giá trị null hay không
                    return request()->input('tapchi.id_tapchi') === null;
                })
            ],
            "tapchi.issn" => "bail|nullable|string",
            "tapchi.eissn" => "bail|nullable|string",
            "tapchi.pissn" => "bail|nullable|string",
            "tapchi.website" => "bail|nullable|string",

            "volume" => "bail|nullable|string",
            "issue" => "bail|nullable|string",
            "number" => "bail|nullable|string",
            "pages" => "bail|nullable|string",


            // // san pham _ tac gia            
            "sanpham_tacgia" => "bail|array",
            "sanpham_tacgia.*.id_tacgia" => [
                "bail", "nullable", "integer",
                Rule::exists("users", "id")
            ],
            "sanpham_tacgia.*.tentacgia" => "bail|required|string",
            "sanpham_tacgia.*.list_id_vaitro" => "bail|array",
            "sanpham_tacgia.*.list_id_vaitro.*" => [
                "bail", "required", "integer",
                Rule::exists("d_m_vai_tro_tac_gias", "id")
            ],
            "sanpham_tacgia.*.thutu" => "bail|nullable|integer",
            "sanpham_tacgia.*.tyledonggop" => "bail|nullable|integer",
            "sanpham_tacgia.*.ngaysinh" => "bail|nullable|string",
            "sanpham_tacgia.*.dienthoai" => "bail|nullable|string",
            "sanpham_tacgia.*.email" => [
                "bail", "required", "string",
                Rule::unique('users', 'email')->where(function ($query) {
                    return request()->input('sanpham_tacgia.*.id_tacgia') === null;
                })
            ],
            "sanpham_tacgia.*.id_hochamhocvi" => [
                "bail", "nullable", "integer",
                Rule::exists('d_m_hoc_ham_hoc_vis', 'id')
            ],
            "sanpham_tacgia.*.tochuc.id_tochuc" => [
                "bail", "nullable", "integer",
                Rule::exists("d_m_to_chucs", "id")
            ],
            "sanpham_tacgia.*.tochuc.matochuc" => [
                "bail", "required", "string",
                Rule::unique('d_m_to_chucs', 'matochuc')->where(function ($query) {
                    // Kiểm tra xem trường 'sanpham_tacgia.*.tochuc.id_tochuc' có giá trị null hay không
                    return request()->input('sanpham_tacgia.*.tochuc.id_tochuc') === null;
                })
            ],
            "sanpham_tacgia.*.tochuc.tentochuc" => "bail|required|string",

            // file minh chung san pham
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
            //
            'sanpham.tensanpham.unique' => 'Tên sản phẩm đã tồn tại trên hệ thống',
            'sanpham.id_donvitaitro.exists' => 'Đơn vị tài trợ không tồn tại trên hệ thống',
            'keywords.*.id_keyword.exists' => 'Keyword không tồn tại trên hệ thống',
            'tapchi.id_tapchi.exists' => 'Tạp chí không tồn tại trên hệ thống',
            'tapchi.name.unique' => 'Tên tạp chí đã tồn tại trên hệ thống',
            "sanpham_tacgia.*.id_tacgia.exists" => "Tác giả không tồn tại trên hệ thống",
            "sanpham_tacgia.*.list_id_vaitro.*.exists" => "Vai trò tác giả không tồn tại trên hệ thống",
            'sanpham_tacgia.*.email.unique' => 'Email đã tồn tại trên hệ thống',
            'sanpham_tacgia.*.tochuc.id_tochuc.exists' => "Tổ chức không tồn tại trên hệ thống",
            'sanpham_tacgia.*.tochuc.matochuc.unique' => "Mã tổ chức đã tồn tại trên hệ thống",
            "sanpham_tacgia.*.id_hochamhocvi.exists" => "Học hàm học vị không tồn tại trên hệ thống"
        ];
    }
}
