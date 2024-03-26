<?php

namespace App\Http\Requests\BaiBao;

use App\Rules\MatochucUniqueIfIdDonviNull;
use App\Rules\NameUniqueIfIdKeywordNull;
use App\Rules\NameUniqueIfIdTapchiNull;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Route;

class UpdateBaiBaoForUserRequest extends FormRequest
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

            // san pham
            "sanpham.tensanpham" => [
                "bail", "required", "string",
                Rule::unique('san_phams', 'tensanpham')->ignore(Route::input('id'), 'id')
            ],
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

        ];
    }


    public function validationData()
    {
        return array_merge($this->all(), [
            'id' => $this->route('id'),
        ]);
    }
}
