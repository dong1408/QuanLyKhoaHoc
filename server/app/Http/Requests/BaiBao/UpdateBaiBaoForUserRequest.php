<?php

namespace App\Http\Requests\BaiBao;

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
                "bail", "required",
                Rule::unique('san_phams')->ignore(Route::input('id'), 'id')
            ],
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

            "keyword" => "bail|nullable|array",
            "keyword.*.id_keyword" => [
                "bail", "nullable", "integer",
                Rule::exists("keywords", "id")
            ],
            "keyword.*.name" => "bail|required|string",

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
            'keyword.*.id_keyword.exists' => 'Keyword không tồn tại trên hệ thống',
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
