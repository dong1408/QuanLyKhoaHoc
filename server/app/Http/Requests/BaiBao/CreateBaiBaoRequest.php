<?php

namespace App\Http\Requests\BaiBao;

use App\Rules\EmailUniqueIfIdTacgiaNull;
use App\Rules\MatochucUniqueIfIdDonviNull;
use App\Rules\MatochucUniqueIfIdTochucNull;
use App\Rules\NameUniqueIfIdKeywordNull;
use App\Rules\NameUniqueIfIdTapchiNull;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

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

            "sanpham.donvi" => "bail|nullable",
            "sanpham.donvi.id_donvi" => [
                "bail", "nullable", "integer",
                Rule::exists("d_m_to_chucs", "id")
            ],
            "sanpham.donvi.tentochuc" => [
                "bail", "required_with:sanpham.donvi", "string",
                new MatochucUniqueIfIdDonviNull // với những tạp chí được kê khai thì cần phải check trường matochuc unique
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
            "keywords.*.name" => [
                "bail", "required_with:keywords", "string",
                new NameUniqueIfIdKeywordNull // với những keyword được kê khai thì cần phải check trường name unique            
            ],


            "tapchi" => "bail|required",
            "tapchi.id_tapchi" => [
                "bail", "nullable", "integer",
                Rule::exists('tap_chis', 'id')
            ],
            "tapchi.name" => [
                "bail", "required", "string",
                new NameUniqueIfIdTapchiNull  // với những tạp chí được kê khai thì cần phải check trường name unique 
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
            "sanpham_tacgia" => "bail|required|array",
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
                'required_if:sanpham_tacgia.*.id_tacgia,null', 'bail', 'nullable'
            ],
            "sanpham_tacgia.*.tochuc.id_tochuc" => [
                "bail", "nullable", "integer",
                Rule::exists("d_m_to_chucs", "id")
            ],

            "sanpham_tacgia.*.tochuc.tentochuc" => [
                'required_if:sanpham_tacgia.*.id_tacgia,null',
                "bail", "nullable", "string",
                function ($attribute, $value, $fail) {
                    foreach ($this->input('sanpham_tacgia') as $index => $sanphamTacGia) {
                        $idTacGia = $sanphamTacGia['id_tacgia'];
                        $idToChuc = null;
                        if ($sanphamTacGia['tochuc']) {
                            $idToChuc = $sanphamTacGia['tochuc']['id_tochuc'];
                        }

                        if (is_null($idTacGia) && is_null($idToChuc)) {
                            $exists = DB::table('d_m_to_chucs')
                                ->where('tentochuc', $sanphamTacGia['tochuc']['tentochuc'])
                                ->exists();

                            if ($exists) {
                                $fail("Tổ chức với tên là '{$sanphamTacGia['tochuc']['tentochuc']}' đã tồn tại trong hệ thống.");
                            }
                        }
                    }
                }
            ],

            // file minh chung san pham
            "fileminhchungsanpham.file" => "bail|required|string",
            "fileminhchungsanpham.id_file" => "bail|required|string",

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


            'keywords.*.id_keyword.exists' => 'Keyword không tồn tại trên hệ thống',
            'tapchi.id_tapchi.exists' => 'Tạp chí không tồn tại trên hệ thống',
            'tapchi.name.unique' => 'Tên tạp chí đã tồn tại trên hệ thống',
            "sanpham_tacgia.*.id_tacgia.exists" => "Tác giả không tồn tại trên hệ thống",
            "sanpham_tacgia.*.list_id_vaitro.*.exists" => "Vai trò tác giả không tồn tại trên hệ thống",
            'sanpham_tacgia.*.email.unique' => 'Email đã tồn tại trên hệ thống',
            'sanpham_tacgia.*.tochuc.id_tochuc.exists' => "Tổ chức không tồn tại trên hệ thống",
            // 'sanpham_tacgia.*.tochuc.matochuc.unique' => "Tổ chức đã tồn tại trên hệ thống",
            "sanpham_tacgia.*.id_hochamhocvi.exists" => "Học hàm học vị không tồn tại trên hệ thống"
        ];
    }
}
