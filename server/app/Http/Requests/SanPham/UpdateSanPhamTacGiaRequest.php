<?php

namespace App\Http\Requests\SanPham;

use App\Rules\EmailUniqueIfIdTacgiaNull;
use App\Rules\MatochucUniqueIfIdTochucNull;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            'id' => [
                "bail", "required", "integer",
                Rule::exists('san_phams', 'id')
            ],
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
            "sanpham_tacgia.*.tochuc" => [
                'required_if:sanpham_tacgia.*.id_tacgia,null','bail','nullable'
            ],
            "sanpham_tacgia.*.tochuc.id_tochuc" => [
                "bail", "nullable", "integer",
                Rule::exists("d_m_to_chucs", "id")
            ],
            "sanpham_tacgia.*.tochuc.matochuc" => [
                'required_if:sanpham_tacgia.*.id_tacgia,null',
                "bail", "nullable", "string",
                function ($attribute, $value, $fail) {
                    $index = key($this->input('sanpham_tacgia'));

                    // Truy xuất giá trị của chỉ số index cụ thể
                    $idTacGia = $this->input("sanpham_tacgia.$index.id_tacgia");
                    $idToChuc = $this->input("sanpham_tacgia.$index.tochuc.id_tochuc");
                    if (is_null($idTacGia) && is_null($idToChuc)) {
                        $exists = DB::table('d_m_to_chucs')
                            ->where('matochuc', $value)
                            ->exists();

                        if ($exists) {
                            $fail("Tổ chức với mã là '$value' đã tồn tại trong hệ thống.");
                        }
                    }
                }
            ],
            "sanpham_tacgia.*.tochuc.tentochuc" => "bail|nullable|string",


//            "sanpham_tacgia.*.tochuc" => "bail|nullable",
//            "sanpham_tacgia.*.tochuc.id_tochuc" => [
//                "bail", "nullable", "integer",
//                Rule::exists("d_m_to_chucs", "id")
//            ],
//            "sanpham_tacgia.*.tochuc.matochuc" => [
//                "bail", "nullable", "string",
//                Rule::unique("d_m_to_chucs", "matochuc")
//            ],
//            "sanpham_tacgia.*.tochuc.tentochuc" => "bail|nullable|string",
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
            "sanpham_tacgia.*.id_tacgia.exists" => "Tác giả không tồn tại trên hệ thống",
            "sanpham_tacgia.*.list_id_vaitro.*.exists" => "Vai trò tác giả không tồn tại trên hệ thống",
            'sanpham_tacgia.*.email.unique' => 'Email đã tồn tại trên hệ thống',
            'sanpham_tacgia.*.tochuc.id_tochuc.exists' => "Tổ chức không tồn tại trên hệ thống",
            'sanpham_tacgia.*.tochuc.matochuc.unique' => "Tổ chức đã tồn tại trên hệ thống",
            "sanpham_tacgia.*.id_hochamhocvi.exists" => "Học hàm học vị không tồn tại trên hệ thống"
        ];
    }


    public function validationData()
    {
        return array_merge($this->all(), [
            'id' => $this->route('id'),
        ]);
    }
}
