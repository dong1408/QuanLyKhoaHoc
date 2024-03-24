<?php

namespace App\Http\Requests\Detai;

use App\Rules\EmailUniqueIfIdTacgiaNull;
use App\Rules\MatochucUniqueIfIdDonviNull;
use App\Rules\MatochucUniqueIfIdTochucchuquanNull;
use App\Rules\MatochucUniqueIfIdTochuchoptacNull;
use App\Rules\MatochucUniqueIfIdTochucNull;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateDeTaiRequest extends FormRequest
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
            // ======================== san pham ====================== //
            "sanpham.tensanpham" => "bail|required|unique:san_phams,tensanpham",
            "sanpham.tongsotacgia" => "bail|required|integer",
            "sanpham.conhantaitro" => "bail|nullable|boolean",
            "sanpham.donvi" => "bail|nullable",
            "sanpham.donvi.id_donvi" => [
                "bail", "nullable", "integer",
                Rule::exists("d_m_to_chucs", "id")
            ],
            "sanpham.donvi.matochuc" => [
                "bail", "nullable", "string",
                new MatochucUniqueIfIdDonviNull // với những tạp chí được kê khai thì cần phải check trường matochuc unique
            ],
            "sanpham.donvi.tentochuc" => [
                "bail", "nullable", "string"
            ],
            "sanpham.chitietdonvitaitro" => "bail|nullable|string",


            // =========== Thong tin chi tiet de tai ================ //            
            "maso" => "bail|required|string|unique:de_tais,maso",
            "ngoaitruong" => "bail|nullable|boolean",
            "truongchutri" => "bail|nullable|boolean",


            "tochucchuquan" => "bail|nullable",
            "tochucchuquan.id_tochucchuquan" => [
                "bail", "nullable", "integer",
                Rule::exists("d_m_to_chucs", "id")
            ],
            "tochucchuquan.matochuc" => [
                "bail", "nullable", "string",
                new MatochucUniqueIfIdTochucchuquanNull
            ],
            "tochucchuquan.tentochuc" => [
                "bail", "nullable", "string"
            ],


            "id_loaidetai" => [
                "bail", "nullable", "integer",
                Rule::exists('phan_loai_de_tais', 'id')
            ],


            "detaihoptac" => "bail|nullable|boolean",
            "tochuchoptac.id_tochuchoptac" => [
                "bail", "nullable", "integer",
                Rule::exists("d_m_to_chucs", "id")
            ],
            "tochuchoptac.matochuc" => [
                "bail", "nullable", "string",
                new MatochucUniqueIfIdTochuchoptacNull
            ],
            "tochuchoptac.tentochuc" => [
                "bail", "nullable", "string"
            ],
            "tylekinhphidonvihoptac" => "bail|nullable|string",
            "capdetai" => "bail|nullable|string",



            // ================= san pham _ tac gia ================ //                
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
                new EmailUniqueIfIdTacgiaNull
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
                new MatochucUniqueIfIdTochucNull
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
            "sanpham.donvi.id_donvi.exists" => "Đơn vị tài trợ không tồn tại trên hệ thống",

            'tochucchuquan.id_tochuchuquan.exists' => 'Thông tin tổ chức chủ quản không tồn tại trên hệ thống',
            'tochuchoptac.id_tochuchoptac.exists' => 'Thông tin tổ chức hợp tác không tồn tại trên hệ thống',
            'id_loaidetai.exists' => 'Thông tin tạp chí không tồn tại trên hệ thống',

            "sanpham_tacgia.*.id_tacgia.exists" => "Tác giả không tồn tại trên hệ thống",
            "sanpham_tacgia.*.list_id_vaitro.*.exists" => "Vai trò tác giả không tồn tại trên hệ thống",
            'sanpham_tacgia.*.email.unique' => 'Email đã tồn tại trên hệ thống',
            'sanpham_tacgia.*.tochuc.id_tochuc.exists' => "Tổ chức không tồn tại trên hệ thống",
            'sanpham_tacgia.*.tochuc.matochuc.unique' => "Mã tổ chức đã tồn tại trên hệ thống",
            "sanpham_tacgia.*.id_hochamhocvi.exists" => "Học hàm học vị không tồn tại trên hệ thống"
        ];
    }
}
