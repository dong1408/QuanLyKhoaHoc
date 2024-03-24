<?php

namespace App\Http\Requests\Detai;

use App\Rules\MatochucUniqueIfIdDonviNull;
use App\Rules\MatochucUniqueIfIdTochucchuquanNull;
use App\Rules\MatochucUniqueIfIdTochuchoptacNull;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class UpdateDeTaiForUserRequest extends FormRequest
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

            // ======================== san pham ====================== //
            "sanpham.tensanpham" => [
                "bail", "required", "string",
                Rule::unique('san_phams', 'tensanpham')->ignore(Route::input('id'), 'id')
            ],
            "sanpham.tongsotacgia" => "bail|required|integer",
            "sanpham.conhantaitro" => "bail|nullable|boolean",

            "sanpham.donvi" => "bail|nullable",
            "sanpham.donvi.id_donvi" => [
                "bail", "nullable", "integer",
                Rule::exists("d_m_to_chucs", "id")
            ],
            "sanpham.donvi.matochuc" => [
                "bail", "required_with:sanpham.donvi", "string",
                new MatochucUniqueIfIdDonviNull // với những đơn vị được kê khai thì cần phải check trường matochuc unique
            ],
            "sanpham.donvi.tentochuc" => [
                "bail", "required_with:sanpham.donvi", "string"
            ],
            "sanpham.chitietdonvitaitro" => "bail|nullable|string",
            // "sanpham.thoidiemcongbohoanthanh" => "bail|required|string",


            // =========== Thong tin chi tiet de tai ================ //            
            "maso" => [
                "bail", "required", "string",
                Rule::unique('de_tais')->ignore(Route::input('id'), 'id_sanpham')
            ],
            "ngoaitruong" => "bail|nullable|boolean",
            "truongchutri" => "bail|nullable|boolean",


            "tochucchuquan" => "bail|nullable",
            "tochucchuquan.id_tochucchuquan" => [
                "bail", "nullable", "integer",
                Rule::exists("d_m_to_chucs", "id")
            ],
            "tochucchuquan.matochuc" => [
                "bail", "required_with:tochucchuquan", "string",
                new MatochucUniqueIfIdTochucchuquanNull
            ],
            "tochucchuquan.tentochuc" => [
                "bail", "required_with:tochucchuquan", "string"
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
                "bail", "required_with", "string",
                new MatochucUniqueIfIdTochuchoptacNull
            ],
            "tochuchoptac.tentochuc" => [
                "bail", "required_with", "string"
            ],
            "tylekinhphidonvihoptac" => "bail|nullable|string",
            "capdetai" => "bail|nullable|string",
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
            'id_tochucchuquan.exists' => 'Thông tin tạp chí không tồn tại trên hệ thống',
            'id_loaidetai.exists' => 'Thông tin tạp chí không tồn tại trên hệ thống',
            'id_tochuchoptac.exists' => 'Thông tin tạp chí không tồn tại trên hệ thống',
        ];
    }

    public function validationData()
    {
        return array_merge($this->all(), [
            'id' => $this->route('id'),
        ]);
    }
}
